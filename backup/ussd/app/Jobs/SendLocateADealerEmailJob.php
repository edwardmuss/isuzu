<?php

namespace App\Jobs;

use App\Mail\BrochureEmail;
use App\Mail\LocateADealerEmail;
use App\Mail\QuotesEmail;
use App\Mail\TestDriveEmail;
use Illuminate\Support\Facades\Mail;

class SendLocateADealerEmailJob extends Job
{
    private $to;
    private $subject;
    private $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $name, $subject)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new LocateADealerEmail($this->to, $this->name, $this->subject));
    }
}
