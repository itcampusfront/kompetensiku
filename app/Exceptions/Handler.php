<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    public function render($request, Throwable $exception)
    {
        if($this->isHttpException($exception)){
            switch ($exception->getStatusCode()){
                case 403:
                    return response()->view('faturcms::error.403', [], $exception->getStatusCode());
                case 404:
                    return response()->view('faturcms::error.404', [], $exception->getStatusCode());
                break;
            }
        }
        if($exception instanceof \Illuminate\Session\TokenMismatchException){
            return redirect()->route('auth.login');
        }
        return parent::render($request, $exception);
    }
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}