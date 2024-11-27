<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-04
 * Time: 14:21
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class WeekendPromotionEmail extends Mailable
{
    public $to_mail;
    public $phone;
    public $name;
    public $signature = true;
    public $details;

    public function __construct($to_mail, $phone, $name, $details)
    {
        $this->to_mail = $to_mail;
        $this->phone = $phone;
        $this->name = $name;
        $this->details = $details;
    }

    public function build()
    {
        $subject = "Clutch Offer";
        return $this->view('emails.weekend-promotion')->subject($subject);
    }
}
