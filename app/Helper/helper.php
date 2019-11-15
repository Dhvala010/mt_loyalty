<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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

function ImageUpload($profile_img, $folder = "users") {
    $info = pathinfo($profile_img->getClientOriginalName());
    $ext = $info['extension'];
    $img_name = time() . "-" . rand(11111, 99999) . "." . $ext;
    $path = \Storage::disk('public')->putFileAs(
            $folder, $profile_img, $img_name
    );
    return $path;
}

?>