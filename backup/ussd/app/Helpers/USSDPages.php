<?php

/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-02
 * Time: 13:59
 */

namespace App\Helpers;


use App\Jobs\SendServiceEmailJob;
use App\Jobs\SendSms;
use App\Mail\LoyaltyEmail;
use App\Mail\WeekendPromotionEmail;
use App\Models\Award;
use App\Models\BronchureRequest;
use App\Models\Conf;
use App\Models\SpecialOffer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Self_;

class USSDPages
{
    //Index Page
    public static function page0()
    {
        $response = $response = "CON Welcome to Isuzu EA:\n\n";
        $response .= "1. Vehicle Sales\n";
        $response .= "2. Vehicle Service\n";
        $response .= "3. Parts \n";
        $response .= "4. MAXIT Loyalty\n";
        // $response .= "4. Parts\n";
        $response .= "5. Contact Center\n";
        //  $response .= "6. Contacts\n";
        $response .= "6. Locate Dealer\n";
        $response .= "7. Brochures\n";
        // $response .= "9. Offers\n";
        //$response .= "9. PSV Awards\n";
        return $response;
    }

    // 1
    public static function page1($decoded_string, $phone)
    {
        $response = "CON Welcome to the Isuzu vehicle sales portal: \n\n";
        $response .= "1. Vehicle Prices \n";
        $response .= "2. Request a Quote \n";
        $response .= "3. Book a Test Drive \n";
        $response .= "0: Back";
        return $response;
    }

    //1*1
    public static function page11($decoded_string, $phone)
    {
        $response = "CON Choose a Vehicle Make: \n\n";
        $response .= "1. Isuzu mu-X\n";
        $response .= "2. Isuzu Pickups\n";
        $response .= "3. Isuzu 4.1-8.5 Tonne Truck\n";
        $response .= "4. Isuzu Buses\n";
        $response .= "5. Isuzu 11-26 Tonne Truck\n"; //this belongs to F Series menu
        $response .= "6. GXZ60 Prime mover\n"; // E series menu initially
        /* $response .= "6. Chevrolet\n"; */ // Stopped Chevrolet Sales for the moment
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    //1*1*1
    public static function page111()
    {
        $response = "CON Choose Isuzu mu-X Model: \n\n";
        $response .= "1. mu-X 1.9L RJ05\n";
        $response .= "2. mu-X 3.0L RJ05\n";
        $response .= "0: Back\n";
        return $response;
    }
    public static function page1111($decoded_string, $phone)
    {
        $price = Conf::where('key', 'mu-X 1.9L RJ05')->first();
        $response = "CON The retail price of Isuzu mu-X is Ksh $price->f_value\n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }
    //1*1*1*1
    public static function page11111($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }
    //1*1*1*1*1
    public static function page111111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }
    //1*1*1*1*1*1
    public static function page1111111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        $price = Conf::where('key', 'mu-X 1.9L RJ05')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "mu-x_19L.jpeg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }
    public static function page1112($decoded_string, $phone)
    {
        $price = Conf::where('key', 'mu-X 3.0L RJ05')->first();
        $response = "CON The retail price of Isuzu mu-X 3.0L RJ05 is Ksh $price->f_value\n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        return $response;
    }
    //1*1*1*1
    public static function page11121($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }
    //1*1*1*1*1
    public static function page111211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }
    //1*1*1*1*1*1
    public static function page1112111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        $price = Conf::where('key', 'mu-X 3.0L RJ05')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "mu-X_3L.jpeg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }


