<?php

namespace App\Controllers;

use App\Models\UserModel; // Ensure UserModel is included if used in new methods
use CodeIgniter\Controller; // Keep this use statement for clarity, though BaseController typically extends Controller

class UserController extends BaseController // Prefer BaseController as it's more common for application controllers
{
    /**
     * Displays the main user account page from HEAD.
     * This is typically the default entry point for the user's account section.
     */
    public function index()
    {
        // Ensure user is logged in (add this if not already handled by a filter)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Example: load user data
        $userModel = new UserModel(); // Assuming UserModel is correctly setup
        $userId = session()->get('user_id'); // Assuming 'user_id' is stored in session
        $user = $userModel->find($userId);

        $data = [
            'title' => 'My Account', // Add a title
            'user' => $user, // Pass the full user object
        ];

        return view('Customer/account', $data); // Assuming 'Customer/account' is the correct view
    }

    /**
     * Displays the user dashboard, potentially from the remote branch.
     * This might serve as a different entry point or specific dashboard view.
     */
    public function dashboard()
    {
        // Ensure user is logged in (add this if not already handled by a filter)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Data might be minimal or loaded specifically for a dashboard overview
        $data = [
            'title' => 'User Dashboard',
            // Add dashboard specific data here if needed
        ];

        return view('Home/index', $data); // This view path was in the remote, adjust if 'User/dashboard' is more appropriate
    }
}