<?php

namespace App\Jobs;

use App\Mail\QuotesEmail;
use App\Mail\ServiceEmail;
use App\Mail\TestDriveEmail;
use Illuminate\Support\Facades\Mail;

class SendServiceEmailJob extends Job
{
    private $to;
    private $subject;
    private $body;
    private $name;
    private $phone;
    private $signature;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $name, $phone, $subject, $body, $signature = true)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->name = $name;
        $this->phone = $phone;
        $this->signature = $signature;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new ServiceEmail($this->to, $this->phone, $this->name, $this->subject, $this->body, $this->signature));
    }
}
