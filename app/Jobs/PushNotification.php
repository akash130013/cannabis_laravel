<?php

namespace App\Jobs;
use App\Models\DeviceToken;
use \App\Helpers\CommonHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $param = [
                    'deviceType'=>$this->data->platform,
                    'user_type' => config('constants.userType.user')
                ];
        CommonHelper::sendUserPushNotification($this->data,$param);
    }

     
}
