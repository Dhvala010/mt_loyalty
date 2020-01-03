<?php


namespace App\Actions;

use App\FamilyMember,
    App\User;

use Illuminate\Support\Facades\Auth;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Addfamilymember
{

    protected $FamilyMember;

    public function __construct(FamilyMember $FamilyMember)
    {
        $this->FamilyMember = $FamilyMember;
    }

    public function execute(array $data){
        $unique_token = $data["unique_token"];
        $user_detail = User::where("unique_token",$unique_token)->first();
        $user = Auth::user();

        $FamilyMemberManage = [
            "from_user" => $user->id,
            "to_user" => $user_detail->id,
            "created_by" => $user_detail->id,
            "status" => "pending"
        ];

        $FamilyMember = FamilyMember::create($FamilyMemberManage);

        return $FamilyMember;
    }
}
