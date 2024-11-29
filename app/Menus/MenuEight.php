<?php

namespace App\Menus;

use App\Jobs\SendSms;
use App\Models\Loyalty;
use App\Mail\LoyaltyEmail;
use App\Helpers\USSDHelper;
use Illuminate\Support\Facades\Mail;
use App\Contracts\MenuHandlerInterface;

class MenuEight implements MenuHandlerInterface
{
    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string
    {
        $level = count($textArray);
        $response = ""; // Initialize the response

        if ($level == 1) {
            $response = "CON Enter your name:\n";
        } elseif ($level == 2 && isset($textArray[1])) {
            $name = trim($textArray[1]);

            if (strlen($name) < 2 || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $response = "CON Invalid name. Please enter a valid name:\n";
            } else {
                $sessionData['name'] = $name;
                $response = "CON Enter your email address:\n";
            }
        } elseif ($level == 3 && isset($textArray[2])) {
            $email = trim($textArray[2]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response = "CON Invalid email address. Please enter a valid email:\n";
            } else {
                $sessionData['email'] = $email;

                // Retrieve loyalty program details from the database
                $loyalty = Loyalty::first();

                if (!$loyalty) {
                    return "END Loyalty program details are currently unavailable. Please try again later.";
                }

                // SMS and Email contents from the database
                $smsMessage = str_replace("{name}", $sessionData['name'], $loyalty->sms_message);
                $emailBody = str_replace("{name}", $sessionData['name'], $loyalty->email_body);
                $filePath = asset('storage/' . $loyalty->file);

                // Dispatch SMS
                dispatch(new SendSms($smsMessage, $phoneNumber));

                // Send Email
                Mail::to($email)->queue(new LoyaltyEmail(
                    $email,
                    $phoneNumber,
                    $sessionData['name'],
                    $loyalty->title,
                    $loyalty->subject,
                    $emailBody,
                    $filePath
                ));

                $response = "END $smsMessage";
            }
        } else {
            $response = "END Invalid input. Please try again.";
        }

        return $response;
    }
}
