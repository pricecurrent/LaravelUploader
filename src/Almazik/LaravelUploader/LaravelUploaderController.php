<?php

namespace Almazik\LaravelUploader;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LaravelUploaderController extends Controller
{
    public function index()
    {
        return view('laravelUploader::greeting')->with('greeting', 'Got it working');
    }
}
