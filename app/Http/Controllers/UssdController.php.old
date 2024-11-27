<?php

namespace App\Http\Controllers;

use App\Models\MenuOption;
use App\Models\UssdSession;
use Illuminate\Http\Request;
use App\Mail\QuoteRequestMail;
use Illuminate\Support\Facades\Mail;

class UssdController2 extends Controller
{
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
            ->orderBy('position')
            ->get();

        $menu = "CON Select an option:\n"; // Starting message
        foreach ($menuOptions as $index => $option) {
            $displayCode = ($index + 1) . ". " . $option->option_name;
            $menu .= "$displayCode\n";
        }

        return response($menu);
    }

    private function processUserInput($session, $explodedText)
    {
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
            $currentOptionIndex = (int)$explodedText[$i] - 1;
            // Get the menu option for the current level
            $menuOption = MenuOption::where('parent_id', $parentId)
                ->orderBy('position')
                ->skip($currentOptionIndex)
                ->take(1)
                ->first();

            if ($menuOption) {
                $parentId = $menuOption->id;
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

    // public function showMainMenu($parentId = null, $level = 0)
    // {
    //     $menuOptions = MenuOption::where('parent_id', $parentId)
    //         ->orderBy('position')
    //         ->get();

    //     $menu = "";

    //     foreach ($menuOptions as $index => $option) {
    //         // Create a display code based on the level and the position
    //         $displayCode = str_repeat("   ", $level) . ($index + 1) . ". " . $option->option_name;
    //         $menu .= "$displayCode\n";

    //         // Recursively call to get sub-menu items
    //         $menu .= $this->showMainMenu($option->id, $level + 1);
    //     }

    //     return $menu;
    // }


    // public function processUserInput($session, $currentOption, $explodedText)
    // {
    //     // Log the current path and option to ensure it's being tracked correctly
    //     \Log::info('Current Path: ' . $session->current_path);
    //     \Log::info('User Input: ' . implode('*', $explodedText));

    //     // Handle "00" for returning to the main menu
    //     if ($currentOption === '00') {
    //         $session->current_path = '';  // Reset the path to main menu
    //         $session->save();
    //         return $this->showMainMenu();
    //     }

    //     // Handle "0" for going back to the previous menu
    //     if ($currentOption === '0') {
    //         $pathArray = explode('*', $session->current_path);

    //         if (count($pathArray) > 1) {
    //             // Remove the last selected option
    //             array_pop($pathArray);
    //             $session->current_path = implode('*', $pathArray);
    //         } else {
    //             // If at the top-level menu, reset the path
    //             $session->current_path = '';
    //         }

    //         $session->save();

    //         // Show the previous menu based on the updated path
    //         $parentId = $this->getParentMenuIdFromPath($session->current_path);
    //         \Log::info('Parent ID: ' . $parentId);
    //         return $parentId ? $this->generateMenu($parentId) : $this->showMainMenu();
    //     }

    //     // Use the full text input to construct the current path
    //     $session->current_path = implode('*', $explodedText);  // Directly set current_path from the user input
    //     $session->save();

    //     // Get the current parent ID from the newly set path
    //     $parentId = $this->getParentMenuIdFromPath($session->current_path);

    //     // Fetch the selected menu option based on option_code and parent_id
    //     $menu = MenuOption::where('option_code', $currentOption)
    //         ->where('parent_id', $parentId)
    //         ->first();

    //     // Log the result of the menu query
    //     if ($menu) {
    //         \Log::info('Menu Found: ' . $menu->id . ', Action: ' . $menu->action);
    //     } else {
    //         \Log::error('Invalid Option or Menu not found. Option Code: ' . $currentOption);
    //         return "END Invalid action. Please try again.";
    //     }

    //     // If there's a menu, fetch its children (submenus)
    //     $subMenus = MenuOption::where('parent_id', $menu->id)->get();

    //     // Return the appropriate response based on the submenus found
    //     if ($subMenus->isNotEmpty()) {
    //         $response = "CON Select an option:\n";
    //         foreach ($subMenus as $submenu) {
    //             $response .= $submenu->option_code . ". " . $submenu->option_name . "\n";
    //         }
    //         return $response;  // Show the submenus
    //     } elseif ($menu->action) {
    //         // If there's an action, perform it
    //         return $this->performAction($menu, $session, $explodedText);
    //     }

    //     // Generate the next menu
    //     return $this->generateMenu($menu->id);
    // }

    // public function generateMenu($parentId)
    // {
    //     $menuOptions = MenuOption::where('parent_id', $parentId)->get();

    //     // Fetch the specific message for the current menu level or set a default
    //     $menuMessage = $menuOptions->first()->menu_message ?? "Please choose an option:";
    //     $menu = "CON Please choose an option:\n";

    //     // Create the menu string
    //     $menu = "CON {$menuMessage}\n";

    //     foreach ($menuOptions as $option) {
    //         $menu .= "{$option->option_code}. {$option->option_name}\n";
    //     }

    //     // Add back and main menu navigation
    //     $menu .= "0: Back\n00: Main Menu\n";

    //     return $menu;
    // }

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

    public function getParentMenuIdFromPath($path)
    {
        // Explode the USSD path into an array of option codes
        $codes = explode('*', $path);

        // Start with no parent
        $parentId = null;

        // Loop through each code and find the corresponding menu option
        foreach ($codes as $code) {
            $menuOption = MenuOption::where('option_code', $code)
                ->where('parent_id', $parentId)
                ->first();

            if (!$menuOption) {
                return null;
            }

            // Update parent ID for the next iteration
            $parentId = $menuOption->id;
        }

        return $parentId;
    }

    public function sendQuoteEmail($name, $email, $menu)
    {
        // Use Laravel's email system to send the quote
        Mail::to($email)->send(new QuoteRequestMail($name, $menu->option_name));
    }
}
