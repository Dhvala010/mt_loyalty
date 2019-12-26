<?php


namespace App\Actions;

use App\UserStampCollect;
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

        $UserStampCollectData = [
            "promocode_id" => $GeneratePromocodeToken->promocode_id,
            "store_id" =>  $GeneratePromocodeToken->promocode_detail->store_id,
            "user_id" => $user->id,
            "count" => $GeneratePromocodeToken->count,
        ];
        $GeneratePromocodeToken->delete();
        $UserStampCollect = $this->UserStampCollect->create($UserStampCollectData);

        return $UserStampCollect;
    }

}
