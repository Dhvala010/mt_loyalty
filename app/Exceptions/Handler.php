<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($request->wantsJson()) {   //add Accept: application/json in request

            return $this->handleApiException($request, $exception);
        } else {

            if ($exception instanceof MethodNotAllowedHttpException) {
                return redirect()->back();
            }

            return parent::render($request, $exception);

        }

    }
    private function handleApiException($request,  $exception)
    {

        $exception = $this->prepareException($exception);
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }
        else if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }
    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }
        $response = [];
        $response['status'] = $statusCode;

        switch ($statusCode) {

            case 401:
                $response['message'] = 'Unauthorized.';
                break;
            case 403:
                $response['message'] = 'Forbidden.';
                break;
            case 404:
                $response['message'] = $exception->getMessage();
                break;
            case 405:
                $response['message'] = 'Method Not Allowed.';
                break;
            case 422:
                $response['message'] = head($exception->getData()->errors)[0];
                break;
            default:
                $response['message'] = $exception->getMessage();
                break;
        }
        $response['data'] = (object)[];
        return response()->json($response, $statusCode);
    }
}
