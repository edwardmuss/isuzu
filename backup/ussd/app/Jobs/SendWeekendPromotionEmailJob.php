<?php

namespace App\Jobs;

use App\Mail\ClutchOfferEmail;
use App\Mail\WeekendPromotionEmail;
use Illuminate\Support\Facades\Mail;

class SendWeekendPromotionEmailJob extends Job
{
    private $to;
    private $name;
    private $phone;
    private $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $name, $phone, $details)
    {
        $this->to = $to;
        $this->name = $name;
        $this->phone = $phone;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new WeekendPromotionEmail($this->to, $this->phone, $this->name, $this->details));
        
    }
}
