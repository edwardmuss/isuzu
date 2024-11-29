<?php

namespace App\Menus;

use App\Helpers\USSDHelper;
use App\Contracts\MenuHandlerInterface;

class MenuThree implements MenuHandlerInterface
{
    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string
    {
        $level = count($textArray);
        $response = ""; // Ensure response is initialized

        if ($level == 1) {
            // Ask for the vehicle series
            $response = "CON Book a service please enter your vehicle series (e.g., F-Series):\n";
            $response .= "0: Back\n";
        } elseif ($level == 2 && isset($textArray[1])) {
            // Save the vehicle series and ask for the registration number
            $vehicleSeries = trim($textArray[1]);
            $sessionData['vehicle_series'] = $vehicleSeries;
            $response = "CON Enter your vehicle registration number:\n";
            $response .= "0: Back\n";
        } elseif ($level == 3 && isset($textArray[2])) {
            // Save the registration number and ask for full names
            $registrationNumber = trim($textArray[2]);
            $sessionData['registration_number'] = $registrationNumber;
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
            // Save location and finalize booking
            $location = trim($textArray[5]);
            $sessionData['location'] = $location;

            $vehicleSeries = $sessionData['vehicle_series'];
            $registrationNumber = $sessionData['registration_number'];
            $name = $sessionData['name'];
            $email = $sessionData['email'];

            $subject = "Service Booking";

            $sms = "Thank you $name, We have successfully received your request to book a service, we will get back to you shortly.";
            USSDHelper::sendMessage($phoneNumber, $sms);

            $body = "Dear $name,<br/><br/>Thank you for contacting us.<br/>We have successfully received your request to book a service for your $vehicleSeries with registration number $registrationNumber. We will get back to you shortly to confirm your booking.<br/>";
            USSDHelper::sendServiceEmail($email, $name, $phoneNumber, $subject, $body, $location, $registrationNumber, $vehicleSeries);

            $response = "END Thank you $name,\nWe have successfully received your request to book a service. We will get back to you shortly.";
        } else {
            $response = "END Invalid input. Please try again.";
        }

        return $response; // Return the response
    }
}
