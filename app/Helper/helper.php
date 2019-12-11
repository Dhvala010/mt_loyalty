<?php
namespace App\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Store;

class Helper
{
    function replace_null_with_empty_string($array)
    {
        $array = collect($array)->toArray();
        foreach ($array as $key => $value) {
            if (is_array($value))
                $array[$key] = replace_null_with_empty_string($value);
            else {
                if (is_null($value))
                    $array[$key] = "";
            }
        }
        return $array;
    }

    function RandomPassword($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    function HashPassword($password)
    {
        return Hash::make($password);
    }

    function begin()
    {
        \DB::beginTransaction();
    }

    function commit()
    {
        \DB::commit();
    }

    function rollback()
    {
        \DB::rollBack();
    }

    public static function ImageUpload($profile_img, $folder) {
        $uploadPath = public_path('/uploads/'.$folder);
        $extension = $profile_img->getClientOriginalExtension();
        $fileName = rand(11111, 99999) . '.' . $extension;
        $profile_img->move($uploadPath, $fileName);
        $profile_img = $fileName;
        /*$info = pathinfo($profile_img->getClientOriginalName());
        $ext = $info['extension'];
        $img_name = time() . "-" . rand(11111, 99999) . "." . $ext;
        $path = \Storage::disk('public')->putFileAs(
                $folder, $profile_img, $img_name
        );*/
        return $profile_img;
    }
    public static function totaluser(){
        $user = User::get()->count();
        return $user;
    }
    public static function totalstore(){
        $store = Store::get()->count();
        return $store;
    }
}
?>