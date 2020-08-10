<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Dotenv\Exception\ValidationException;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\QueryException;

use Illuminate\Auth\AuthenticationException;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $debug = config('app.debug');
        $message = '';
        $status_code = 500;

        if($exception instanceof ModelNotFoundException) {
            $message = 'Resrource is not found!';
            $status_code = 404;
        } else if($exception instanceof NotFoundHttpException) {
            $message = 'Endpoint is not found';
            $status_code = 404;
        } else if($exception instanceof MethodNotAllowedException) {
            $message = 'Method is not allowed';
            $status_code = 405;
        } else if($exception instanceof QueryException) {
            if($debug) {
                $message = $exception->getMessage();
            } else {
                $message = 'Query failed to execute';
            }
            $status_code = 500;
        }

        $rendered = parent::render($request, $exception);
        $status_code = $rendered->getStatusCode();

        if(empty($message)) {
            $message = $exception->getMessage();
        }

        $errors = [];

        if($debug) {
            $errors['exception'] = get_class($exception);
            $errors['trace'] = explode("\n", $exception->getTraceAsString());
        }
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
            'errors' => $errors,
        ], $status_code);

        // return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticate',
            'data' => null
        ], 401);
    }

}
