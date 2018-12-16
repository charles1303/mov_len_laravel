<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exceptions\MovieLensException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exceptions\GeneralException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        MovieLensException::class,
        GeneralException::class        
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        //if ($request->wantsJson()) {   //add Accept: application/json in request
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        if (env('APP_DEBUG')) {
            $retval = parent::render($request, $exception);
        } else {
            return $this->handleApiException($request, $exception);
            
        }
        
        return $retval;
    }
    
    private function handleApiException($request, Exception $exception)
    {
        
        $exception = $this->prepareException($exception);
        
        if($exception instanceof MovieLensException){
            return $this->appplicationExceptionResponse($exception);
        }
        
        if ($exception instanceof HttpResponseException) {
            $exception = $exception->getResponse();
        }
        
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }
        
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }
        
        return $this->customApiResponse($exception);
    }
    
    private function appplicationExceptionResponse($exception){
        $response = [];
        $statusCode = $exception->getStatus();
        $response['status'] = $statusCode;
        $response['message'] = $exception->getMessage();
        if (env('APP_DEBUG')) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
        }
        
        $response['data'] = [];
        
        return response()->json($response, $statusCode);
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
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            default:
                $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }
        
        if (env('APP_DEBUG')) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
        }
        
        $response['data'] = [];
        
        return response()->json($response, $statusCode);
    }
    
}
