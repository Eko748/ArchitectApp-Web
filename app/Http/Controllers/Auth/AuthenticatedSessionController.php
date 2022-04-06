<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.signin');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();
        if (Auth::user()->level == 'admin') {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else if (Auth::user()->level == 'konsultan') {
            return redirect()->intended(RouteServiceProvider::KONSULTAN);
        } else if (Auth::user()->level == 'kontraktor') {
            return redirect()->intended(RouteServiceProvider::KONTRAKTOR);
        } else if (Auth::user()->level == 'owner') {
            return redirect()->intended(RouteServiceProvider::USER);
        } else {
            return abort(403);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();
        Auth::logout();
        return redirect('/login');
    }
    public function storeAjax(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();
        if (Auth::user()->level == 'admin') {
            return response()->json(RouteServiceProvider::HOME);
        } else if (Auth::user()->level == 'konsultan') {
            return response()->json(RouteServiceProvider::KONSULTAN);
        } else if (Auth::user()->level == 'kontraktor') {
            return response()->json(RouteServiceProvider::KONTRAKTOR);
        } else if (Auth::user()->level == 'owner') {
            return response()->json(RouteServiceProvider::USER);
        } else {
            return abort(403);
        }
    }
}
