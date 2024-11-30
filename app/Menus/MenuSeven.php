<?php

namespace App\Menus;

use App\Helpers\USSDHelper;
use App\Contracts\MenuHandlerInterface;
use App\Models\Admin\VehicleSeriesModel;

class MenuSeven implements MenuHandlerInterface
{
    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string
    {
        $level = count($textArray);
        $response = "";

        switch ($level) {
            case 1:
                $response = $this->displaySeriesMenu();
                break;

            case 2:
                $response = $this->handleSeriesSelection($textArray[1], $sessionData);
                break;

            case 3:
                $response = $this->handleModelSelection($textArray[2], $sessionData);
                break;

            case 4:
                $response = $this->handleNameInput($textArray[3], $sessionData);
                break;

            case 5:
                $response = $this->handleEmailInput($textArray[4], $sessionData, $phoneNumber);
                break;

            default:
                $response = "END Invalid input. Please try again.";
        }

        return $response;
    }

    private function displaySeriesMenu(): string
    {
        $seriesList = VehicleSeriesModel::select('series')
            ->distinct()
            ->where('status', true) // Include only active series
            ->get();

        if ($seriesList->isEmpty()) {
            return "END No active vehicle series available.";
        }

        $response = "CON Brochure Request: Choose a Vehicle Series: \n\n";
        foreach ($seriesList as $index => $series) {
            $response .= ($index + 1) . ". {$series->series}\n";
        }
        $response .= "0: Back\n#: Main Menu\n";

        return $response;
    }

    private function handleSeriesSelection(string $input, array &$sessionData): string
    {
        $seriesList = VehicleSeriesModel::select('series')
            ->distinct()
            ->where('status', true) // Include only active series
            ->get();

        $selectedIndex = (int)$input - 1;

        if (isset($seriesList[$selectedIndex])) {
            $seriesName = $seriesList[$selectedIndex]->series;
            $sessionData['series'] = $seriesName;
            return $this->displayModelsMenu($seriesName);
        }

        return "END Invalid series selection. Please try again.";
    }

    private function displayModelsMenu(string $seriesName): string
    {
        $models = VehicleSeriesModel::where('series', $seriesName)
            ->whereNotNull('brochure')
            ->where('brochure', '<>', '')
            ->where('status', true) // Ensure model is active
            ->get();

        if ($models->isEmpty()) {
            return "END No models with brochures available for this series.";
        }

        $response = "CON Choose a Model with a Brochure: \n\n";
        foreach ($models as $index => $model) {
            $response .= ($index + 1) . ". {$model->new_model_name_customer}\n";
        }
        $response .= "0: Back\n";

        return $response;
    }

    private function handleModelSelection(string $input, array &$sessionData): string
    {
        $seriesName = $sessionData['series'] ?? null;

        if (!$seriesName) {
            return "END Session expired. Please start again.";
        }

        $models = VehicleSeriesModel::where('series', $seriesName)
            ->whereNotNull('brochure')
            ->where('brochure', '<>', '')
            ->where('status', true) // Ensure model is active
            ->get();

        $selectedIndex = (int)$input - 1;

        if (isset($models[$selectedIndex])) {
            $sessionData['model'] = $models[$selectedIndex];
            return "CON Enter your name:\n0: Back\n";
        }

        return "END Invalid model selection. Please try again.";
    }

    private function handleNameInput(string $input, array &$sessionData): string
    {
        $name = trim($input);

        if (strlen($name) < 2 || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
            return "CON Invalid name. Please enter a valid name:\n0: Back\n";
        }

        $sessionData['name'] = $name;
        return "CON Enter your email address:\n0: Back\n";
    }

    private function handleEmailInput(string $input, array &$sessionData, string $phoneNumber): string
    {
        $email = trim($input);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "CON Invalid email address. Please enter a valid email:\n0: Back\n";
        }

        $sessionData['email'] = $email;
        $model = (object) $sessionData['model'] ?? null;

        if (!$model) {
            return "END Session expired. Please start again.";
        }

        $this->sendBrochure($sessionData, $phoneNumber);

        return "END Thank you {$sessionData['name']}! A brochure for {$model->new_model_name_customer} has been sent to {$email}.";
    }

    private function sendBrochure(array $sessionData, string $phoneNumber): void
    {
        $model = (object)$sessionData['model'];
        $name = $sessionData['name'];
        $email = $sessionData['email'];
        $brochureLink = asset('storage/' . $model->brochure);

        // Sending SMS
        $sms = "Thank you $name, We have received your Isuzu {$model->new_model_name_customer} brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phoneNumber, $sms);

        // Sending Email
        $subject = "{$model->new_model_name_customer} Brochure";
        $body = "Dear $name,<br/><br/>
                 Thank you for reaching out to us and expressing interest in the {$model->new_model_name_customer}.<br/><br/>
                 Herein attached is a copy of your <strong>{$model->new_model_name_customer}</strong> brochure for your review.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phoneNumber, $subject, $body, $brochureLink);
    }
}
