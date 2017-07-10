<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that should not be reported.
   *
   * @var array
   */
  protected $dontReport = [
    \Illuminate\Auth\AuthenticationException::class,
    \Illuminate\Auth\Access\AuthorizationException::class,
    \Symfony\Component\HttpKernel\Exception\HttpException::class,
    \Illuminate\Database\Eloquent\ModelNotFoundException::class,
    \Illuminate\Session\TokenMismatchException::class,
    \Illuminate\Validation\ValidationException::class,
  ];

  /**
   * Report or log an exception.
   *
   * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
   *
   * @param  \Exception $exception
   * @return void
   */
  public function report(Exception $exception)
  {
    parent::report($exception);
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Exception $exception
   * @return \Illuminate\Http\Response
   */
  public function render($request, Exception $exception)
  {
    if ($exception instanceof AuthenticationException) {
      return $this->unauthenticated($request, $exception);
    }

    $code = 500;
    if ($exception instanceof HttpExceptionInterface) {
      $code = $exception->getStatusCode();
    }
    $message = $exception->getMessage();
    if ($request->expectsJson()) {
      $errors = [];
      if ($exception instanceof ValidationException) {
        $code = 422;
        $errors = $exception->validator->getMessageBag();
        $message = $errors->first();
      }

      return response()->json(['code' => $code, 'errors' => $errors, 'message' => $message], $code);
    }

    if ($code == 200) {
      return response($message);
    }
    return parent::render($request, $exception);
  }

  /**
   * Convert an authentication exception into an unauthenticated response.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Illuminate\Auth\AuthenticationException $exception
   * @return \Illuminate\Http\Response
   */
  protected function unauthenticated($request, AuthenticationException $exception)
  {
    if ($request->expectsJson()) {
      return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    return redirect()->guest(route('login'));
  }
}
