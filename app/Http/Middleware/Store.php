<?php

namespace App\Http\Middleware;

use App\Livewire\Installer\InstallController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Store
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expenseHelper = new InstallController();
        $hasFile = $expenseHelper->check_for_icecream();
        // if(!$hasFile)
        // {
        //     Auth::logout();
        //     Session::flush();
        //     return redirect()->route('license');
        // }
        if ((Auth::check()) && (Auth::user()->user_type==2 || Auth::user()->user_type==1)) {
            $randomNumber = rand(1, 10);
            // if($randomNumber > 9){
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
        return $next($request);
    }
}
