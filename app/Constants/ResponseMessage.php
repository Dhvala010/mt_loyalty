<?php


namespace App\Constants;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ResponseMessage
{
    const REGISTER_SUCCESS = 'Your account has been created successfully.';
    const LOGIN_SUCCESS = 'Login Successfully.';
    const LOGOUT_SUCCESS = 'Logout successfully.';
    const FORGOT_PASSWORD_SUCCESS = 'Password is successfully sent on your registered email.';
    const LOGIN_UNAUTHORIZED = "These credentials do not match our records.";
    const CHANGE_PASSWORD_SUCCESS = "Password change successfully";
    const PASSWORD_DO_NOT_MATCH = "Current password not match";
    const ERROR_CREATING_USER = "Error in creating user";
    const ERROR_CREATING_DEVICE = "Error in creating user device detail";
    const USER_NOT_FOUND = 'User not found.';
    const COMMON_MESSAGE = "Sucess";
    const SOCIAL_MEDIA_NOT_FOUND = "User not found";
    const USER_EMAIL_EXIST = "The email has already been taken.";
    const MERCHANT_STORE_REGISTER_SUCCESS = "Merchant store registed successfully";
    const MERCHANT_STORE_DELETE = "Merchant store delete successfully";
    const NOT_AUTHORIZE_REDEEM_OFFER = "You Are not authorize to redeem this offer";
    const REQUEST_SEND_FAMILY_MEMBER_SUCCESSFULLY = "You have send request successfully";
    const REQUEST_UPDATE_REQUEST_FAMILY_MEMBER_SUCCESSFULLY = "You have request updated successfully";
    const REQUEST_ALLREADY_SEND_FAMILY_MEMBER = "You have already send request.";
    const REQUEST_ALLREADY_FRD_FAMILY_MEMBER = "You have already added as a family member.";
    const INVALIDE_ACTION = "Invalide Action";
    const NOT_AUTHORIZE = "Not Authorize";
    const SHARE_STAMP_ERROR = "You have not enough stamp to share";
    const FAMILY_MEMEBER_SEND_REQUEST_NOTIFICATION = "{Username} has you send a Request.";
}
