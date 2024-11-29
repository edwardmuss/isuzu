<?php

namespace App\Menus;

use App\Helpers\USSDHelper;
use App\Contracts\MenuHandlerInterface;

class MenuFour implements MenuHandlerInterface
{
    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string
    {
        $level = count($textArray);
        $response = ""; // Ensure response is initialized

        if ($level == 1) {
            // Ask for the vehicle model
            $response = "CON Parts and Accessories: please enter your vehicle model (e.g., FRR90-CHASSIS):\n";
            $response .= "0: Back\n";
        } elseif ($level == 2 && isset($textArray[1])) {
            // Save the vehicle model and ask for part description
            $vehicleModel = trim($textArray[1]);
            $sessionData['vehicle_model'] = $vehicleModel;
            $response = "CON Enter part description:\n";
            $response .= "0: Back\n";
        } elseif ($level == 3 && isset($textArray[2])) {
            // Save part description and ask for full names
            $partDescription = trim($textArray[2]);
            $sessionData['part_description'] = $partDescription;
            $response = "CON Enter your full names:\n";
            $response .= "0: Back\n";
        } elseif ($level == 4 && isset($textArray[3])) {
            // Validate and save full names, then ask for email
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
            // Validate and save email, then ask for location
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
            // Save location and finalize the request
            $location = trim($textArray[5]);
            $sessionData['location'] = $location;

            $vehicleModel = $sessionData['vehicle_model'];
            $partDescription = $sessionData['part_description'];
            $name = $sessionData['name'];
            $email = $sessionData['email'];

            $subject = "It pays to fit genuine parts";

            $sms = "Dear $name,\nWe have received your Isuzu Parts and Accessories request, we will get back to you shortly.";
            USSDHelper::sendMessage($phoneNumber, $sms);

            $body = "Thank you $name, we have received your Isuzu Parts and Accessories request, we will get back to you shortly.<br/><br/>Insist on Genuine Isuzu Parts & Accessories and you will be insisting on value for money, safety and long-lasting performance.<br/>";
            USSDHelper::sendPartsEmail($email, $name, $phoneNumber, $subject, $body, $location, $partDescription, $vehicleModel);

            $response = "END Thank you $name,\nWe have received your Isuzu Parts and Accessories request, we will get back to you shortly.";
        } else {
            $response = "END Invalid input. Please try again.";
        }

        return $response; // Return the response
    }
}
