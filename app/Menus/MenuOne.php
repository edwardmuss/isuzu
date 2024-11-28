<?php

namespace App\Menus;

use App\Helpers\USSDHelper;
use App\Contracts\MenuHandlerInterface;
use App\Models\Admin\VehicleSeriesModel;

class MenuOne implements MenuHandlerInterface
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

                $model = (object)$sessionData['model'];
                $name = $sessionData['name'];
                $description = $model->description;
                $image = $model->photo;
                USSDHelper::sendQuoteMessage($phoneNumber, $model, $name, $email);
                USSDHelper::sendEmail($email, $name, $phoneNumber, $model, $image, $description);

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
        $models = VehicleSeriesModel::where('series', $seriesName)->get();

        if ($models->isEmpty()) {
            return "END No models available for this series.";
        }

        $response = "CON Choose a Model: \n\n";
        foreach ($models as $index => $model) {
            $response .= ($index + 1) . ". " . $model->new_model_name_customer . "\n";
        }
        $response .= "0: Back\n";
        return $response;
    }
}
