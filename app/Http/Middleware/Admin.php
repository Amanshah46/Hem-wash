<?php

namespace App\Http\Middleware;

use App\ExpenseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((Auth::check()) && (Auth::user()->user_type==1)) {
            /* if the user type is admin */
            $randomNumber = rand(1, 10);
            // if($randomNumber > 8){
            //     $expenseHelper = new InstallController();
            //     $validation = $expenseHelper->verify_license();
            //     if(!isset($validation['status']) || $validation['status'] != true)
            //     {
            //         Auth::logout();
            //         Session::flush();
            //         return redirect()->route('license');
            //     }
            // }
            return $next($request);
        }
        return redirect('/');
    }
}
