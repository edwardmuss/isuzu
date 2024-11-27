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

class TechnicalAssistanceEmail extends Mailable
{
    public $signature = true;

    public function __construct()
    {
    }

    public function build()
    {
        $subject = "ISUZU Technical Support Contacts";
        return $this->view('emails.technical-assistance')->subject($subject);
    }
}
