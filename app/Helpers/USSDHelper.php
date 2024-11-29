<?php

namespace App\Helpers;


use App\Jobs\SendBrochureEmailJob;
use App\Jobs\SendEmailJob;
use App\Jobs\SendLocateADealerEmailJob;
use App\Jobs\SendServiceEmailJob;
use App\Jobs\SendSms;
use App\Jobs\SendTechnicalAssistanceEmailJob;
use App\Jobs\SendTestDriveEmailJob;
use App\Jobs\SendWeekendPromotionEmailJob;
use App\Models\BronchureRequest;
use App\Models\PartsRequest;
use App\Models\RequestQuote;
use App\Models\ServiceRequest;
use App\Models\SmsQueue;
use App\Models\TestDrive;
use App\Models\UssdUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Mail\QuotesEmail;
use App\Models\Admin\LocateDealer;
use Illuminate\Support\Facades\Mail;

class USSDHelper
{

    public static function decodeUSSDString($ussd_string)
    {
        $exploded = explode("*", $ussd_string);
        return self::backMethod($exploded);
    }

    public static function backMethod($exploded)
    {
        //search for 0
        $index = array_search("0", $exploded);
        // remove relevant menu
        if ($index >= 1) {
            array_splice($exploded, $index - 1, 2);
            $exploded = self::backMethod($exploded);
        }
        //print_r($exploded);
        for ($i = 0; $i <= count($exploded); $i++) {
            if (empty($exploded[$i]) || $exploded[$i] == 98)
                unset($exploded[$i]);
        }
        return $exploded;
    }

    public static function mainMethod($exploded)
    {
        //search for 00
        $index = array_search("00", $exploded);
        // remove relevant menu
        if ($index >= 1) {
            array_splice($exploded, 0, $index + 1);
            $exploded = self::backMethod($exploded);
        }
        //print_r($exploded);
        for ($i = 0; $i <= count($exploded); $i++) {
            if (empty($exploded[$i]))
                unset($exploded[$i]);
        }
        return $exploded;
    }

