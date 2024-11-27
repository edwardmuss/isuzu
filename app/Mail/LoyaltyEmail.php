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

class LoyaltyEmail extends Mailable
{
    use Queueable;

    public $body;
    public $title;
    public $subject;
    public $to_mail;
    public $phone;
    public $name;
    public $image;
    public $signature = true;

    public function __construct($to_mail, $phone, $name, $title, $subject, $body, $image)
    {
        $this->to_mail = $to_mail;
        $this->body = $body;
        $this->title = $title;
        $this->subject = $subject;
        $this->phone = $phone;
        $this->name = $name;
        $this->image = $image;
    }

    public function build(){
        return $this->view('emails.welcome_v2')
            ->subject($this->subject)->with(['body'=>$this->body, 'title'=>$this->title])
            ->attach($this->image);
    }
}
