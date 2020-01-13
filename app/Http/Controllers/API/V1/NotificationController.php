<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\UserNotification;

use App\Constants\ResponseMessage;

use App\Http\Requests\ValidateNotificationIdRequest;

class NotificationController extends Controller
{
    public function NotificationListing(Request $request){
        $user = Auth::user();
        $user_id = $user->id;

        $offset = $request->offset ? $request->offset : 10;
        $UserNotification = UserNotification::where('to_user_id',$user_id);

        $UserNotification = $UserNotification->paginate($offset)->toArray();
        $notification_data = replace_null_with_empty_string($UserNotification['data']);
        $total_record = $UserNotification['total'];
        $total_page = $UserNotification['last_page'];
        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$notification_data,$total_record,$total_page );
    }

    public function ReadNotification(ValidateNotificationIdRequest $request){
        $notification_id = $request->notification_id;
        $UserNotification = UserNotification::find($notification_id);
        $UserNotification->is_read = 1;
        $UserNotification->save();

        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

    public function DeleteNotification(ValidateNotificationIdRequest $request){
        $notification_id = $request->notification_id;
        UserNotification::where("id",$notification_id)->delete();

        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }
}
