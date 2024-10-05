<?php

/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-08-30
 * Time: 12:20
 */

namespace App\Http\Controllers;

use App\Helpers\USSDHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Jobs\SendServiceEmailJob;
use App\Jobs\SendSms;
use App\Mail\LoyaltyEmail;
use App\Mail\WeekendPromotionEmail;
use App\Models\Award;
use App\Models\BronchureRequest;
use App\Models\Conf;
use App\Models\SpecialOffer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Self_;
use App\Mail\QuotesEmail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $ussd_string = $request->ussd_string ?? $request->USSD_STRING;
            $msisdn = $request->MSISDN ?? $request->msisdn;
            $code = $request->service_code ?? $request->SERVICE_CODE;
            $session_id = $request->session_id ?? $request->SESSION_ID;

            $page = USSDHelper::processUssd($ussd_string, $msisdn, $code, $session_id);

            Log::info($request->all());
            return $page;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }
    public function test()
    {
        $price = Conf::where('key', 'TFR86 4X2 (HR+AC)')->first();
        USSDHelper::sendEmail('edwardmuss5@gmail.com', 'Edward', '0708361797', $price, "Single cab- TFR 86.jpg", 'This is epty details');
        // Mail::to('edwardmuss5@gmail.com')
        //     ->send(
        //         new QuotesEmail(
        //             'edwardmuss5@gmail.com',
        //             '0708361797',
        //             'Edward Muss',
        //             $price,
        //             '1234',
        //             'mu-x_19L.jpeg',
        //             'Blank Details'
        //         )
        //     );
    }
}
