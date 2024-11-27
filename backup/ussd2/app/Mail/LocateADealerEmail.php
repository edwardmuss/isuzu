<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-04
 * Time: 14:21
 */

namespace App\Mail;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LocateADealerEmail extends Mailable
{

    public $subject;
    public $to_mail;
    public $name;
    public $signature = true;

    public function __construct($to_mail, $name, $subject)
    {
        $this->to_mail = $to_mail;
        $this->subject = $subject;
        $this->name = $name;
    }

    public function build(){
        return $this->view('emails.locate-a-dealer')->subject($this->subject)
            ->attach(base_path("public/dealers/isuzu-dealers.pdf"));
    }
}
