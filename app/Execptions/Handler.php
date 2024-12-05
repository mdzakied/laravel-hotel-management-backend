<?php

// namespace App\Exceptions;

// use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Illuminate\Auth\AuthenticationException;
// use Throwable;

// class Handler extends ExceptionHandler
// {
//     /**
//      * A list of the exception types that are reported.
//      *
//      * @var array
//      */
//     protected $reportable = [
//         \Throwable::class,
//     ];

//     /**
//      * A list of the exception types that are not reported.
//      *
//      * @var array
//      */
//     protected $dontReport = [];

//     /**
//      * Render an exception into an HTTP response.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Throwable  $exception
//      * @return \Illuminate\Http\Response
//      */
//     public function render($request, Throwable $exception)
//     {
//         // AuthenticationException for API
//         if ($exception instanceof AuthenticationException) {
//             if ($request->expectsJson()) {
//                 return response()->json(['message' => 'Unauthenticated'], 401);
//             }
//         }

//         return parent::render($request, $exception);
//     }
    
// }
