<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
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
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            if(auth()->user()->hasRole('Manager')) {
                return redirect()->route('transactions.stats');
            }

            if(auth()->user()->hasRole('Store Keeper')) {
                return redirect()->route('receipts.index');
            }

            if(auth()->user()->hasRole('Cashier')) {
                return redirect()->route('sales.index');
            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {

        if ($request->is('api/*')) {

            $response = [
                'success' => false,
                'error' => $exception->getMessage(),
            ];

            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        }

        return redirect()->route('login');


    }
}
