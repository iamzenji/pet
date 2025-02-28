<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Handle login and check if the user is admin.
     */
    protected function authenticated(Request $request, $user)
    {
        // admin- not working
        $adminEmail = Config::get('app.admin_email');

        if (strtolower($user->email) === strtolower($adminEmail)) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        // user role
        if ($user->roles()->where('name', 'User')->exists()) {
            return redirect()->route('user.dashboard');
        } elseif ($user->roles()->where('name', 'Reader')->exists()) {
            return redirect()->route('reader.dashboard');
        }

        return redirect('/home');
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