    //1*1*2
    public static function page112($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Pickup Make: \n\n";
        $response .= "1. Isuzu Single Cab \n";
        $response .= "2. Isuzu Double Cab \n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    //1*1*2*1
    public static function page1121($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Pickup Single Cab Model: \n\n";
        $response .= "1. TFR86 4X2 (HR+AC)\n";
        $response .= "2. TFR86 4X2 (HR+ AC+Airbag)\n";
        $response .= "3. TFS86 4X4 Deluxe\n";
        $response .= "0: Back\n";
        return $response;
    }
    public static function page11211($decoded_string, $phone)
    {
        $price = Conf::where('key', 'TFR86 4X2 (HR+AC)')->first();
        $response = "CON The retail price of an Isuzu TFR86 4X2 (HR+AC)  is Ksh $price->f_value: \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        return $response;
    }
    public static function page112111($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }
    public static function page1121111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }
    public static function page11211111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'TFR86 4X2 (HR+AC)')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Single cab- TFR 86.jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page11212($decoded_string, $phone)
    {
        $price = Conf::where('key', 'TFR86 4X2 (HR+ AC+Airbag)')->first();
        $response = "CON The retail price of an Isuzu TFR86 4X2 (HR+ AC+Airbag) is Ksh: $price->f_value: \n\n";

        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page112121($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1121211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page11212111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'TFR86 4X2 (HR+ AC+Airbag)')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Single cab- TFR 86.jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page11213($decoded_string, $phone)
    {
        $price = Conf::where('key', 'TFS 86 4X4 - DELUXE')->first();
        $response = "CON The retail price of an Isuzu TFS 86 4X4 - DELUXE is Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page112131($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1121311($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page11213111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'TFS 86 4X4 - DELUXE')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Single Cab- TFS 86 Deluxe.jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1122($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Pickup Double Cab Model: \n\n";
        $response .= "1. TFS86 4X4 DELUXE UNACCESORISED\n";
        $response .= "2. TFS86 4X4 DELUXE ACCESSORISED \n";
        $response .= "3. TFS40 4X4 LUXURY AUTOMATIC\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page11221($decoded_string, $phone)
    {
        $price = Conf::where('key', 'TFS86 BLUEPOWER DC 4X4 DELUXE UNACCESORISED')->first();
        $response = "CON The retail price of an Isuzu TFS86 BLUEPOWER DC 4X4 DELUXE UNACCESORISED is Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote.\n";
        $response .= "0: Back.\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page112211($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1122111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page11221111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'TFS86 BLUEPOWER DC 4X4 DELUXE UNACCESORISED')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Double Cab -TFS 85 DC Automatic.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page11222($decoded_string, $phone)
    {
        $price = Conf::where('key', 'TFS86 BLUEPOWER DC 4X4 DELUXE ACCESSORISED')->first();
        $response = "CON The retail price of an Isuzu TFS86 BLUEPOWER DC 4X4 DELUXE ACCESSORISED  is Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote.\n";
        $response .= "0: Back.\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page112221($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1122211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page11222111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'TFS86 BLUEPOWER DC 4X4 DELUXE ACCESSORISED')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Double Cab -TFS 85 DC Automatic.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page11223($decoded_string, $phone)
    {
        $price = Conf::where('key', 'TFS40 BLUEPOWER DC 4X4 LUXURY AUTOMATIC')->first();
        $response = "CON The retail price of an Isuzu TFS40 DC 4X4 LUXURY AUTOMATIC is Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote.\n";
        $response .= "0: Back.\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page112231($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1122311($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page11223111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'TFS40 BLUEPOWER DC 4X4 LUXURY AUTOMATIC')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Double Cab -TFS 85 DC Automatic.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }


    public static function page113($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Truck Make: \n\n";
        $response .= "1. NLR77-Chassis\n";
        //$response .= "2. NKR Truck (Chassis)\n";
        $response .= "2. NMR85-Chassis\n";
        //$response .= "4. NPR Truck (Chassis)\n";
        $response .= "3. NQR81-Chassis\n";
        $response .= "4. NQR Xtra-Chassis\n";
        $response .= "5. NPS81-Chassis\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page1131($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NLR77-Chassis')->first();
        $response = "CON Isuzu NLR77-Chassis Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11311($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page113111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1131111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NLR77-Chassis')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Light Truck -NHR 55E.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    /*public static function page1132($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NKR Truck (Chassis)')->first();
        $response = "CON Isuzu NKR Truck (Chassis) Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11321($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page113211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1132111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NKR Truck (Chassis)')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Light Truck - NKR 66L.png", $details);
        return USSDHelper::sendQuotePopUp($name, $price);
    }*/

    public static function page1132($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NMR Truck (Chassis)')->first();
        $response = "CON Isuzu NMR85-Chassis Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11321($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page113211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1132111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NMR Truck (Chassis)')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Light Truck - NKR 66L.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    /*public static function page1134($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NPR Truck (Chassis)')->first();
        $response = "CON Isuzu NPR Truck (Chassis) Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11341($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page113411($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1134111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NPR Truck (Chassis)')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>NPR Truck (Chassis)</strong>,<br> ";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Light Truck -NPR 66P.png", $details);
        return USSDHelper::sendQuotePopUp($name, $price);
    }*/

    public static function page1133($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NQR Truck (Chassis)')->first();
        $response = "CON Isuzu NQR81-Chassis Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11331($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page113311($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1133111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NQR Truck (Chassis)')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "nqr.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1134($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NQR xtra Truck')->first();
        $response = "CON Isuzu NQR Xtra-Chassis Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11341($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page113411($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1134111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NQR xtra Truck')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "nqr.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1135($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NPS Truck')->first();
        $response = "CON Isuzu NPS81-Chassis Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11351($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page113511($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1135111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NPS Truck')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "nps.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page114($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Bus Make: \n\n";
        $response .= "1. NMR 25 Seat Bus\n";
        $response .= "2. NQR 27 Seat Bus\n";
        $response .= "3. NQR 33-Seat Bus\n";
        // $response .= "4. FRR 37-Seat Bus\n";
        $response .= "4. FSR 46 Seat Bus\n";
        $response .= "5. FVR 67-Seat Bus\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page1141($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NMR 25 Seat Bus')->first();
        $response = "CON Isuzu NMR 25 Seat Bus Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11411($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page114111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1141111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NMR 25 Seat Bus')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "NMR_25.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1142($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NQR 27 SEAT BUS - SEMI LUXURY')->first();
        $response = "CON Isuzu NQR 27 SEAT BUS - SEMI LUXURY Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11421($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page114211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1142111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NQR 27 SEAT BUS - SEMI LUXURY')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "NMR_25.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1143($decoded_string, $phone)
    {
        $price = Conf::where('key', 'NQR 33 SEAT BUS - SEMI LUXURY')->first();
        $response = "CON Isuzu Isuzu NQR 33-Seat Bus Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11431($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page114311($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1143111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'NQR 33 SEAT BUS - SEMI LUXURY')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "NMR_25.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }
    /*
    public static function page1144($decoded_string, $phone)
    {
        $price = Conf::where('key', 'Isuzu FRR 37-Seat Bus')->first();
        $response = "CON Isuzu Isuzu FRR 37-Seat Bus Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11441($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page114411($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1144111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'Isuzu FRR 37-Seat Bus')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "Displacement 5193L<br>Max output: 140hp(190kW) @ 2,600rpm";
        USSDHelper::sendEmail($email, $name, $phone, $price, "bus2.jpeg", $details);
        return USSDHelper::sendQuotePopUp($name, $price);
    }
*/
    public static function page1144($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FSR 46 Seat Bus')->first();
        $response = "CON Isuzu Isuzu FSR 46 Seat Bus  Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11441($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page114411($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1144111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FSR 46 Seat Bus')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "FSR_46.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1145($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FVR 67 Seat Bus')->first();
        $response = "CON Isuzu FVR 67-Seat Bus Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11451($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page114511($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1145111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FVR 67 Seat Bus')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "FSR_46.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }


    public static function page115($decoded_string, $phone)
    {
        $response = "CON Choose Isuzu F Series Truck Make: \n\n";
        $response .= "1. FRR90 - Chassis\n";
        $response .= "2. FVR90L - Chassis\n";
        $response .= "3. FVR90P - Chassis\n";
        $response .= "4. FVR34P - Chassis\n";
        $response .= "5. FVR34P -Tipper\n";
        $response .= "6. FVZ34T Tipper\n";
        $response .= "7. FTS34 Truck - Chassis\n";
        //$response .= "7. FTS Truck\n";
        $response .= "0: Back \n";
        return $response;
    }

    public static function page1151($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FRR Truck (Chassis)')->first();
        $response = "CON Isuzu FRR Truck (Chassis) Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11511($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page115111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1151111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FRR Truck (Chassis)')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "FRR 90N.jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1152($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FVR90L TRUCK')->first();
        $response = "CON Isuzu FVR90L TRUCK Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11521($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page115211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1152111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FVR90L TRUCK')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "FTR 90L (LSD).jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1154($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FVR34P -CHASSIS')->first();
        $response = "CON Isuzu FVR34P -CHASSIS Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11541($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page115411($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1154111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FVR34P -CHASSIS')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "FTR 90L (Non-LSD).jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1155($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FVR34P -TIPPER')->first();
        $response = "CON Isuzu FVR34P -TIPPER Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11551($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page115511($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1155111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FVR34P -TIPPER')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Isuzu_FVR_Truck.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1156($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FVZ34T TIPPER')->first();
        $response = "CON Isuzu FVZ34T Tipper Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11561($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page115611($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1156111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FVZ34T TIPPER')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "FVZ.jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1157($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FTS34 TRUCK - CHASSIS')->first();
        $response = "CON Isuzu FTS34 TRUCK - CHASSIS Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11571($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page115711($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1157111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FTS34 TRUCK - CHASSIS')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "FVZ.jpg", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page1153($decoded_string, $phone)
    {
        $price = Conf::where('key', 'FVR90P -CHASSIS')->first();
        $response = "CON Isuzu FVR90P CHASSIS Retail Price: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page11531($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page115311($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1153111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'FVR90P -CHASSIS')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "Isuzu_FTS_Truck.png", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    public static function page116($decoded_string, $phone)
    {
        $response = "CON Choose Isuzu Prime Movers Make: \n\n";
        $response .= "1. GXZ Prime mover\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page1161($decoded_string, $phone)
    {
        $price = Conf::where('key', 'GXZ Prime mover')->first();
        $response = "CON Isuzu GXZ Prime Mover Retail Price: Ksh: $price->f_value \n\n";
        $response .= "1. Request for a quote\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page11611($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page116111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1161111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $price = Conf::where('key', 'GXZ Prime mover')->first();
        USSDHelper::sendQuoteMessage($phone, $price, $name, $email);
        $details = "<strong>$price->key</strong><br> $price->description";
        USSDHelper::sendEmail($email, $name, $phone, $price, "GXZ Prime mover.PNG", $details);
        return USSDHelper::sendQuotePopUp($name, $email, $price);
    }

    /////
    ///
    ///

    public static function page12($decoded_string, $phone)
    {
        $response = "CON Choose a Vehicle Make: \n\n";
        $response .= "1. Isuzu mu-X\n";
        $response .= "2. Isuzu Pickups\n";
        $response .= "3. Isuzu 4.1-8.5 Tonne Truck\n";
        $response .= "4. Isuzu Buses\n";
        $response .= "5. Isuzu 11-26 Tonne Truck\n"; //this belongs to F Series menu
        $response .= "6. GXZ60 Prime mover\n"; // E series menu initially
        /* $response .= "6. Chevrolet\n"; */ // Stopped Chevrolet Sales for the moment
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    //1*1*1
    public static function page121()
    {
        $response = "CON Choose Isuzu mu-X Model: \n\n";
        $response .= "1. mu-X 1.9L RJ05\n";
        $response .= "2. mu-X 3.0L RJ05\n";
        $response .= "0: Back\n";
        return $response;
    }

    //1*1*1*1
    public static function page1211($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }
    //1*1*1*1*1
    public static function page12111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }
    //1*1*1*1*1*1
    public static function page121111($decoded_string, $phone)
    {
        return self::page1111111($decoded_string, $phone);
    }

    //1*1*1*1
    public static function page1212($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }
    //1*1*1*1*1
    public static function page12121($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }
    //1*1*1*1*1*1
    public static function page121211($decoded_string, $phone)
    {
        return self::page1112111($decoded_string, $phone);
    }


    //1*1*2
    public static function page122($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Pickup Make: \n\n";
        $response .= "1. Isuzu Single Cab \n";
        $response .= "2. Isuzu Double Cab \n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    //1*1*2*1
    public static function page1221($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Pickup Single Cab Model: \n\n";
        $response .= "1. TFR86 4X2 (HR+AC)\n";
        $response .= "2. TFR86 4X2 (HR+ AC+Airbag\n";
        $response .= "3. TFS86 4X4 Deluxe\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page12211($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }
    public static function page122111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }
    public static function page1221111($decoded_string, $phone)
    {
        return self::page11211111($decoded_string, $phone);
    }

    public static function page12212($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page122121($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1221211($decoded_string, $phone)
    {
        return self::page11212111($decoded_string, $phone);
    }

    public static function page12213($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page122131($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1221311($decoded_string, $phone)
    {
        return self::page11213111($decoded_string, $phone);
    }

    public static function page1222($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Pickup Double Cab Model: \n\n";
        $response .= "1. TFS86 4X4 DELUXE UNACCESORISED\n";
        $response .= "2. TFS86 4X4 DELUXE ACCESSORISED\n";
        $response .= "3. TFS40 4X4 LUXURY AUTOMATIC\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page12221($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page122211($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1222111($decoded_string, $phone)
    {
        return self::page11221111($decoded_string, $phone);
    }

    public static function page12222($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page122221($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1222211($decoded_string, $phone)
    {
        return self::page11222111($decoded_string, $phone);
    }


    public static function page12223($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page122231($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page1222311($decoded_string, $phone)
    {
        return self::page11223111($decoded_string, $phone);
    }


    public static function page123($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Truck Make: \n\n";
        $response .= "1. NLR77-Chassis\n";
        //$response .= "2. NKR Truck (Chassis)\n";
        $response .= "2. NMR85-Chassis\n";
        //$response .= "4. NPR Truck (Chassis)\n";
        $response .= "3. NQR81-Chassis\n";
        $response .= "4. NQR Xtra-Chassis\n";
        $response .= "5. NPS81-Chassis\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page1231($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12311($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page123111($decoded_string, $phone)
    {
        return self::page1131111($decoded_string, $phone);
    }

    public static function page1232($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12321($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page123211($decoded_string, $phone)
    {
        return self::page1132111($decoded_string, $phone);
    }

    public static function page1233($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12331($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page123311($decoded_string, $phone)
    {
        return self::page1133111($decoded_string, $phone);
    }

    public static function page1234($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12341($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page123411($decoded_string, $phone)
    {
        return self::page1134111($decoded_string, $phone);
    }

    public static function page1235($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12351($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page123511($decoded_string, $phone)
    {
        return self::page1135111($decoded_string, $phone);
    }

    public static function page1236($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12361($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page123611($decoded_string, $phone)
    {
        return self::page1134111($decoded_string, $phone);
    }

    public static function page1237($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12371($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page123711($decoded_string, $phone)
    {
        return self::page1135111($decoded_string, $phone);
    }

    public static function page124($decoded_string, $phone)
    {
        $response = "CON Choose an Isuzu Bus Make: \n\n";
        $response .= "1. NMR 25 Seat Bus\n";
        $response .= "2. NQR 27 Seat Bus\n";
        $response .= "3. NQR 33-Seat Bus\n";
        $response .= "4. FSR 46 Seat Bus\n";
        $response .= "5. FVR 67-Seat Bus\n";
        //$response .= "6. MV 67 SEAT SEMI-LUXURY\n";
        $response .= "0: Back\n";
        return $response;
    }

    public static function page1241($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12411($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page124111($decoded_string, $phone)
    {
        return self::page1141111($decoded_string, $phone);
    }

    public static function page1242($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12421($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page124211($decoded_string, $phone)
    {
        return self::page1142111($decoded_string, $phone);
    }

    public static function page1243($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12431($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page124311($decoded_string, $phone)
    {
        return self::page1143111($decoded_string, $phone);
    }

    public static function page1244($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12441($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page124411($decoded_string, $phone)
    {
        return self::page1144111($decoded_string, $phone);
    }

    public static function page1245($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12451($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page124511($decoded_string, $phone)
    {
        return self::page1145111($decoded_string, $phone);
    }

    public static function page1246($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12461($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page124611($decoded_string, $phone)
    {
        return self::page1146111($decoded_string, $phone);
    }


    public static function page125($decoded_string, $phone)
    {
        $response = "CON Choose Isuzu F Series Make: \n\n";
        $response .= "1. FRR90 - Chassis\n";
        $response .= "2. FVR90 Truck\n";
        $response .= "3. FVR34P - Chassis\n";
        $response .= "4. FVR34P -Tipper\n";
        $response .= "5. FVZ34T Tipper\n";
        $response .= "6. FVZ Tipper\n";
        $response .= "7. FTS34 Truck - Chassis\n";
        $response .= "0: Back \n";
        return $response;
    }

    public static function page1251($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12511($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page125111($decoded_string, $phone)
    {
        return self::page1151111($decoded_string, $phone);
    }

    public static function page1252($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12521($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page125211($decoded_string, $phone)
    {
        return self::page1152111($decoded_string, $phone);
    }

    public static function page1253($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12531($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page125311($decoded_string, $phone)
    {
        return self::page1153111($decoded_string, $phone);
    }

    public static function page1254($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12541($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page125411($decoded_string, $phone)
    {
        return self::page1154111($decoded_string, $phone);
    }

    public static function page1255($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12551($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page125511($decoded_string, $phone)
    {
        return self::page1155111($decoded_string, $phone);
    }

    public static function page1256($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12561($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page125611($decoded_string, $phone)
    {
        return self::page1156111($decoded_string, $phone);
    }

    public static function page1257($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12571($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page125711($decoded_string, $phone)
    {
        return self::page1157111($decoded_string, $phone);
    }

    public static function page126($decoded_string, $phone)
    {
        $response = "CON Choose Isuzu Prime Movers Make: \n\n";
        $response .= "1. GXZ Prime mover\n";
        $response .= "0: Back\n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page1261($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page12611($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page126111($decoded_string, $phone)
    {
        return self::page1161111($decoded_string, $phone);
    }



    //////////////
    /// //////////
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///

    public static function page13($decoded_string, $phone)
    {
        $response = "CON Select Vehicle Make: \n";
        $response .= "1. Isuzu mu-X\n";
        //DELETE ISUZU SINGLE CAB
        //$response .= "2. Isuzu Single Cab\n";
        $response .= "2. Isuzu Double Cab\n";
        //Deleted Chevrolet Menu Here
        $response .= "0: Back \n";
        $response .= "00: Main Menu\n";
        return $response;
    }

    public static function page131($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1311($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page13111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        return self::pageLocation($decoded_string);
    }

    public static function page131111($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Location (AlphaNumeric Only).";
        $name = $decoded_string[count($decoded_string) - 3];
        $email = $decoded_string[count($decoded_string) - 2];
        $location = $decoded_string[count($decoded_string) - 1];
        //
        $title = 'ISUZU mu-X';
        $subject = "Test Drive - $title";
        $quote = Carbon::now()->format('Ymdhis') . rand(0, 500);

        $sms = "Dear $name,\nThank you for showing interest in $title, your request for a test drive has been received and we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for showing interest in the $title.<br/><br/>Your request for a test drive has been received and we will get back to you shortly.<br/>";
        USSDHelper::sendTestDriveEmail($email, $name, $phone, $title, $subject, $body, $location);

        return "END Dear $name,\nThank you for showing interest in $title. Your request to book a test drive has been received and we will get back to you shortly.";
    }


    //DELETED SINGLE CAB MENU
    /*
    public static function page132($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1321($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page13211($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        return self::pageLocation($decoded_string);
    }

    public static function page132111($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Location (AlphaNumeric Only).";
        $name = $decoded_string[count($decoded_string) - 3];
        $email = $decoded_string[count($decoded_string) - 2];
        $location = $decoded_string[count($decoded_string) - 1];
        //
        $title = 'ISUZU Single Cab';
        $subject = "Test Drive - $title";

        $sms = "Dear $name,\nThank you for showing interest in $title, your request for a test drive has been received and we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for showing interest in the $title.<br/><br/>Your request for a test drive has been received and we will get back to you shortly.<br/>";
        USSDHelper::sendTestDriveEmail($email, $name, $phone, $title, $subject, $body, $location);

        return "END Dear $name,\nThank you for showing interest in $title. Your request to book a test drive has been received and we will get back to you shortly.";
    }
*/
    public static function page132($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page1321($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page13211($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        return self::pageLocation($decoded_string);
    }

    public static function page132111($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Location (AlphaNumeric Only).";
        $name = $decoded_string[count($decoded_string) - 3];
        $email = $decoded_string[count($decoded_string) - 2];
        $location = $decoded_string[count($decoded_string) - 1];
        //
        $title = 'ISUZU Double Cab';
        $subject = "Test Drive - $title";

        $sms = "Dear $name,\nThank you for showing interest in $title, your request for a test drive has been received and we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for showing interest in the $title.<br/><br/>Your request for a test drive has been received and we will get back to you shortly.<br/>";
        USSDHelper::sendTestDriveEmail($email, $name, $phone, $title, $subject, $body, $location);

        return "END Dear $name,\nThank you for showing interest in $title. Your request to book a test drive has been received and we will get back to you shortly.";
    }


    public static function page2($decoded_string, $phone)
    {
        $response = "CON Choose an option: \n\n";
        $response .= "1. Book a service\n";
        $response .= "0: Back";
        return $response;
    }


    public static function page21($decoded_string, $phone)
    {
        $response = "CON Enter vehicle make e.g F-Series:\n";
        $response .= "0. Back\n";
        return $response;
    }

    public static function page211($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Make (AlphaNumeric Only).";
        $response = "CON Enter Registration number: \n\n";
        return $response;
    }

    public static function page2111($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page21111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page211111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        return self::pageLocation($decoded_string);
    }

    public static function page2111111($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Location (AlphaNumeric Only).";
        $make = $decoded_string[count($decoded_string) - 5];
        $reg = $decoded_string[count($decoded_string) - 4];
        $name = $decoded_string[count($decoded_string) - 3];
        $email = $decoded_string[count($decoded_string) - 2];
        $location = $decoded_string[count($decoded_string) - 1];
        //
        //$title = 'ISUZU Double Cab';
        $subject = "Service Booking";

        $sms = "Thank you $name, We have successfully received your request to book a service, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for contacting us.<br/>We have successfully received your request to book a service for your $make of $reg. We will get back to you shortly to confirm your booking.<br/>";
        USSDHelper::sendServiceEmail($email, $name, $phone, $subject, $body, $location, $reg, $make);

        return "END Thank you $name,\n we have successfully received your request to book a service, we will get back to you shortly.";
    }

    public static function page3($decoded_string, $phone)
    {
        $response = "Enter Vehicle Model:\n";
        return $response;
    }

    public static function page31($decoded_string, $phone)
    {
        $response = "CON Enter parts description:\n";
        return $response;
    }


    public static function page311($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Description (AlphaNumeric Only).";
        return self::pageName($decoded_string);
    }

    public static function page3111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page31111($decoded_string)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        return self::pageLocation($decoded_string);
    }

    public static function page311111($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Location (AlphaNumeric Only).";
        $make = $decoded_string[count($decoded_string) - 5];
        $description = $decoded_string[count($decoded_string) - 4];
        $name = $decoded_string[count($decoded_string) - 3];
        $email = $decoded_string[count($decoded_string) - 2];
        $location = $decoded_string[count($decoded_string) - 1];
        //
        //$title = 'ISUZU Double Cab';
        $subject = "It pays to fit genuine parts";

        $sms = "Dear $name,\nWe have received your Isuzu Parts and accessories request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Thank you $name, we have received your Isuzu Parts and accessories request, we will get back to you shortly.<br/><br/>Insist on Genuine Isuzu Parts & Accessories and you will be insisting on value for money, safety and long lasting performance.<br/>";
        USSDHelper::sendPartsEmail($email, $name, $phone, $subject, $body, $location, $description, $make);

        return "END Thank you $name,\n we have received your Isuzu Parts and accessories request, we will get back to you shortly.";
    }


    public static function page4($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page41($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Name. Please try again";
        return self::pageEmail($decoded_string);
    }

    public static function page411($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];

        $sms = "Welcome $name to the MAXIT Loyalty Program. Please Read and Accept our Terms & Conditions: https://www.isuzu.co.ke/loyalty (link). SMS REGISTER to 42000 or Download the Isuzu Loyalty App to self-register. For Assistance, Call our Help Line on 0800 724 724";
        dispatch(new SendSms($sms, $phone));
        $details = "Welcome $name to the MAXIT Loyalty Program.<br><br> Please Read and Accept our Terms & Conditions: https://www.isuzu.co.ke/loyalty.<br> SMS <strong>‘REGISTER to 42000’</strong> or Download the Isuzu Loyalty App to self-register. <br><br>For Assistance, Call our Help Line on <strong>0800 724 724</strong>";
        //dispatch(new SendServiceEmailJob($email, $name, $phone, "MAXIT Loyalty", $details));
        Mail::to($email)->queue(new LoyaltyEmail($email, $phone, $name, "MAXIT Loyalty", "MAXIT Loyalty", $details, base_path('public/loyalty/gift.pdf')));
        return "END Welcome $name to the MAXIT Loyalty Program. Please Read and Accept our Terms & Conditions at https://www.isuzu.co.ke/loyalty. SMS REGISTER to 42000 or Download the Isuzu Loyalty App to self-register. For Assistance, Call our Help Line on 0800 724 724";
    }

    public static function page5($decoded_string, $phone)
    {
        $response = "CON Contact Center:\n\n";
        $response .= "1. View contacts\n";
        $response .= "2. E-mail me details\n";
        $response .= "0: Back \n ";
        return $response;
    }

    public static function page51($decoded_string, $phone)
    {
        $sms = "Dear valued customer\n, Thank you for your enquiry on our technical support contact.\nFor any technical queries kindly contact:\nNick Otieno on 0722567626\n OR \nSolomon Muasya on 0724272471";
        USSDHelper::sendMessage($phone, $sms);
        $response = "END Kindly contact:\nContact Center Toll Free Number 0800 724 724";
        return $response;
    }

    public static function page52($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page521($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page5211($decoded_string)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        return self::pageLocation($decoded_string);
    }

    public static function page52111($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Location (AlphaNumeric Only).";
        $name = $decoded_string[count($decoded_string) - 3];
        $email = $decoded_string[count($decoded_string) - 2];
        $location = $decoded_string[count($decoded_string) - 1];

        $subject = "ISUZU Contact Center";

        $sms = "Dear " . $name . ",\nThank you for your enquiry. We have also shared an email with our Technical Support contacts.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear valued customer,<br/><br/>
                Thank you for your enquiry on our contacts.<br/><br/>
                We are commited to keep you moving, feel free to contact our contact center through our toll free number <strong>0800 724 724</strong>.<br/><br/>";
        USSDHelper::sendPartsEmail($email, $name, $phone, $subject, $body, $location, null, null);

        return "END Thank you for your enquiry. We have sent you an email with the details requested.";
    }

    /*
    public static function page6($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page61($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page611($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";

        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];

        $sms = "Thank you " . $name . ". You can reach us today on 0800 724 724 or via email info.kenya@isuzu.co.ke.";
        USSDHelper::sendMessage($phone, $sms);

        // $body = "Thank you " . $name . ". You can reach us today on 0800 724 724 or via email info.kenya@isuzu.co.ke.";
        $body = "Dear "
            . $name .
            ",<br/></br> Thank you "
                . $name
                . ". You can reach us today on:<br/> "
                ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>ISUZU East Africa<br/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Enterprise Road, Industrial Area<br/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P.O Box 30527- 00100, Nairobi<br/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tel: +254 703 013 111<br/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Toll Free: 0800 724 724<br/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email: info.kenya@isuzu.com<br/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Website: www.isuzu.co.ke </b>";
        USSDHelper::sendPartsEmail($email, $name, $phone, "ISUZU Contacts", $body, "N/A", null, null);
        return "END Thank you " . $name . ". You can reach us today on 0800 724 724 or via email info.kenya@isuzu.co.ke.";
    }
*/
    public static function page6($decoded_string, $phone)
    {
        $response = "CON Find a dealer closer to you. Enter your names: \n";
        return $response;
    }

    public static function page61($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page611($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        return self::pageLocation($decoded_string);
    }

    public static function page6111($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Location (AlphaNumeric Only).";
        $name = $decoded_string[count($decoded_string) - 3];
        $email = $decoded_string[count($decoded_string) - 2];
        $location = $decoded_string[count($decoded_string) - 1];
        //
        //$title = 'ISUZU Double Cab';
        $subject = "Locate a dealer - Isuzu";

        $sms = "Dear $name,\nWe have received your Locate A Dealer request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Thank you $name, we have received your Locate A Dealer request, we will get back to you shortly.<br/><br/>Insist on Genuine Isuzu Parts & Accessories and you will be insisting on value for money, safety and long lasting performance.<br/>";
        USSDHelper::sendPartsEmail($email, $name, $phone, $subject, $body, $location, null, null);

        return "END Thank you $name,\n we have received your Locate A Dealer request, we will get back to you shortly.";
    }

    public static function page7($decoded_string, $phone)
    {
        $response = "CON Choose Model: \n\n";
        $response .= "1. Isuzu mu-X \n";
        $response .= "2. D-Max Pick-up \n";
        $response .= "3. N-Series Trucks \n";
        $response .= "4. F-Series Trucks \n";
        //$response .= "5. E-Series trucks \n";
        $response .= "5. Buses \n";
        $response .= "6. GXZ Prime Movers \n";
        $response .= "7. MAXIT Loyalty \n";
        $response .= "8. Dealer Contacts \n";
        $response .= "0: Back \n";
        return $response;
    }

    public static function page71($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page711($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page7111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Isuzu mu-X Brochure";
        $file = "ISUZU_mu-X_RJ05.pdf";

        $sms = "Thank you $name, We have received your Isuzu mu-X brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for reaching out to us and expressing interest in the Isuzu mu-X.<br/><br/>Herein attached is a copy of your <strong>Isuzu mu-X</strong> brochure for your review.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name, for showing your interest in the Isuzu mu-X. Kindly check your email for a copy of the brochure.";
    }

    public static function page72($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page721($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page7211($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu D-Max Pickup";
        $file = "Isuzu_Dmax_Brochure.pdf";

        $sms = "Thank you $name, We have received your Isuzu D-Max pickup brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Kindly find the requested brochure for your Isuzu D-Max pickup.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name for your Isuzu D-Max pickup brochure request. Kindly check your email for a copy of the same.";
    }

    public static function page73($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page731($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page7311($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu N-Series Truck";
        $file = "N Series trucks.pdf";

        $sms = "Thank you $name, We have received your Isuzu N-Series trucks brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/><br/>Kindly find the requested brochure for your Isuzu N-Series trucks.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name for your Isuzu N-Series trucks brochure request. Kindly check your email for a copy of the same.";
    }

    public static function page74($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page741($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page7411($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu FRR Truck";
        $file = "7th Generation F Series Brochure.pdf";

        $sms = "Thank you $name, We have received  your Isuzu F-Series Truck brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for reaching out to us and expressing interest in the 7th Generation Isuzu F-Series Truck.<br/><br>Herein attached is a copy of your Isuzu F-Series Truck brochure for your review.<br>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name, for showing  your interest in the Isuzu F-Series Truck. Kindly check your email for a copy of the brochure";
    }

    public static function page742($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page7421($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page74211($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu FVZ Truck";
        $file = "FVZ_Flier.pdf";

        $sms = "Thank you $name, We have received  your Isuzu FVZ Truck brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for reaching out to us and expressing interest in the Isuzu FVZ Truck.<br><br>Herein attached is a copy of your Isuzu FVZ Truck brochure for your review.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name, for showing  your interest in the 7TH Generation FVZ Truck. Kindly check your email for a copy of the brochure.";
    }

    public static function page75($decoded_string, $phone)
    {
        $response = "CON Choose Bus Model: \n\n";
        $response .= "1. 7th Gen N Series \n";
        $response .= "2. 7th Gen F Series \n";
        $response .= "0: Back \n";
        return $response;
        //return "END Invalid Choice!";
    }

    public static function page751($decoded_string, $phone)
    {
        //return "END Invalid Choice!";
        return self::pageName($decoded_string);
    }

    public static function page7511($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
        /*return "END Invalid Choice!";
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu E-Series Truck";
        $file = "E_series_Brochure.pdf";

        $sms = "Thank you $name, We have received your Isuzu E-Series trucks brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Kindly find the requested brochure for your Isuzu E-Series trucks.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name for your Isuzu E-Series trucks brochure request. Kindly check your email for a copy of the same.";*/
    }

    public static function page75111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu N-Series Buses";
        $file = "7th-N-Series-Bus.pdf";

        $sms = "Thank you $name, We have received your Isuzu N-series Buses brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Kindly find the requested brochure for your Isuzu N-Series Buses.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name for your Isuzu N-Series Buses brochure request. Kindly check your email for a copy of the same.";
    }


    public static function page752($decoded_string, $phone)
    {
        //return "END Invalid Choice!";
        return self::pageName($decoded_string);
    }

    public static function page7521($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
        /*return "END Invalid Choice!";
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu E-Series Truck";
        $file = "E_series_Brochure.pdf";

        $sms = "Thank you $name, We have received your Isuzu E-Series trucks brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Kindly find the requested brochure for your Isuzu E-Series trucks.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name for your Isuzu E-Series trucks brochure request. Kindly check your email for a copy of the same.";*/
    }

    public static function page75211($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Isuzu F-Series Buses";
        $file = "7th-F-Series-Bus.pdf";

        $sms = "Thank you $name, We have received your Isuzu F-series Buses brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Kindly find the requested brochure for your Isuzu F-Series Buses.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name for your Isuzu F-Series Buses brochure request. Kindly check your email for a copy of the same.";
    }



    public static function page76($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page761($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page7611($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Isuzu GXZ Prime Mover Brochure";
        $file = "GXZ_Brochure.pdf";

        $sms = "Thank you $name, We have received your Isuzu GXZ Prime Mover brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for reaching out to us and expressing interest in the Isuzu GXZ Prime Mover.<br/><br/>Herein attached is a copy of your <strong>Isuzu GXZ Prime Mover</strong> brochure for your review.<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name, for showing your interest in the Isuzu GXZ Prime Mover. Kindly check your email for a copy of the brochure.";
    }




    public static function page77($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page771($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Name. Please try again";
        return self::pageEmail($decoded_string);
    }

    public static function page7711($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];

        $sms = "Welcome $name to the MAXIT Loyalty Program. Please Read and Accept our Terms & Conditions: https://www.isuzu.co.ke/loyalty (link). SMS ‘REGISTER to 42000’ or Download the Isuzu Loyalty App to self-register. For Assistance, Call our Help Line on 0800 724 724";
        dispatch(new SendSms($sms, $phone));
        $details = "Welcome $name to the MAXIT Loyalty Program.<br><br> Please Read and Accept our Terms & Conditions: https://www.isuzu.co.ke/loyalty.<br> SMS <strong>‘REGISTER to 42000’</strong> or Download the Isuzu Loyalty App to self-register. <br><br>For Assistance, Call our Help Line on <strong>0800 724 724</strong>";
        //dispatch(new SendServiceEmailJob($email, $name, $phone, "MAXIT Loyalty", $details));
        Mail::to($email)->queue(new LoyaltyEmail($email, $phone, $name, "MAXIT Loyalty", "MAXIT Loyalty", $details, base_path('public/loyalty/maxit.pdf')));
        return "END Welcome $name to the MAXIT Loyalty Program. Please Read and Accept our Terms & Conditions at https://www.isuzu.co.ke/loyalty. SMS REGISTER to 42000 or Download the Isuzu Loyalty App to self-register. For Assistance, Call our Help Line on 0800 724 724";
    }

    public static function page78($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page781($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page7811($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Request for a Brochure - Dealer Contacts";
        $file = "Isuzu_EA.pdf";

        $sms = "Thank you $name, We have received your Dealer contacts brochure request, we will get back to you shortly.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Kindly find the requested brochure with the Dealer contacts<br/>";
        USSDHelper::sendBrochureEmail($email, $name, $phone, $subject, $body, $file);

        return "END Thank you $name for your Dealer contacts brochure request. Kindly check your email for a copy of the same.";
    }

    public static function page79($decoded_string, $phone)
    {
        return "END Invalid Choice";
        return self::pageName($decoded_string);
    }

    public static function page791($decoded_string, $phone)
    {
        return "END Invalid Choice";
        return self::pageEmail($decoded_string);
    }

    public static function page7911($decoded_string, $phone)
    {
        return "END Invalid Choice";
    }

    public static function page9()
    {
        $response = "CON Find out more about our Isuzu offers:\n\n";
        $response .= "1. School Bus Offer\n";
        $response .= "2. Asset Finance\n";
        $response .= "3. Free 10,000Ltr Water Tank\n";
        $response .= "4. Parts Offer\n";
        $response .= "5. MAXIT Loyalty\n";
        $response .= "6. Weekend Offer\n";
        return $response;
    }

    public static function page93($decoded_string)
    {
        return self::pageName($decoded_string);
    }

    public static function page931($decoded_string)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page9311($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Free 10,000Litres Water tank";
        $serialno = "SpOffer1";

        $sms = "Dear $name,\nIsuzu is offering a reward of a 10,000 Litre water tank with every purchase of the Isuzu NQR Body-on, FRR bus and MV bus.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Isuzu is offering a reward of a 10,000 Litre water tank with every purchase of the Isuzu NQR Body-on, FRR bus and MV bus. For more information, kindly contact your nearest Isuzu dealer.<br/>";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body));
        SpecialOffer::create([
            'offer_id' => $serialno,
            'offer_name' => $subject,
            'client_name' => $name,
            'msisdn' => $phone,
            'client_email' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Dear $name,\nIsuzu is offering a reward of a 10,000 Litre water tank with every purchase of the Isuzu NQR Body-on, FRR bus and MV bus. For more information, kindly contact your nearest Isuzu dealer.";
    }

    public static function page92($decoded_string)
    {
        $response = "CON Choose an Item:\n\n";
        $response .= "1. CHANGAMSHA BIASHARA\n";
        $response .= "2. ISUZU & CO-OPERATIVE BANK\n";
        $response .= "3. ISUZU & NCBA BANK \n";
        $response .= "0. Back \n";
        return $response;
    }

    public static function page921($decoded_string)
    {
        return self::pageName($decoded_string);
    }

    public static function page9211($decoded_string)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page92111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "CHANGAMSHA BIASHARA";
        $serialno = "SpOffer1";

        $sms = "Dear $name,\nWe have partnered with Family bank and enjoy up to 95% financing, 3-months repayment holiday, 1% processing fee, Credit line of 200K accessible via phone when require and the longest repayment.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/><img style='max-width: 624px' src=\"http://35.228.82.108/gmea/public/images/family_bank.jpg\">";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body, false));
        SpecialOffer::create([
            'offer_id' => $serialno,
            'offer_name' => "CHANGAMSHA BIASHARA",
            'client_name' => $name,
            'msisdn' => $phone,
            'client_email' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Dear $name,\nWe have partnered with Family bank to help Kenyans run their businesses with the peace of mind and focus it requires to success.Get up to 95% financing, 3-months repayment holiday, 1% processing fee, Credit line of 200K accessible via phone when require and the longest repayment.";
    }

    public static function page922($decoded_string)
    {
        return self::pageName($decoded_string);
    }

    public static function page9221($decoded_string)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page92211($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "TUZIDI KUSONGA MBELE PAMOJA";
        $serialno = "SpOffer1";

        $sms = "Dear $name,\nWe have partnered with Co-operative bank to continue supporting your business during these times. \n Get up to KShs. 500,000 working capital and a 60 days repayment holiday for new vehicle purchases with deposit from as low as KShs. 175,000.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/><img style='max-width: 624px' src=\"http://35.228.82.108/gmea/public/images/isuzu_coop.jpg\">";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body, false));
        SpecialOffer::create([
            'offer_id' => $serialno,
            'offer_name' => "ISUZU & CO-OPERATIVE BANK",
            'client_name' => $name,
            'msisdn' => $phone,
            'client_email' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Dear $name,\nWe have partnered with Co-operative bank to continue supporting your business during these times.\n Get up to KShs. 500,000 working capital and a 60 days repayment holiday for new vehicle purchases with deposit from as low as KShs. 175,000.";
    }


    public static function page923($decoded_string)
    {
        return self::pageName($decoded_string);
    }

    public static function page9231($decoded_string)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page92311($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Biashara Haingoji, Usingoje Pia";
        $serialno = "SpOffer1";

        $sms = "Dear $name,\nWe have partnered with NCBA to continue supporting and drive your business further. Get up to 95% financing, 60 days repayment holiday and a 60 month loan tenor.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>";
        $body .= "At Isuzu, we share your dream of growing your business and we understand that you need solutions that make your business flourish. <br><br>That is why we have partnered with NCBA to give you<br><br>";
        $body .= "<ul><li>Financing of up to 95% financing</li><li>60 days Repayment Holiday</li><li>60 months loan tenor</li><li>1% Appraisal Fee existing customers and 1.5% new customers</li><li>Competitive Insurance package (Sanlam insurance)</li></ul><br><br>";
        $body .= "Call 0800 724 724 to take your business further with Isuzu.";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body));
        SpecialOffer::create([
            'offer_id' => $serialno,
            'offer_name' => "Biashara Haingoji, Usingoje Pia",
            'client_name' => $name,
            'msisdn' => $phone,
            'client_email' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Dear $name,\nWe have partnered with NCBA to continue supporting and drive your business further. Get up to 95% financing, 60 days repayment holiday and a 60 month loan tenor.";
    }

    public static function page94($decoded_string)
    {
        $response = "CON Choose an Offer:\n\n";
        $response .= "1. MAXIT Batteries\n";
        $response .= "0. Back \n";
        return $response;
    }

    public static function page941($decoded_string)
    {
        return self::pageName($decoded_string);
    }

    public static function page9411($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page94111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "MAXIT Battery offer";
        $serialno = "SpOffer1";

        $sms = "Dear $name,\nSave money with a MAXIT battery today. From Kes. 6,582 only.";
        USSDHelper::sendMessage($phone, $sms);
        //$body = "Dear $name,<br><br>Tukisema #TusongeMbelePamoja, we mean it.<br><br>You can now place your order for all Isuzu Genuine Parts and Maxit lubricants via our Toll Free number 0800 724 724 and we will deliver where you are.  Tupigie leo!<br><br>";
        $body = "<img style='max-width: 624px;height: auto' src=\"http://35.228.82.108/gmea/public/images/maxit.png\"><br><br><br>";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body));
        SpecialOffer::create([
            'offer_id' => $serialno,
            'offer_name' => $subject,
            'client_name' => $name,
            'msisdn' => $phone,
            'client_email' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Save money with a MAXIT battery today. From Kes. 6,582 only.";
    }

    public static function page95($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page951($decoded_string, $phone)
    {
        if (!USSDHelper::validateName(end($decoded_string)))
            return "END Invalid Name. Please try again";
        return self::pageEmail($decoded_string);
    }

    public static function page9511($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid e-mail address entered. Try Again.";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];

        $sms = "Welcome $name to the MAXIT Loyalty Program. Please Read and Accept our Terms & Conditions: https://www.isuzu.co.ke/loyalty (link). SMS ‘REGISTER to 42000’ or Download the Isuzu Loyalty App to self-register. For Assistance, Call our Help Line on 0800 724 724";
        dispatch(new SendSms($sms, $phone));
        $details = "Welcome $name to the MAXIT Loyalty Program.<br><br> Please Read and Accept our Terms & Conditions: https://www.isuzu.co.ke/loyalty.<br> SMS <strong>‘REGISTER to 42000’</strong> or Download the Isuzu Loyalty App to self-register. <br><br>For Assistance, Call our Help Line on <strong>0800 724 724</strong>";
        //dispatch(new SendServiceEmailJob($email, $name, $phone, "MAXIT Loyalty", $details));
        Mail::to($email)->queue(new LoyaltyEmail($email, $phone, $name, "MAXIT Loyalty", "MAXIT Loyalty", $details, base_path('public/loyalty/gift.pdf')));
        return "END Welcome $name to the MAXIT Loyalty Program. Please Read and Accept our Terms & Conditions at https://www.isuzu.co.ke/loyalty. SMS REGISTER to 42000 or Download the Isuzu Loyalty App to self-register. For Assistance, Call our Help Line on 0800 724 724";
    }

    public static function page91($decoded_string)
    {
        return self::pageName($decoded_string);
    }

    public static function page911($decoded_string)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page9111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Back to school with ONE Term repayment holiday";
        $serialno = "SpOffer4";

        $sms = "Dear $name,\nEnjoy a new ISUZU school bus today with a ONE TERM repayment HOLIDAY,  Longest repayment period of 72 months, 95% financing and a FREE 10,000L water tank.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br><br>";
        $body .= "<img style='max-width: 624px;height: auto' src=\"http://35.228.82.108/gmea/public/images/Isuzu-NCBA-flier.jpg\"><br><br>";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body, false));
        SpecialOffer::create([
            'offer_id' => $serialno,
            'offer_name' => $subject,
            'client_name' => $name,
            'msisdn' => $phone,
            'client_email' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Enjoy a new ISUZU school bus today with a ONE TERM repayment HOLIDAY,  Longest repayment period of 72 months, 95% financing and a FREE 10,000L water tank.";
    }

    public static function page942($decoded_string)
    {
        return self::pageName($decoded_string);
    }

    public static function page9421($decoded_string)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page94211($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Get ready for the Holiday Travel";
        $serialno = "SpOffer4";

        $sms = "Dear $name,\nGet your safari ready by enjoying a 64- point vehicle inspection at all our authorized service center. Call us on 0800 724724 to book your vehicle today.";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br><br>This holiday season, we wish to express our appreciation for you for your support and partnership this far.<br><br>As you prepare to travel with your loved ones during this season, we care for your safety. Get the peace of mind that your vehicles is in perfect condition by getting the <strong>ISUZU vehicle health inspection</strong> at any authorized service center.<br><br>Call us today on <span style='color: red'>0800 724 724</span> to book for express service.<br><br>#TusongeMbelePamoja<br><br>";
        $body .= "<img style='max-width: 624px;height: auto' src=\"http://35.228.82.108/gmea/public/images/mu-X.JPG\"><br><br><br>";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body, false));
        SpecialOffer::create([
            'offer_id' => $serialno,
            'offer_name' => $subject,
            'client_name' => $name,
            'msisdn' => $phone,
            'client_email' => $email,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Get your safari ready by enjoying a 64- point vehicle inspection at all our authorized service center. Call us on 0800 724724 to book your vehicle today.";
    }

    public static function page96($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page961($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }

    public static function page9611($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";

        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];

        // return self::pageLocation($decoded_string);
        $details = "This Saturday & Sunday, save time and money with us. Enjoy FREE vehicle health inspection, 20% parts discount and free vehicle wash. Call 0800724724 to book for service";

        USSDHelper::sendMessage($phone, $details);
        USSDHelper::sendWeekendPromotionEmail($email, $name, $phone, $details);

        return "END This Saturday & Sunday, save time and money with us. Enjoy FREE vehicle health inspection, 20% parts discount and free vehicle wash. Call 0800724724 to book for service";
    }

    /*public static function page9()
    {
        $response = "CON Enter your PSV Operator name:\n";
        return $response;
    }

    public static function page91($decoded_string, $phone)
    {
        $response = "CON Enter the route:\n";
        return $response;
    }

    public static function page911($decoded_string, $phone)
    {
        return self::pageName($decoded_string);
    }

    public static function page9111($decoded_string, $phone)
    {
        return self::pageEmail($decoded_string);
    }*/

    public static function page91111($decoded_string, $phone)
    {
        if (!USSDHelper::validateEmail(end($decoded_string)))
            return "END Invalid Email Address. Try Again";
        $operator = $decoded_string[count($decoded_string) - 4];
        $route = $decoded_string[count($decoded_string) - 3];
        $name = $decoded_string[count($decoded_string) - 2];
        $email = $decoded_string[count($decoded_string) - 1];
        //
        $subject = "Isuzu PSV Awards";

        $sms = "Thank you for nominating $operator that ply $route for the 2018 Isuzu PSV Awards. For more information on the Eligibility Criteria, Awards Categories and Judging Criteria, please visit www.psvawards.com";
        USSDHelper::sendMessage($phone, $sms);
        $body = "Dear $name,<br/><br/>Thank you for nominating $operator that ply $route for the 2018 Isuzu PSV Awards. For more information on the Eligibility Criteria, Awards Categories and Judging Criteria, please visit www.psvawards.com<br/>";
        dispatch(new SendServiceEmailJob($email, $name, $phone, $subject, $body));
        Award::create([
            'sacco_name' => $operator,
            'sacco_route' => $route,
            'client_name' => $name,
            's_email' => $email,
            'msisdn' => $phone,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return "END Thank you $name for nominating $operator that ply $route for the Isuzu PSV Awards. All the best.";
    }

    public static function pageName($decoded_string)
    {
        $response = "CON Enter your full names:\n";
        return $response;
    }

    public static function pageLocation($decoded_string)
    {
        $response = "CON Enter your current location:\n";
        return $response;
    }

    public static function pageEmail($decoded_string)
    {
        if (USSDHelper::validateName(end($decoded_string)))
            return "CON Enter your email address:\n";
        return "END Please enter a valid name (Alphabets Only).\n";
    }
}
