<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Models\UserModel; // Assuming you use this

class LoginController extends BaseController
{
    // ... (other methods)

    public function loginAction(): RedirectResponse
    {
        // ... (your existing login logic)

        if ($result->isOK()) {
            // Get the user after successful login
            $user = auth()->user();

            // Check for admin group first
            if ($user->inGroup('admin')) {
                return redirect()->route('admin_dashboard')->withCookies();
            }

            // Then check for user group
            if ($user->inGroup('user')) {
                return redirect()->route('home_page')->withCookies(); // <<< Make sure this line is exactly like this
            }

            // Fallback for other groups
            // You might want to define a specific 'dashboard' route for general users
            // Or remove this if 'user' group covers all non-admin.
            return redirect()->route('home_page')->withCookies(); // Or an appropriate default route
        }

        return $result; // Handle failed login attempts (e.g., redirect back with errors)
    }
    public function loginView(): string
    {
        // If the user is already logged in, redirect them to a different page (e.g., home or dashboard)
        if (auth()->loggedIn()) {
            // Ensure you have these named routes defined in app/Config/Routes.php
            // 'home_page' for '/'
            // 'admin_dashboard' for '/admin' (or wherever your admin dashboard is)
            $user = auth()->user();
            if ($user->inGroup('admin')) {
                return redirect()->route('admin_dashboard');
            }
            return redirect()->route('home_page');
        }

        return view('login'); // This loads your app/Views/login.php file
    }

    // ... (your existing loginAction method) ...

    public function logoutAction(): RedirectResponse
    {
        // ... (your existing logoutAction method content) ...
    }
}