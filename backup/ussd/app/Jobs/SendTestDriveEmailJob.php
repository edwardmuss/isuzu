<?php

namespace App\Jobs;

use App\Mail\QuotesEmail;
use App\Mail\TestDriveEmail;
use Illuminate\Support\Facades\Mail;

class SendTestDriveEmailJob extends Job
{
    private $to;
    private $subject;
    private $body;
    private $title;
    private $name;
    private $phone;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $name, $phone, $title, $subject, $body)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->title = $title;
        $this->name = $name;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new TestDriveEmail($this->to, $this->phone, $this->name, $this->title, $this->subject, $this->body));
    }
}
