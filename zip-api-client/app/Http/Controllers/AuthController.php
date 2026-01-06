<?php

namespace App\Http\Controllers;

use App\Services\ApiAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected ApiAuthService $authService;

    public function __construct(ApiAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request via API
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = $this->authService->login(
            $request->input('email'),
            $request->input('password')
        );

        if ($result) {
            return redirect()->route('dashboard')
                ->with('status', 'Logged in successfully!');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->withInput();
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login')
            ->with('status', 'Logged out successfully!');
    }

    /**
     * Show dashboard with user info
     */
    public function dashboard()
    {
        $user = $this->authService->getCurrentUser();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('dashboard', ['user' => $user]);
    }
}
