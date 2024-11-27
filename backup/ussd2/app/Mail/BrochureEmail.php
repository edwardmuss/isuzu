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

class BrochureEmail extends Mailable
{

    public $body;
    public $subject;
    public $to_mail;
    public $phone;
    public $name;
    public $file;
    public $signature = true;

    public function __construct($to_mail, $phone, $name, $subject, $body, $file)
    {
        $this->to_mail = $to_mail;
        $this->body = $body;
        $this->subject = $subject;
        $this->phone = $phone;
        $this->name = $name;
        $this->file = $file;
    }

    public function build(){
        return $this->view('emails.welcome_v2')->subject($this->subject)->with(['body'=>$this->body, 'title'=>$this->subject])
            ->attach(base_path("public/brochures/".$this->file));
    }
}
