<?php

use Illuminate\Validation\ValidationException;

public function render($request, Throwable $exception)
{
    if ($exception instanceof ValidationException) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => $exception->errors(),
        ], 422);
    }

    return parent::render($request, $exception);
}
