<?php


namespace App\Actions;

use App\UserStampCollect;
use App\UserPointCollect;
use App\GeneratePromocodeToken;
use Illuminate\Support\Facades\Auth;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AddUserPromocodeStamp
{

    protected $UserStampCollect;

    public function __construct(UserStampCollect $UserStampCollect)
    {
        $this->UserStampCollect = $UserStampCollect;
    }

    public function execute(array $data){
        $unique_token = $data['unique_token'];
        $user = Auth::user();

        $GeneratePromocodeToken = GeneratePromocodeToken::where('unique_token',$unique_token)->with("promocode_detail")->first();
        
        if($GeneratePromocodeToken->type == "point"){
            $UserPointCollectData = [
                "promocode_id" => $GeneratePromocodeToken->promocode_id,
                "store_id" =>  $GeneratePromocodeToken->promocode_detail->store_id,
                "user_id" => $user->id,
                "count" => $GeneratePromocodeToken->count,
                "is_redeem" => 0
            ];           
            $UserStampCollect = UserPointCollect::create($UserPointCollectData);
        }else{
            $UserStampCollectData = [
                "promocode_id" => $GeneratePromocodeToken->promocode_id,
                "store_id" =>  $GeneratePromocodeToken->promocode_detail->store_id,
                "user_id" => $user->id,
                "count" => $GeneratePromocodeToken->count,
            ];
            $UserStampCollect = $this->UserStampCollect->create($UserStampCollectData);
        }
        
        $GeneratePromocodeToken->delete();
        return $UserStampCollect;
    }

}
