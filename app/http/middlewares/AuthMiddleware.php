<?php

namespace App\Http\Middlewares;

use App\Core\Request;
use App\Http\Middlewares\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    public function handle(Request $request)
    {
        $request->set('id', 1453);
        $request->set('name', 1453);
    }
}
