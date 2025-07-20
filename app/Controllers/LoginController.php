<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;

class LoginController extends ShieldLoginController
{
    /**
     * Override the loginAction to redirect users based on their group.
     */
    public function loginAction(): RedirectResponse
    {
        $result = parent::loginAction();

        if (auth()->loggedIn() && $result->hasHeader('Location')) {
            $user = auth()->user();

            // Check for admin group first
            if ($user->inGroup('admin')) {
                return redirect()->route('admin_dashboard')->withCookies(); // Changed this line
            }

            // Then check for user group
            if ($user->inGroup('user')) {
                return redirect()->route('Home/index')->withCookies();
            }

            // Fallback for other groups
            return redirect()->route('dashboard')->withCookies();
        }

        return $result;
    }
}