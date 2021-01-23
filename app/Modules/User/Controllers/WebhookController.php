<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Models\SmsVerification;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;


class WebhookController extends Controller
{

    const TWILIO_MESSAGE_SENT = 'sent'; 

    public function handleMessageStatus(Request $request)
    {

        $smsId = $request->get('SmsSid');
        $status = ($request->get('SmsStatus') == self::TWILIO_MESSAGE_SENT) ? "pending" : $request->get('SmsStatus');

        $smsVerification = SmsVerification::where('message_id', $smsId)->first();
        $smsVerification->status = $status;
        $smsVerification->additional_status = $request->get('SmsStatus');
        $smsVerification->save();

        return response("Webhook Handled", SymfonyResponse::HTTP_OK);
    }


    /**
     * getStreamedResponse
     * @param : Request object
     */

    public function getStreamedResponse(Request $request)
    {
        $response = new StreamedResponse(function () use ($request) {

            $messageId = $request->get('message_id');
            $smsVerification = SmsVerification::where('message_id', $messageId)->first();

            while (($smsVerification->status == "pending" || $smsVerification->status == "")) {

                $smsVerification = SmsVerification::where('message_id', $messageId)->first();
                echo 'data: ' . json_encode($smsVerification) . "\n\n";
                ob_flush();
                flush();
                usleep(200000);
            }
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        return $response;
    }
}
