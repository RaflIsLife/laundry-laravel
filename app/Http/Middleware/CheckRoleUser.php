<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            switch (Auth::user()->role) {
                case 'customer':
                    return redirect()->route('user')->with('status', 'Anda bukan admin!!');

                case 'kasir':
                    return redirect()->route('kasir')->with('status', 'Anda bukan admin!!');

                case 'kurir': //todo: saat menambah halaman kurir, ubah ini
                    return redirect()->route('home')->with('status', 'Anda bukan admin!!');


                default:
                    return redirect()->route('home');
            }
        }
        return $next($request);
    }
}
