<?php

/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-10-03
 * Time: 14:01
 */

namespace App\Jobs;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SendSms extends Job
{
    protected $message;
    protected $msisdn;

    public $tries = 1;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $msisdn)
    {
        $this->message = $message;
        $this->msisdn = $msisdn;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $result = $client->post('http://api.bizsms.co.ke/submit1.php3', [
            RequestOptions::JSON => [
                "AuthDetails" => [
                    array(
                        "UserID" => 535,
                        "Token" => md5('gmea123'),
                        "Timestamp" => date("Ymdhis")
                    )
                ],
                "SubAccountID" => [0],
                "MessageType" => [3],
                "BatchType" => [0],
                "SourceAddr" => ["Isuzu_EA"],
                "MessagePayload" => [array("Text" => $this->message)],
                "DestinationAddr" => [array("MSISDN" => $this->msisdn, "LinkID" => "", "SourceID" => "101")]
            ]
        ]);
    }
}
