<?php

namespace App\Menus;

use App\Helpers\USSDHelper;
use App\Contracts\MenuHandlerInterface;

class MenuSix implements MenuHandlerInterface
{
    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string
    {
        $level = count($textArray);
        $response = ""; // Initialize response

        if ($level == 1) {
            // Prompt for full name
            $response = "CON Find a dealer closer to you. Enter your full name:\n";
        } elseif ($level == 2) {
            // Validate and save full name
            $name = trim($textArray[1]);

            if (strlen($name) < 2 || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $response = "CON Invalid name. Please enter a valid name:\n";
            } else {
                $sessionData['name'] = $name;
                $response = "CON Enter your email address:\n";
            }
        } elseif ($level == 3) {
            // Validate and save email
            $email = trim($textArray[2]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response = "CON Invalid email address. Please enter a valid email:\n";
            } else {
                $sessionData['email'] = $email;
                $response = "CON Enter your location:\n";
            }
        } elseif ($level == 4) {
            // Save location and finalize the request
            $location = trim($textArray[3]);
            $name = $sessionData['name'];
            $email = $sessionData['email'];
            $subject = "Locate a dealer - Isuzu";

            // Send SMS and Email
            $sms = "Dear $name,\nWe have received your Locate A Dealer request, we will get back to you shortly.";
            USSDHelper::sendMessage($phoneNumber, $sms);

            $body = "Thank you $name, we have received your Locate A Dealer request, we will get back to you shortly.<br/><br/>
                     Insist on Genuine Isuzu Parts & Accessories and you will be insisting on value for money, safety and long-lasting performance.<br/>";
            USSDHelper::sendContactRequestEmail($email, $name, $phoneNumber, $subject, $body, $location, 5);

            // Final message
            $response = "END Thank you $name,\nwe have received your Locate A Dealer request, we will get back to you shortly.";
        } else {
            $response = "END Invalid input. Please try again.\n";
        }

        return $response;
    }
}
