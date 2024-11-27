<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Models\AdminQuoteEmailRequest;
use Illuminate\Console\Command;

class SendQuoteEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmea:send-admin-quote-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends requested quote to recipient\'s email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->process();
    }

	private function process()
	{
        $emailRequests = $this->fetchData();

		foreach($emailRequests as $emailRequest)
		{
			dispatch(
					new SendEmailJob(
						$emailRequest->recipient_email,
						null,
						null,
						null,
						$emailRequest->quote_name,
						null,
						null
					)
			);
			$emailRequest->update([
					'processed' => 1,
			]);
		}
	}

	private function fetchData()
	{
		$emailRequests = AdminQuoteEmailRequest::where('processed', 0)->take(40)->get(); 
		
		return $emailRequests;
	}
}
