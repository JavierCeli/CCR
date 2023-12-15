<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        $jsonresponse = parent::render($request, $e);
        $dataToSet = $jsonresponse->getData();
        \Log::error("Route: " . $request->fullUrl() . " " . json_encode($dataToSet,JSON_PRETTY_PRINT));
        unset($dataToSet->trace);
        $jsonresponse->setData(
            [
                'code' => 1499,
                'message' => 'Error no capturado en controlador (' . env('APP_NAME') .')',
                'time' => (new \DateTime())->format('Y-m-d H:i:s.u'),
                'data' => $dataToSet
            ]
        );
        return $jsonresponse;
    }

    /**
     * Determine if the exception handler response should be JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return bool
     */
    protected function shouldReturnJson($request, Throwable $e)
    {
        return true;
    }
}
