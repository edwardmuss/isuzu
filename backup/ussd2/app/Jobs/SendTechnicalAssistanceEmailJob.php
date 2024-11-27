<?php

namespace App\Jobs;

use App\Mail\TechnicalAssistanceEmail;
use Illuminate\Support\Facades\Mail;

class SendTechnicalAssistanceEmailJob extends Job
{
    private $to;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to)
    {
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new TechnicalAssistanceEmail());
        
    }
}
