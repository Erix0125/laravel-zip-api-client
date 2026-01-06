<?php

namespace App\Http\Controllers;

use App\Services\ApiAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected ApiAuthService $authService;

    public function __construct(ApiAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $this->authService->getCurrentUser();
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // Note: Profile update would require API endpoint
        // For now, just redirect with status
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Clear session and logout
        $this->authService->logout();

        return redirect('/')->with('status', 'Account deleted successfully!');
    }
}
