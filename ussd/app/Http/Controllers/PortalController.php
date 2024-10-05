<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Exception;
use Illuminate\Http\Request;

class PortalController extends Controller 
{
    public function sendQuotePdf(Request $request)
    {
        try 
        {
            dispatch(
                new SendEmailJob(
                    $request->recipient_email,
                    null,
                    null,
                    null,
                    $request->quote,
                    null,
                    null
                )
            );

            return response(
                [
                    'status' => '200',
                    'message' => 'Quote: ' . $request->quote . ' to: ' . $request->recipient_email . ' has been queued successfully.'
                ]
                );
        } catch (Exception $e)
        {
            return response(
                [
                    'status' => '99',
                    'message' => 'Quote: ' . $request->quote . ' to: ' . $request->recipient_email . ' has not been queued successfully. Error: ' . $e->getMessage()
                ],
                500
            );
        }
    }
}