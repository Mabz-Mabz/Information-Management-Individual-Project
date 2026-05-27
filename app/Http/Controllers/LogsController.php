<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LogsController extends Controller
{
    public function show()
    {
        Log ::debug("============= LogsController: Start Show Logs ================");
        $path = storage_path('logs/laravel.log');
        $logs = File::exists($path) ? File::get($path) : 'No logs found.';

        $lines = explode("\n", $logs);
        $recent = array_slice(array_filter($lines), -100); // last 100 non-empty lines

        return view('audit.logs', compact('recent'));
    }
}
