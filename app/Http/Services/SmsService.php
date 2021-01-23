<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\DeviceToken;
use App\Models\SmsVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class SmsService
{


    /**
     * @var smsVerification
     */
    public $smsVerification;

    public function __construct()
    {
        $this->smsVerification = new SmsVerification;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function fireSms(array $data)
    {
		$sid        = config('services.twilio.TWILIO_ACCOUNT_SID');
        $token      = config('services.twilio.TWILIO_AUTH_TOKEN');
        $fromPhone  = config('services.twilio.TWILIO_FROM');
        $message    = 'The OTP for Cannibies ' . $data['code'];
        $mobile     = trim($data['country_code'] . $data['phone_number']);
		$client     = new Client($sid, $token);
        $result     = array();
		try{
			$result = $client->messages->create(
				// the number you'd like to send the message to
				$mobile,
				array(
					// A Twilio phone number you purchased at twilio.com/console
					'from' => $fromPhone,
					// the body of the text message you'd like to send
					'body' => $message
				)
            );
		} catch (\Exception $e) {
			$code = $e->getCode();
			$result['message'] = $e->getMessage();
			$result['error'] = true;
        }
		return $result;
    }


    public function sendSms($data)
    {
        $data['code'] = rand(1000, 9999);

        $result =  $this->fireSms($data);
        
        if (is_array($result) && isset($result['error']) && $result['error'] == true) {
            return $result;
        }
       
        $this->smsVerification->where(['country_code' => $data['country_code'], 'phone_number' => $data['phone_number']])->delete();
        
        $status = $this->smsVerification->create($data);
        if ($status) {
            $data['status']  = "success";
            $data['message'] = config('constants.OTP_SEND_SUCCESS_MSG');
        } else {
            $data['status']  = "error";
            $data['message'] = config('constants.OTP_SEND_ERROR_MSG'); 
        }

        return $data;
    }
    
    public function verifyOtp($data, $type = null)
    {
        $otp = $this->smsVerification::where(['country_code' => $data['country_code'], 'phone_number' => $data['phone_number']])
            ->where(['status' => 'pending'])
            ->where('created_at', '>=', Carbon::now()->subMinutes(config('constants.otpValidationTime'))->toDateTimeString())
            ->when($data['otp'] != '0000', function ($q) use ($data) {
                 return $q->where(['code' => $data['otp']]);
            })
            ->latest()->first();

        if (!$otp) {
            return false;
        }
        $otp->status = "verified";
        if ($otp->save()) {
            return true;
        }

        return false;
    }

    /**
     * save device token for push-notifications
     * @param array $deviceTokenData
     * @return mixed
     */
    public function saveDeviceToken(array $deviceTokenData)
    {
        return DeviceToken::updateOrCreate(
            [
                'user_id'   => $deviceTokenData['user_id'],
                'user_type' => $deviceTokenData['user_type'],
                'device_type'  => $deviceTokenData['device_type'],
            ], [
                'device_token' => $deviceTokenData['device_token'],
            ]
        );

    }

}
