<?php namespace App\Controllers; // Namespace must be App\Controllers as per your file structure

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AccountController serves as the single entry point for the user's consolidated account dashboard.
 * All specific account sections (orders, settings, addresses, etc.) are handled dynamically
 * within the 'myprofile.php' view via JavaScript.
 */
class AccountController extends BaseController
{
    /**
     * Loads the main user account dashboard view.
     * This view contains the sidebar navigation and all content sections.
     * The specific section to display initially is determined by JavaScript based on the URL path.
     */
    public function index(): ResponseInterface
    {
        // Ensure the user is logged in before accessing any account features
        if (!auth()->loggedIn()) {
            return redirect()->to(url_to('login')); // Redirect unauthenticated users to the login page
        }

        // Fetch the current authenticated user object to pass to the view
        $user = auth()->user();

        // Prepare data to be passed to the view
        $data = [
            'title' => 'My Account Dashboard', // A general title for the entire account area
            'user' => $user, // User data for profile summary or forms
            // You can add more data here that might be needed globally across the account dashboard,
            // or fetch specific data for sections using AJAX if they are very large.
        ];

        // Load the main consolidated view file for the user account dashboard
        // as content within the master layout.
        return $this->response->setBody(
            view('Layout/master', [
                'title' => $data['title'],
                'content' => view('Profilebutton/myprofile', $data) // Ensure this path is correct
            ])
        );
    }

    /**
     * Handles the 'My Orders' section of the account.
     */
    public function orders()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(url_to('login'));
        }
        // Data for the 'My Orders' section, if needed
        $data = [
            'title' => 'My Orders',
            'user' => auth()->user(),
            // Fetch user's orders here
        ];
        return view('Layout/master', ['title' => $data['title'], 'content' => view('Profilebutton/myprofile', $data)]);
    }

    /**
     * Handles the 'Account Settings' section of the account.
     */
    public function settings()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(url_to('login'));
        }
        $data = [
            'title' => 'Account Settings',
            'user' => auth()->user(),
            // Data for settings forms
        ];
        return view('Layout/master', ['title' => $data['title'], 'content' => view('Profilebutton/myprofile', $data)]);
    }

    /**
     * Handles the 'Payment Methods' section of the account.
     */
    public function paymentMethods()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(url_to('login'));
        }
        $data = [
            'title' => 'Payment Methods',
            'user' => auth()->user(),
            // Data for payment methods
        ];
        return view('Layout/master', ['title' => $data['title'], 'content' => view('Profilebutton/myprofile', $data)]);
    }

    /**
     * Handles the 'My Reviews' section of the account.
     */
    public function reviews()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(url_to('login'));
        }
        $data = [
            'title' => 'My Reviews',
            'user' => auth()->user(),
            // Data for user reviews
        ];
        return view('Layout/master', ['title' => $data['title'], 'content' => view('Profilebutton/myprofile', $data)]);
    }

    /**
     * Handles the 'Addresses' section of the account.
     */
    public function addresses()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(url_to('login'));
        }
        $data = [
            'title' => 'My Addresses',
            'user' => auth()->user(),
            // Data for user addresses
        ];
        return view('Layout/master', ['title' => $data['title'], 'content' => view('Profilebutton/myprofile', $data)]);
    }

    /**
     * Handles the 'Help Center' section of the account.
     */
    public function help()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(url_to('login'));
        }
        $data = [
            'title' => 'Help Center',
            'user' => auth()->user(),
            // Data for help content
        ];
        return view('Layout/master', ['title' => $data['title'], 'content' => view('Profilebutton/myprofile', $data)]);
    }
}