<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function render($request)
    {
        return response()->view('errors.403', [], 403);
    }
}