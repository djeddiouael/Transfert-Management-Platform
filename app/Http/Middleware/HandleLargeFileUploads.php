<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleLargeFileUploads
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST')) {
            // Set PHP configuration for large file uploads
            ini_set('upload_max_filesize', '20M');
            ini_set('post_max_size', '20M');
            ini_set('memory_limit', '256M');
            ini_set('max_execution_time', '300');
            ini_set('max_input_time', '300');
            
            // Reset the content length
            $request->server->set('CONTENT_LENGTH', 0);
        }

        return $next($request);
    }
} 