<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Database;
use App\Models\Job;

class HomeController
{
    public static function docs(Request $request)
    {
        view('docs');
    }
    public static function index(Request $request)
    {  
        // return sendJson($request->all());
        // $jobs = Job::where('created_at', '!=', 'null')->orderBy('created_at', 'desc')->paginate(20,200); 
        $jobs = db()->table('jobs')->paginate(20);
        sendJson($jobs);
        view('index');
    }
}
