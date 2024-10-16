<?php

/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-04
 * Time: 14:21
 */

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Mail\Mailable;

class QuotesEmail extends Mailable
{
    public $model;
    public $to_mail;
    public $phone;
    public $name;
    public $image;
    public $quote;
    public $signature = true;
    public $details;

    public function __construct($to_mail, $phone, $name, $model, $quote, $image, $details)
    {
        $this->to_mail = $to_mail;
        $this->model = $model;
        $this->phone = $phone;
        $this->name = $name;
        $this->image = $image;
        $this->quote = $quote;
        $this->details = $details;
    }

    public function build()
    {
        $pdf = PDF::loadView('text_v2', [
            'model' => $this->model, 'details' => $this->details,
            'name' => $this->name, 'phone' => $this->phone, 'email' => $this->to_mail,
            'proforma' => $this->quote, 'image' => $this->image
        ]);
        $pdf->save(base_path("storage/quotes/S" . $this->quote . ".pdf"));
        $subject = "ISUZU " . $this->model->key . " Quote";
        return $this->view('emails.welcome')->subject($subject)
            ->attach(base_path("storage/quotes/S" . $this->quote . ".pdf"));
    }
}
