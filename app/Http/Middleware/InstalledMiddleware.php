<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class InstalledMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $installFile = File::exists(base_path('install'));
        // $updateFile = File::exists(base_path('update'));
        // if ($installFile) {
        //     return redirect()->route('install');
        // }
        // if ($updateFile) {
        //     return redirect()->route('update');
        // }
        return $next($request);
    }
}