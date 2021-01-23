<?php

namespace App\Helpers;
use Twilio\Rest\Client;
use App\Models\SmsVerification;

class TwilioService 
{

    /**
     * 
     * protected account sid 
     */

     protected $accountSid = null;

     /**
      * 
      * protected accountToken 
      */

      protected $accountToken = null;


      public function __construct()
      {
          $this->accountSid = config('services.twilio.TWILIO_ACCOUNT_SID');
          $this->accountToken = config('services.twilio.TWILIO_AUTH_TOKEN');
          
      }


      /**
       * sms
       * @param  : @number
       * @param : payload
       */


    /**
     * @desc used to send OTP
     */
    public function sms($full_phone, $otp, $country_code, $phone)
    {

        // the number you'd like to send the message to
        $number =  $full_phone;

        // the body of the text message you'd like to send
        $message = trans('User::home.OTP_MSG') . $otp;

        $client = new Client($this->accountSid, $this->accountToken);
        // Use the client to send text messages!

        $result = $client->messages->create(
            $number,
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => config('services.twilio.TWILIO_FROM'),
                'body' => $message,
                // 'statusCallback' => route('user.webhook.twilio'),

            ]
        );

        SmsVerification::create([
            'phone_number' => $phone,
            'code' => $otp,
            'message_id' => $result->sid
        ]);

        return $result->sid;
    }



    /**
     * @desc used to send OTP
     */
    public function smsStore($full_phone, $otp)
    {

        // the number you'd like to send the message to
        $number =  $full_phone;

        // the body of the text message you'd like to send
        $message = trans('User::home.OTP_MSG') . $otp;

        $client = new Client($this->accountSid, $this->accountToken);
        // Use the client to send text messages!

        $result = $client->messages->create(
            $number,
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => config('services.twilio.TWILIO_FROM'),
                'body' => $message,
            ]
        );

       

       

        return $result->sid;
    }
      
}