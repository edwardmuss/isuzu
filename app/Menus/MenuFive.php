<?php

namespace App\Menus;

use App\Helpers\USSDHelper;
use App\Contracts\MenuHandlerInterface;

class MenuFive implements MenuHandlerInterface
{
    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string
    {
        $level = count($textArray);
        $response = ""; // Ensure response is initialized

        if ($level == 1) {
            // Main menu options
            $response = "CON Choose an option:\n";
            $response .= "1. View Contacts\n";
            $response .= "2. Email Me Details\n";
            $response .= "0. Back\n";
        } elseif ($level == 2) {
            switch ($textArray[1]) {
                case "1": // View Contacts
                    $sms = "Dear valued customer,\nThank you for your enquiry on our technical support contact.\nFor any technical queries kindly contact:\nNick Otieno on 0722567626\nOR\nSolomon Muasya on 0724272471";
                    USSDHelper::sendMessage($phoneNumber, $sms);

                    $response = "CON Kindly contact:\nContact Center Toll Free Number 0800 724 724\n";
                    $response .= "0: Back\n";
                    $response .= "#: Main Menu\n";
                    break;

                case "2": // Email Me Details
                    $response = "CON Enter your full name:\n";
                    $response .= "0: Back\n";
                    break;

                case "0": // Back
                    $response = "END You have exited the menu.\n";
                    break;

                default:
                    $response = "END Invalid option. Please try again.\n";
                    break;
            }
        } elseif ($level == 3 && $textArray[1] == "2") {
            // Validate and save full name
            $name = trim($textArray[2]);

            if (strlen($name) < 2 || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $response = "CON Invalid name. Please enter a valid name:\n";
                $response .= "0: Back\n";
            } else {
                $sessionData['name'] = $name;
                $response = "CON Enter your email address:\n";
                $response .= "0: Back\n";
            }
        } elseif ($level == 4 && $textArray[1] == "2") {
            // Validate and save email
            $email = trim($textArray[3]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response = "CON Invalid email address. Please enter a valid email:\n";
                $response .= "0: Back\n";
            } else {
                $sessionData['email'] = $email;
                $response = "CON Enter your location:\n";
                $response .= "0: Back\n";
            }
        } elseif ($level == 5 && $textArray[1] == "2") {
            // Save location and finalize the email request
            $location = trim($textArray[4]);
            $sessionData['location'] = $location;

            $name = $sessionData['name'];
            $email = $sessionData['email'];
            $subject = "ISUZU Contact Center";

            $sms = "Dear " . $name . ",\nThank you for your enquiry. We have also shared an email with our Technical Support contacts.";
            USSDHelper::sendMessage($phoneNumber, $sms);

            $body = "Dear valued customer,<br/><br/>
                Thank you for your enquiry on our contacts.<br/><br/>
                We are committed to keep you moving, feel free to contact our contact center through our toll-free number <strong>0800 724 724</strong>.<br/><br/>";
            USSDHelper::sendContactRequestEmail($email, $name, $phoneNumber, $subject, $body, $location, 4);

            $response = "END Thank you for your enquiry. We have sent you an email with the details requested.";
        } else {
            $response = "END Invalid input. Please try again.\n";
        }

        return $response; // Return the response
    }
}
