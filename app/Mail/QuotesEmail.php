<?php

/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-04
 * Time: 14:21
 */

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
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
        $pdf = PDF::loadView('emails.quote.text_v2', [
            'model' => $this->model,
            'details' => $this->details,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->to_mail,
            'proforma' => $this->quote,
            'image' => $this->image ?? asset('apple-touch-icon.png')
        ]);
        $pdf->save(storage_path("app/public/quotes/S" . $this->quote . ".pdf"));
        $subject = "ISUZU " . $this->model->new_model_name_customer . " Quote";
        return $this->view('emails.quote.welcome')->subject($subject)
            ->attach(storage_path("app/public/quotes/S" . $this->quote . ".pdf"));
    }
}
