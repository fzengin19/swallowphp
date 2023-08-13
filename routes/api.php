<?php

namespace Routes;

use App\Core\Router;
use App\Http\Controllers\HomeController;
use App\Http\Middlewares\AuthMiddleware;

Router::get('/', [HomeController::class,'index']);
Router::get('/user/{user}/about', "HomeController@index");
