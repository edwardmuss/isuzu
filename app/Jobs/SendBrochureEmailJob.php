<?php

namespace App\Jobs;

use App\Mail\BrochureEmail;
use App\Mail\QuotesEmail;
use App\Mail\TestDriveEmail;
use Illuminate\Support\Facades\Mail;

class SendBrochureEmailJob extends Job
{
    private $to;
    private $subject;
    private $body;
    private $name;
    private $phone;
    private $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $name, $phone, $subject, $body, $file)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->name = $name;
        $this->phone = $phone;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new BrochureEmail($this->to, $this->phone, $this->name, $this->subject, $this->body, $this->file));
    }
}
