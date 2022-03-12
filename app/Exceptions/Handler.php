<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use App\Traits\ApiResponse;

class Handler extends ExceptionHandler
{
		use ApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
	    $this->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
		    return $this->errorResponse("xxx", 422);
	    });
	
	    $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
		    return $this->errorResponse($e->getMessage(), 405);
	    });
	
	    $this->renderable(function (NotFoundHttpException $e, $request) {
		    if($e->getPrevious() instanceof ModelNotFoundException) {
			    $modelName = strtolower(class_basename($e->getPrevious()->getModel()));
			    return $this->errorResponse("Does not exists any {$modelName} with the specified identificator", 404);
		    }
		    return $this->errorResponse('The specified URL cannot be found', 404);
	    });
    }
}
