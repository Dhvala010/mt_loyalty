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
    const CHANGE_PASSWORD_SUCCESS = "Password change successfully.";
    const PASSWORD_DO_NOT_MATCH = "Current password not match.";
    const ERROR_CREATING_USER = "Error in creating user";
    const ERROR_CREATING_DEVICE = "Error in creating user device detail";
    const USER_NOT_FOUND = 'User not found.';
    const COMMON_MESSAGE = "Sucess";
    const SOCIAL_MEDIA_NOT_FOUND = "Social media id not found";
}
