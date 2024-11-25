<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use App\Models\MenuOption;
use App\Helpers\USSDHelper;
use App\Models\UssdSession;
use Illuminate\Http\Request;
use App\Mail\QuoteRequestMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

            $page = USSDHelper::processUssd($text, $phoneNumber, $serviceCode, $sessionId);
            // $page = USSDHelper::processUssd($ussd_string, $msisdn, $code, $session_id);

            Log::info($request->all());
            return $page;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    function test()
    {
        $pdf = Pdf::loadHTML('<h1>Hello World</h1>');
        return $pdf->download('test.pdf');
    }

    public function handleUssdRequest(Request $request)
    {
        $sessionId = $request->input('sessionId');
        $serviceCode = $request->input('serviceCode');
        $phoneNumber = $request->input('phoneNumber');
        $text = $request->input('text'); // This will contain the user input

        $session = $this->findOrCreateSession($sessionId, $phoneNumber);
        $explodedText = explode('*', $text);

        // Handle navigation based on the user's current input
        if (empty($text)) {
            // If this is the first interaction, show the main menu
            return $this->showMainMenu();
        }

        // Track and update the user's path through the menus
        return $this->processUserInput($session, $explodedText);
    }

    private function showMainMenu($parentId = null, $level = 0)
    {
        $menuOptions = MenuOption::where('parent_id', $parentId)
            ->orderBy('option_code')
            ->get();

        // // Check if it's the first page
        // if ($parentId === null) {
        //     // Welcome message for the main menu
        //     $menu = "CON Welcome to Isuzu EA:\n";
        // } else {
        //     // Fetch the specific message for the current menu level or set a default
        //     $menuMessage = $menuOptions->first()->menu_message ?? "Select an option:";
        //     $menu = "CON $menuMessage\n"; // Starting message for submenus
        // }

        // Initialize the menu message
        if ($parentId === null) {
            // Welcome message for the main menu
            $menu = "CON Welcome to the Isuzu EA:\n";
        } else {
            // Set a different message based on the parentId or option
            $currentMenuOption = MenuOption::find($parentId);

            // Check if the current menu option has a specific message
            $menuMessage = $currentMenuOption->menu_message ?? "Select an option:";


            // Display the menu message for the current submenu
            $menu = "CON $menuMessage\n";
        }

        foreach ($menuOptions as $index => $option) {
            $displayCode = ($index + 1) . ". " . $option->option_name;
            $menu .= "$displayCode\n";
        }

        // Add back and main menu navigation only if not on the main menu
        if ($parentId !== null) {
            $menu .= "0: Back\n00: Main Menu\n";
        }

        return response($menu);
    }

    private function processUserInput($session, $explodedText)
    {
        // Get the current input which is the last element in the exploded text
        $currentInput = end($explodedText);

        // Handle the '0' (Back) option
        if ($currentInput === '0') {
            // Get the parent ID for the previous menu level
            $parentId = $this->getParentIdByLevel($explodedText, count($explodedText) - 2);

            // Check if the parent ID is valid
            if ($parentId) {
                // Update current_path to the parentId
                $session->current_path = $parentId;
                $session->save();

                // Show the menu for the parent ID
                return $this->showMainMenu($parentId);
            } else {
                // Invalid parent ID, show the main menu
                return $this->showMainMenu();
            }
        }

        // Handle the '00' (Main Menu) option
        if ($currentInput === '00') {
            // Reset current_path when going to main menu
            $session->current_path = null;
            $session->save();
            return $this->showMainMenu(); // Go back to the main menu
        }

        // Fetch the current level based on user input
        $currentLevel = count($explodedText) - 1;
        $currentOptionIndex = (int)$explodedText[$currentLevel] - 1;

        // Fetch the parent menu based on the current level
        $parentId = $this->getParentIdByLevel($explodedText, $currentLevel);

        // Get the menu options based on the parent ID
        $menuOptions = MenuOption::where('parent_id', $parentId)->orderBy('position')->get();

        // Check if the selected option is valid
        if (isset($menuOptions[$currentOptionIndex])) {
            $selectedOption = $menuOptions[$currentOptionIndex];

            // Update current_path to the selected option's ID
            $session->current_path = $selectedOption->id;
            $session->save();

            // If the selected option has children, show them
            if ($selectedOption->has_children) {
                return $this->showMainMenu($selectedOption->id);
            } else {
                // Handle the action for this menu item
                return response("END You selected: " . $selectedOption->option_name);
            }
        } else {
            // Invalid selection
            return response("END Invalid option. Please try again.");
        }
    }


    private function getParentIdByLevel($explodedText, $level)
    {
        $parentId = null;

        for ($i = 0; $i < $level; $i++) {
            $currentOptionIndex = (int)$explodedText[$i] - 2; // Get the selected index at this level
            // Get the menu option for the current level
            $menuOption = MenuOption::where('parent_id', $parentId)
                ->orderBy('option_code')
                ->skip($currentOptionIndex)
                ->take(1)
                ->first();

            if ($menuOption) {
                $parentId = $menuOption->id; // Move up to the next parent
            } else {
                break; // Break if there's no valid menu option
            }
        }

        return $parentId;
    }



    public function findOrCreateSession($sessionId, $phoneNumber)
    {
        return UssdSession::firstOrCreate(
            ['session_id' => $sessionId],
            ['phone_number' => $phoneNumber, 'current_path' => '']
        );
    }



    public function performAction($menu, $session, $explodedText)
    {
        if ($menu->action === 'quote') {
            // Ask for the user's name
            if (!isset($session->user_data['name'])) {
                return "CON Enter your full name:";
            }

            // Ask for the user's email
            if (!isset($session->user_data['email'])) {
                $session->user_data['name'] = end($explodedText); // Store the name
                $session->save();
                return "CON Enter your email address:";
            }

            // Finalize the quote request
            $session->user_data['email'] = end($explodedText);
            $session->save();

            $this->sendQuoteEmail($session->user_data['name'], $session->user_data['email'], $menu);

            return "END Dear {$session->user_data['name']}, your quote request has been confirmed. We will get back to you via the email ({$session->user_data['email']}). Thank you.";
        }

        return "END Invalid action.";
    }


    public function sendQuoteEmail($name, $email, $menu)
    {
        // Use Laravel's email system to send the quote
        Mail::to($email)->send(new QuoteRequestMail($name, $menu->option_name));
    }
}
