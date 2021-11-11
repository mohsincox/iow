<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;

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
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                $flavor =DB::table('attribute_meta')
                    ->join('attributes', 'attributes.id', '=', 'attribute_meta.attribute_id')
                    ->whereNull('attributes.deleted_at')
                    ->whereNull('attribute_meta.deleted_at')
                    ->where('attributes.name', '=', "Flavor")
                    ->select('attribute_meta.value As name', 'attribute_meta.id As id')
                    ->get();
                return response()->view('site.errors.404', ['flavor'=> $flavor], 404);
            }
        }
        return parent::render($request, $exception);
    }
}
