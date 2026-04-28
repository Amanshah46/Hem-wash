<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;


class RedirectIfNotInstalled
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
        // elseif($updateFile)
        // {
        //     return redirect()->route('update');
        // }
        return $next($request);
    }
}
