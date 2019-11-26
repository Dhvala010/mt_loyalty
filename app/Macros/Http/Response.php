<?php
namespace App\Macros\Http;
use Illuminate\Support\Facades\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
/**
 *
 */
class Response
{
    public static function registerMacros()
    {
        HttpResponse::macro('success', function ($message,$data=NULL) {
            return response()->json([
                'status' => SymfonyResponse::HTTP_OK,
                'message' => $message,
                'data' => is_null($data) ? (object)[]: $data
              ], SymfonyResponse::HTTP_OK);
        });
        HttpResponse::macro('error', function ($message,$status) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => (object)[]
              ], $status);
        });
        HttpResponse::macro('paginate', function ($message,$data,$totalRecord,$totalPage) {
            return response()->json([
                'status' => SymfonyResponse::HTTP_OK,
                'message' => $message,
                'total_record' => $totalRecord,
                'total_page' => $totalPage,
                'data' => $data
              ],SymfonyResponse::HTTP_OK);
        });
    }
}