    public static function processUssd($ussd_string, $msisdn, $code, $session)
    {
        $exploded_string = self::decodeUSSDString($ussd_string);
        $modifiable_string = $exploded_string;
        if (count($exploded_string) === 0) {
            $class = 'USSDPages';
            $method = 'page0';
            return USSDPages::$method();
        }
        $level = count($exploded_string);
        if (count($exploded_string) > 0 && $exploded_string[0] == 20) {
            return self::nrbTest(substr($ussd_string, 3), $msisdn, $code, $session);
        }

        $response =  self::pageSelector($level, $modifiable_string, $exploded_string, $msisdn);
        UssdUser::create([
            'msisdn' => $msisdn,
            'session_id' => $session,
            'ussd_menu' => $response,
            'ussd_string' => $ussd_string,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return $response;

        return "END ERROR";
    }

    public static function pageSelector($level, $temp_string, $decoded_string, $msisdn)
    {
        $imploded = "";
        foreach ($temp_string as $input) {
            if (is_numeric($input))
                $imploded .= $input;
            else
                $imploded .= 1;
        }
        // $input = 'page' . substr($imploded, 5, 1);
        $page = 'page' . substr($imploded, 0, $level);
        //dd($page);
        return USSDPages::$page($decoded_string, $msisdn);
    }

    public static function validateName($name)
    {
        if (preg_match("/^[a-zA-Z\s-]+$/", $name) === 1)
            return true;
        return false;
    }

    public static function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        return false;
    }

    public static function sendMessage($destination, $message): void
    {
        SmsQueue::create([
            'SourceAdr' => "GM",
            'DestinationAdr' => $destination,
            'Msg' => $message,
            'status' => 0,
            'CreatedDate' => Carbon::now()->toDateTimeString()
        ]);

        dispatch(new SendSms($message, $destination));
    }

    public static function sendQuoteMessage($destination, $model, $name, $email)
    {
        $message = "Dear $name,\nWe have received your request for ISUZU $model->new_model_name_customer, Retail price is Ksh. $model->price. Kindly check your email $email for a quote for the same. Thank you.";
        dispatch(new SendSms($message, $destination));
    }

    public static function sendQuotePopUp($name, $email, $model)
    {
        return "END Dear $name,\nYour Isuzu $model->key  quote request has been confirmed, we will get back to you via the email ($email) provided.Thank you.";
    }

    public static function sendEmail($email, $name, $phone, $model, $image, $details): void
    {
        $quote = Carbon::now()->format('Ymdhis') . rand(0, 500);
        RequestQuote::create([
            'client_name' => $name,
            'client_msisdn' => $phone,
            'quote_name' => "ISUZU $model->new_model_name_customer",
            'quote_number' => $quote,
            'amount' => $model->amount,
            'email_ad' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        dispatch(new SendEmailJob($email, $name, $phone, $model, $quote, $image, $details));

        // Mail::to($email)
        //     ->send(
        //         new QuotesEmail(
        //             $email,
        //             $phone,
        //             $name,
        //             $model,
        //             $quote,
        //             $image,
        //             $details
        //         )
        //     );
    }

    public static function sendWeekendPromotionEmail($email, $name, $phone, $details): void
    {
        dispatch(new SendWeekendPromotionEmailJob($email, $name, $phone, $details));
    }

    public static function sendClutchOfferEmail($email, $name, $phone, $details): void
    {
        dispatch(new SendWeekendPromotionEmailJob($email, $name, $phone, $details));
    }

    public static function sendTestDriveEmail($email, $name, $phone, $title, $subject, $body, $location): void
    {
        dispatch(new SendTestDriveEmailJob($email, $name, $phone, $title, $subject, $body));

        TestDrive::create([
            'client_name' => $name,
            'client_email' => $email,
            'msisdn' => $phone,
            'request' => $title,
            'location' => $location,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public static function sendServiceEmail($email, $name, $phone, $subject, $body, $location, $reg, $make): void
    {
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body));

        ServiceRequest::create([
            'vehicle_type' => $make,
            'reg_no' => $reg,
            'client_name' => $name,
            'client_email' => $email,
            'msisdn' => $phone,
            'location' => $location,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public static function sendPartsEmail($email, $name, $phone, $subject, $body, $location, $description, $make): void
    {
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body));

        PartsRequest::create([
            'vehicle_type' => $make,
            'parts_desc' => $description,
            'client_name' => $name,
            'client_email' => $email,
            'msisdn' => $phone,
            'location' => $location,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public static function sendContactRequestEmail($email, $name, $phone, $subject, $body, $location, $contact_id): void
    {
        LocateDealer::create([
            'contact_id' => $contact_id,
            'client_name' => $name,
            'client_email' => $email,
            'msisdn' => $phone,
            'location' => $location,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body));
    }

    public static function sendTechnicalAssistanceEmail($email)
    {
        dispatch(new SendTechnicalAssistanceEmailJob($email));
    }

    public static function sendBrochureEmail($email, $name, $phone, $subject, $body, $file): void
    {
        dispatch(new SendBrochureEmailJob($email, $name, $phone, $subject, $body, $file));

        BronchureRequest::create([
            'msisdn' => $phone,
            'client_name' => $name,
            'client_email' => $email,
            'brochure_type' => $subject,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public static function sendLocateADealerEmail($email, $name, $subject): void
    {
        dispatch(new SendLocateADealerEmailJob($email, $name, $subject));
    }

    public static function fetchPrice($key)
    {
        //$price = pri
    }

    public static function nrbTest($ussd_string, $msisdn, $code, $session)
    {
        $data = array(
            "msisdn" => $msisdn,
            "session_id" => $session,
            "service_code" => $code,
            "ussd_string" => $ussd_string
        );

        $data_string = json_encode($data);
        //$ch = curl_init('https://us-central1-okolea-firebase-dev.cloudfunctions.net/identity');
        //$ch = curl_init('http://102.133.165.199/NewUssd/LandingPage.ashx');
        //$ch = curl_init('http://www.revenuesure.co.ke/NewUssd/LandingPage.ashx');
        $ch = curl_init('http://10.166.0.2/NewUssd/LandingPage.ashx');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            Log::error("An Error Occurred for $msisdn: " . curl_error($ch));
        }
        $info = curl_getinfo($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        Log::info(" | Took | " . $info['total_time'] . " | seconds to receive a response, status code - | " . $http_code . " |  session_id  | " . $session . "|  msisdn | " . $msisdn);
        curl_close($ch);
        return $result;
    }

    public static function convertNumberToWord($number)
    {
        $words = [
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
        ];

        return $words[$number] ?? $number; // Fallback to the number itself if no match
    }

    // Function to display the main menu
    public static function displayMainMenu()
    {
        $response = $response = "CON Welcome to Isuzu EA:\n\n";
        $response .= "1. Vehicle Sales\n";
        $response .= "2. Book a Test Drive\n";
        $response .= "3. Book a Service \n";
        $response .= "4. Parts and Accessories\n";
        $response .= "5. Contact Center\n";
        $response .= "6. Locate Dealer\n";
        $response .= "7. Brochures\n";
        $response .= "8. MAXIT Loyalty\n";
        return $response;
    }

    // public static function backMenu($exploded)
    // {
    //     //search for 0
    //     $index = array_search("0", $exploded);
    //     // remove relevant menu
    //     if ($index >= 1) {
    //         array_splice($exploded, $index - 1, 2);
    //         $exploded = self::backMethod($exploded);
    //     }
    //     //print_r($exploded);
    //     for ($i = 0; $i <= count($exploded); $i++) {
    //         if (empty($exploded[$i]) || $exploded[$i] == 98)
    //             unset($exploded[$i]);
    //     }
    //     return $exploded;
    // }

    // public static function mainMenu($exploded)
    // {
    //     //search for #
    //     $index = array_search("#", $exploded);
    //     // remove relevant menu
    //     if ($index >= 1) {
    //         array_splice($exploded, 0, $index + 1);
    //         $exploded = self::backMethod($exploded);
    //     }
    //     //print_r($exploded);
    //     for ($i = 0; $i <= count($exploded); $i++) {
    //         if (empty($exploded[$i]))
    //             unset($exploded[$i]);
    //     }
    //     return $exploded;
    // }

    public static function backMenu(array $textArray): array
    {
        if (end($textArray) === '0') {
            array_pop($textArray); // Remove '0'
            array_pop($textArray); // Go back one level
        }
        return $textArray;
    }

    public static function mainMenu(array $textArray): array
    {
        if (end($textArray) === '#') {
            return []; // Reset to main menu
        }
        return $textArray;
    }
}
