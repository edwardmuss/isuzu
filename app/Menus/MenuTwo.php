<?php

namespace App\Menus;

use App\Helpers\USSDHelper;
use App\Contracts\MenuHandlerInterface;
use App\Models\Admin\VehicleSeriesModel;

class MenuTwo implements MenuHandlerInterface
{

    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string
    {
        $level = count($textArray);
        $response = ""; // Ensure response is initialized

        if ($level == 1) {
            $response = $this->displaySeriesMenu();
        } elseif ($level == 2 && isset($textArray[1])) {
            $seriesList = VehicleSeriesModel::select('series')->distinct()->get();
            $selectedSeriesIndex = (int)$textArray[1] - 1;

            if (isset($seriesList[$selectedSeriesIndex])) {
                $seriesName = $seriesList[$selectedSeriesIndex]->series;
                $sessionData['series'] = $seriesName;
                $response = $this->displayModelsMenu($seriesName);
            } else {
                $response = "END Invalid series selection. Please try again.";
            }
        } elseif ($level == 3 && isset($textArray[2])) {
            $seriesName = $sessionData['series'] ?? null;

            if ($seriesName) {
                $models = VehicleSeriesModel::where('series', $seriesName)->get();
                $selectedModelIndex = (int)$textArray[2] - 1;

                if (isset($models[$selectedModelIndex])) {
                    $model = $models[$selectedModelIndex];
                    $sessionData['model'] = $model;
                    $response = "CON Enter your name:\n";
                    $response .= "0: Back\n";
                } else {
                    $response = "END Invalid model selection. Please try again.";
                }
            } else {
                $response = "END Session expired. Please start again.";
            }
        } elseif ($level == 4 && isset($textArray[3])) {
            $name = trim($textArray[3]);

            if (strlen($name) < 2 || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $response = "CON Invalid name. Please enter a valid name:\n";
                $response .= "0: Back\n";
            } else {
                $sessionData['name'] = $name;
                $response = "CON Enter your email address:\n";
                $response .= "0: Back\n";
            }
        } elseif ($level == 5 && isset($textArray[4])) {
            $email = trim($textArray[4]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response = "CON Invalid email address. Please enter a valid email:\n";
                $response .= "0: Back\n";
            } else {
                $sessionData['email'] = $email;
                $response = "CON Enter your location:\n";
                $response .= "0: Back\n";
            }
        } elseif ($level == 6 && isset($textArray[5])) {
            $location = trim($textArray[5]);

            if (strlen($location) < 2 || !preg_match("/^[a-zA-Z\s]+$/", $location)) {
                $response = "CON Invalid location name. Please enter a valid location name:\n";
                $response .= "0: Back\n";
            } else {
                $sessionData['location'] = $location;
                $model = (object)$sessionData['model'];
                $name = $sessionData['name'];
                $email = $sessionData['email'];
                $description = $model->description;
                $image = $model->photo;

                $title = $model->new_model_name_customer;
                $subject = "Test Drive - $title";

                $sms = "Dear <b>$name</b>,\nThank you for showing interest in $title, your request for a test drive has been received and we will get back to you shortly.";
                USSDHelper::sendMessage($phoneNumber, $sms);
                $body = "Dear $name,<br/><br/>Thank you for showing interest in the <b>$title</b>.<br/><br/>Your request for a test drive has been received and we will get back to you shortly.<br/>";
                USSDHelper::sendTestDriveEmail($email, $name, $phoneNumber, $title, $subject, $body, $location);

                return "END Dear $name,\nThank you for showing interest in $title. Your request to book a test drive has been received and we will get back to you shortly.";

                $response = "END Thank you {$name}! We will send a quotation for {$model->new_model_name_customer} to {$email} shortly.";
            }
        } else {
            $response = "END Invalid input. Please try again.";
        }

        return $response; // Return the response
    }


    // Function to display the vehicle series sub-menu
    function displaySeriesMenu()
    {
        $seriesList = VehicleSeriesModel::select('series')->distinct()->get();
        $response = "CON Choose a Vehicle Series: \n\n";
        $index = 1;

        foreach ($seriesList as $series) {
            $response .= "$index. {$series->series}\n";
            $index++;
        }

        $response .= "0: Back\n";
        $response .= "#: Main Menu\n";
        return $response;
    }

    // Function to display the models sub-menu
    function displayModelsMenu($seriesName)
    {
        $models = VehicleSeriesModel::where('series', $seriesName)->where('status', true)->get();

        if ($models->isEmpty()) {
            return "END No models available for this series.";
        }

        // Reset collection keys to ensure correct indexing
        $models = $models->values();

        $response = "CON Choose a Model: \n\n";
        foreach ($models as $index => $model) {
            $response .= ($index + 1) . ". " . $model->new_model_name_customer . "\n";
        }
        $response .= "0: Back\n";
        return $response;
    }

    // Function to handle model selection
    function handleModelSelection(array $textArray, array &$sessionData, string $seriesName)
    {
        $models = VehicleSeriesModel::where('series', $seriesName)->where('status', true)->get()->values();

        $selectedModelIndex = (int)$textArray[2] - 1;

        if (isset($models[$selectedModelIndex])) {
            $model = $models[$selectedModelIndex];
            $sessionData['model'] = $model;
            return "CON Enter your name:\n";
        }

        return "END Invalid model selection. Please try again.";
    }
}
