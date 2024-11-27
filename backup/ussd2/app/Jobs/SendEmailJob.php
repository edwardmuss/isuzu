<?php

namespace App\Jobs;

use App\Mail\QuotesEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailJob extends Job
{
    private $to;
    private $name;
    private $phone;
    private $model;
    private $quote;
    private $image;
    private $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $name, $phone, $model, $quote, $image, $details)
    {
        $this->to = $to;
        $this->model = $model;
        $this->name = $name;
        $this->phone = $phone;
        $this->image = $image;
        $this->quote = $quote;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)
            ->send(
                new QuotesEmail(
                    $this->to, 
                    $this->phone, 
                    $this->name, 
                    $this->model, 
                    $this->quote, 
                    $this->image, 
                    $this->details
                )
            );
    }
}
