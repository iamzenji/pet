<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Handle login and check user roles for redirection.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('administrator')) {
            session(['admin_logged_in' => true]);
            return redirect()->route('account'); // Redirect to admin dashboard
        }

        if ($user->hasRole('user')) {
            return redirect()->route('pets.create'); // Redirect to user dashboard
        }

        if ($user->hasRole('reader')) {
            return redirect()->route('pets.index'); // Redirect to reader dashboard
        }

        return redirect()->route('home'); // Default fallback
    }

    /**
     * Logout and clear session.
     */
    public function logout(Request $request)
    {
        session()->forget('admin_logged_in');
        Auth::logout();
        return redirect('/login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
