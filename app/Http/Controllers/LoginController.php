<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // ✅ Correct path
    }

    // Handle login form submission
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on user role
            if ($user->role === 'admin') {
                // Redirect admins directly to admin dashboard
                return redirect()->route('admin.dashboard');
            }

            // For business owners, check if they have a business profile
            if ($user->role === 'business_owner') {
                // If business profile exists, route by type
                if ($user->businessProfile) {
                    $type = $user->businessProfile->business_type;
                    switch ($type) {
                        case 'hotel':
                            return redirect()->route('business.my-hotel');
                        case 'resort':
                            return redirect()->route('business.my-resort');
                        default:
                            return redirect()->route('business.my-shop');
                    }
                } else {
                    // No business profile yet, redirect to business setup
                    return redirect()->route('business.setup')
                        ->with('info', 'Please complete your business setup.');
                }
            }

            // For customers, check if they have a profile
            if ($user->role === 'customer') {
                if (!$user->profile) {
                    return redirect()->route('profile.setup');
                }
                return redirect()->route('customer.products');
            }

            // Default redirect for customers
            return redirect()->route('customer.products');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    /**
     * Show the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a password reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}