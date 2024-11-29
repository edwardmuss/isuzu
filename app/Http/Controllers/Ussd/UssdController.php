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
        // Retrieve input data
        $text = $request->input('ussd_string') ?? $request->input('USSD_STRING') ?? $request->input('text');
        $phoneNumber = $request->input('msisdn') ?? $request->input('MSISDN') ?? $request->input('phoneNumber');
        $sessionId = $request->input('session_id') ?? $request->input('SESSION_ID') ?? $request->input('sessionId');

        // Retrieve or create session
        $ussdSession = UssdSession::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'phone_number' => $phoneNumber,
                'data' => json_encode([]),
                'ussd_menu' => null, // Initialize these fields if not already present
                'ussd_string' => null
            ]
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
            $ussdSession->ussd_menu = 'main_menu'; // Update with main menu name
            $ussdSession->ussd_string = $text; // Save the original USSD string
            $ussdSession->save();

            $response = USSDHelper::displayMainMenu(); // Display main menu
        } else {
            // Dynamically call the menu handler based on the first menu option
            $menuOption = $textArray[0] ?? null;
            // Log::info("Menu Option: {$menuOption}");

            if (is_numeric($menuOption) && $menuOption >= 1) {
                $menuClass = "App\\Menus\\Menu" . ucfirst(USSDHelper::convertNumberToWord($menuOption));
                // Log::info("Menu Handler: {$menuClass}");
                if (class_exists($menuClass)) {
                    $menuHandler = new $menuClass;

                    if ($menuHandler instanceof MenuHandlerInterface) {
                        $response = $menuHandler->handle($textArray, $sessionData, $phoneNumber);
                        $ussdSession->ussd_menu = "menu_{$menuOption}"; // Save current menu name
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

        // Save the session data and USSD string
        $ussdSession->data = json_encode($sessionData);
        $ussdSession->ussd_string = $text; // Save the original USSD string
        $ussdSession->save();

        return $response;
    }

    private function extractMenuOptions(string $response): array
    {
        // Split the response into lines and extract menu options
        $lines = explode("\n", $response);
        $menuOptions = [];

        foreach ($lines as $line) {
            if (preg_match('/^\d+\.\s(.+)$/', $line, $matches)) {
                $menuOptions[] = $matches[1]; // Extract the menu option text
            }
        }

        return $menuOptions;
    }
}
