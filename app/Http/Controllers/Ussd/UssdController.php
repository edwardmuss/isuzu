<?php

namespace App\Http\Controllers\Ussd;

use Exception;
use App\Helpers\USSDHelper;
use App\Models\UssdSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Contracts\MenuHandlerInterface;
use App\Models\Admin\VehicleSeriesModel;

class UssdController extends Controller
{
    public function index(Request $request)
    {
        try {
            $ussd_string = $request->ussd_string ?? $request->USSD_STRING;
            $msisdn = $request->MSISDN ?? $request->msisdn;
            $code = $request->service_code ?? $request->SERVICE_CODE;
            $session_id = $request->session_id ?? $request->SESSION_ID;

            $sessionId = $request->input('sessionId');
            $serviceCode = $request->input('serviceCode');
            $phoneNumber = $request->input('phoneNumber');
            $text = $request->input('text'); // This will contain the user input

            // $page = USSDHelper::processUssd($text, $phoneNumber, $serviceCode, $sessionId);
            $page = USSDHelper::processUssd($ussd_string, $msisdn, $code, $session_id);

            Log::info($request->all());
            return $page;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    function handleUssdRequest(Request $request)
    {
        // header('Content-type: text/plain');

        $text = $request->input('ussd_string') ?? $request->input('USSD_STRING') ?? $request->input('text');
        $phoneNumber = $request->input('msisdn') ?? $request->input('MSISDN') ?? $request->input('phoneNumber');
        $sessionId = $request->input('session_id') ?? $request->input('SESSION_ID') ?? $request->input('sessionId');

        // Retrieve or create session
        $ussdSession = UssdSession::firstOrCreate(
            ['session_id' => $sessionId],
            ['phone_number' => $phoneNumber, 'data' => json_encode([])]
        );

        $sessionData = json_decode($ussdSession->data, true);
        $response = "";

        // Split the input text into an array
        $textArray = explode('*', $text);
        if (count($textArray) === 1 && $textArray[0] === "") {
            // Treat this as empty and reset to the main menu
            $textArray = [];
        }

        // Handle "Back" and "Reset"
        $textArray = USSDHelper::backMenu($textArray);
        $textArray = USSDHelper::mainMenu($textArray);

        // If textArray is empty, reset and show the main menu
        if (empty($textArray)) {
            // Reset detected, clear session data and show main menu
            $sessionData = []; // Clear session data
            $ussdSession->data = json_encode($sessionData);
            $ussdSession->save();
            $response = USSDHelper::displayMainMenu(); // Display main menu
        } else {
            // Dynamically call the menu handler based on the first menu option
            $menuOption = $textArray[0] ?? null;
            Log::info("Menu Option: {$menuOption}");

            if (is_numeric($menuOption) && $menuOption >= 1) {
                $menuClass = "App\\Menus\\Menu" . ucfirst(USSDHelper::convertNumberToWord($menuOption));
                Log::info("Menu Handler: {$menuClass}");
                if (class_exists($menuClass)) {
                    $menuHandler = new $menuClass;

                    if ($menuHandler instanceof MenuHandlerInterface) {
                        $response = $menuHandler->handle($textArray, $sessionData, $phoneNumber);
                    } else {
                        $response = "END Menu handler for {$menuOption} is not valid.";
                    }
                } else {
                    $response = "END Menu {$menuOption} not implemented.";
                }
            } else {
                // If it's not a valid menu option, return an invalid selection message
                $response = "END Invalid menu selection.";
            }
        }

        // Save the session data
        $ussdSession->data = json_encode($sessionData);
        $ussdSession->save();

        return $response;
    }

    function handleUssdRequest2(Request $request)
    {
        header('Content-type: text/plain');

        $text = $request->input('ussd_string') ?? $request->input('USSD_STRING') ?? $request->input('text');
        $phoneNumber = $request->input('msisdn') ?? $request->input('MSISDN') ?? $request->input('phoneNumber');
        $sessionId = $request->input('session_id') ?? $request->input('SESSION_ID') ?? $request->input('sessionId');

        $ussdSession = UssdSession::firstOrCreate(
            ['session_id' => $sessionId],
            ['phone_number' => $phoneNumber, 'data' => json_encode([])]
        );

        $sessionData = json_decode($ussdSession->data, true);
        $response = "";

        $textArray = explode('*', $text);

        // Handle "Back" and "Reset"
        $textArray =  USSDHelper::backMenu($textArray);
        $textArray = USSDHelper::mainMenu($textArray);

        if (empty($textArray)) {
            // Reset detected, clear session data and show main menu
            $sessionData = []; // Clear session data
            $ussdSession->data = json_encode($sessionData);
            $ussdSession->save();
            $response =  USSDHelper::displayMainMenu();
        } else {
            $level = count($textArray);

            switch ($textArray[0]) {
                case "1": // Vehicle Sales Menu
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
                                $response = "CON Enter your name:";
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
                            $response = "CON Invalid name. Please enter a valid name:";
                            $response .= "0: Back\n";
                        } else {
                            $sessionData['name'] = $name;
                            $response = "CON Enter your email address:";
                            $response .= "0: Back\n";
                        }
                    } elseif ($level == 5 && isset($textArray[4])) {
                        $email = trim($textArray[4]);

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $response = "CON Invalid email address. Please enter a valid email:";
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
                    break;

                default:
                    $response = "END Invalid input. Please try again.";
            }
        }

        // Save session data
        $ussdSession->data = json_encode($sessionData);
        $ussdSession->save();

        return $response;
    }
}
