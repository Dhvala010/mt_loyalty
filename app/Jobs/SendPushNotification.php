<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\User,
    App\UserDevice,
    App\UserNotification;
use Edujugon\PushNotification\PushNotification;

class SendPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $sender;
    protected $receiver;
    protected $reference_id;
    protected $reference_type;
    protected $data;
    protected $is_notification;
    protected $message;

    public function __construct($sender,$receiver,$reference_id,$reference_type,$message,$data = [],$is_notification = true)
    {
        $this->sender  = $sender;
        $this->receiver  = $receiver;
        $this->reference_id = $reference_id;
        $this->reference_type = $reference_type;
        $this->message = $message;
        $this->data = $data;
        $this->is_notification = $is_notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sender  = $this->sender;
        $receiver  = $this->receiver;
        $reference_id = $this->reference_id;
        $reference_type = $this->reference_type;
        $data = $this->data;
        $is_notification = $this->is_notification;
        $message = $this->message;

        $push = new PushNotification('fcm');

        if(!is_array($receiver)){
            $receiver = [$receiver];
        }
        foreach ($receiver as $key => $value) {
            $tokens = UserDevice::whereIn('user_id',$value)->select('device_type', 'fcm_token')->orderBy("id", "desc")->get();
            if($tokens->isNotEmpty() && $is_notification == true){
                $tokendata = [];
                foreach ($tokens as $t) :
                    $tokendata[$t["device_type"]][] = $t["fcm_token"];
                endforeach;
                if(isset($tokendata["Android"]) && count($tokendata["Android"]) > 0){
                    $push->setMessage([
                        'priority' => 'normal',
                        'data' => [
                            'title' => "Loyalty",
                            'body' => $message,
                            'sound' => 'default',
                            'extra_data' => $data
                        ],
                    ])
                    ->setDevicesToken($tokendata["Android"])
                    ->send();
                    $NotificationResponse = $push->getFeedback();
                }
                if(isset($tokendata["iOS"]) && count($tokendata["iOS"]) > 0) {
                    $push->setMessage([
                        'priority' => 'normal',
                        'notification' => [
                            'title' => "Loyalty",
                            'body' => $message,
                            'sound' => 'default',
                            'extra_data' => $data
                        ]
                    ])
                    ->setDevicesToken($tokendata["iOS"])
                    ->send();
                    $NotificationResponse = $push->getFeedback();
                }
            }

            $notification = new UserNotification();
            $notification->from_user_id = $sender;
            $notification->to_user_id = $receiver;
            $notification->refference_id = $reference_id;
            $notification->refference_type = $reference_type;
            $notification->message = $message;
            $notification->is_read = 0;
            $notification->save();
        }
        return true;
    }
}
