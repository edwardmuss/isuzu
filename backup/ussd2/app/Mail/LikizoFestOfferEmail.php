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

class LikizoFestOfferEmail extends Mailable
{
    use Queueable;

    public $title;
    public $subject;
    public $email;
    public $name;
    public $signature = true;

    public function __construct(
        $email, 
        $name, 
        $title, 
        $subject
    )
    {
        $this->email = $email;
        $this->title = $title;
        $this->subject = $subject;
        $this->name = $name;
    }

    public function build(){
        return $this->view('emails.likizo-fest-offer')
            ->subject($this->subject)
            ->with(
                [
                    'title'=>$this->title
                ]
            );
    }
}
