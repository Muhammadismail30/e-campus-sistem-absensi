<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // The redirect should not be here since this method must return a View.
        // You can handle the redirect in middleware or in the route definition.
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // TODOS: Logic for redirecting based on user role

        return redirect()->intended(route($request->user()->role . '.dashboard'));
    }
    // protected function authenticated(Request $request, $user)
    // {
    //     return redirect()->route('dashboard');
    //     // You can add any additional logic here after successful authentication
    //     // For example, logging the login event or redirecting to a specific page
    // }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
