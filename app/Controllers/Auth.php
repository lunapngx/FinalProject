<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

class Auth extends BaseController
{
    public function login()
    {
        // Conflict 1: Initial data for redirect - kept from HEAD for flexibility
        $data = ['redirect' => $this->request->getGet('redirect') ?? '/'];

        if ($this->request->getMethod() === 'post') {
            $userModel = new UserModel(); // Renamed $model to $userModel for consistency
            $email = $this->request->getPost('email'); // Explicitly get email
            $password = $this->request->getPost('password'); // Explicitly get password

            $user = $userModel->where('email', $email)->first();

            // Conflict 1 (continued): Login authentication and session setting
            // Combined logic from both HEAD and remote for robustness
            if ($user && password_verify($password, $user['password_hash'])) { // Using password_hash from HEAD, and $password variable
                $session = session();
                $session->set([
                    'user_id' => $user['id'], // Prefer 'user_id' from HEAD
                    'isLoggedIn' => true,
                    'role' => $user['role'] ?? 'user' // Ensures 'user' is default if role is not set, from HEAD
                ]);
                $session->setFlashdata('success', 'You have been successfully logged in.'); // From HEAD

                // Conflict 1 (continued): Redirect logic - combined for flexibility
                if (($user['role'] ?? 'user') === 'admin') { // Check role from combined session data
                    // Prioritize named route for admin dashboard if available, otherwise direct path
                    return redirect()->to(url_to('admin_dashboard') ?? '/admin');
                } else {
                    // Redirect to the original requested page or user dashboard
                    return redirect()->to($data['redirect'] ?? '/user/dashboard'); // Combined flexibility from HEAD and remote's user dashboard
                }
            } else {
                // Error message for invalid credentials
                return redirect()->to('/login')->with('error', 'Invalid email or password.'); // Kept remote's redirect with error message
            }
        }
        // Conflict 1 (continued): Return view for login form
        return view('Auth/login', $data); // Kept $data for redirect
    }

    public function register()
    {
        $data = []; // Initialize $data for validation/error messages
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'matches[password]'
            ];

            // Conflict 2: Validation and user saving logic
            // Prioritized HEAD's CI4 validation and integrated remote's try/catch for database errors
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator; // Set validation errors
            } else {
                $userModel = new UserModel();
                try {
                    // Use save() from HEAD, which handles both insert/update and sets default role
                    $userModel->save([
                        'email'         => $this->request->getPost('email'),
                        'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                        'role'          => 'user', // Default role from HEAD
                    ]);
                    session()->setFlashdata('success', 'Registration successful! Please log in.'); // From HEAD
                    return redirect()->to('/login'); // Redirect to login after registration, from HEAD
                } catch (DatabaseException $e) { // From remote
                    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        $data['error'] = 'This email address is already registered.';
                    } else {
                        $data['error'] = 'An unexpected database error occurred during registration.';
                    }
                } catch (Exception $e) { // From remote
                    $data['error'] = 'An unexpected error occurred: ' . $e->getMessage();
                }
            }
        }
        // Conflict 2 (continued): Return view for registration form
        return view('Auth/register', $data); // Kept $data for displaying errors/validation
    }

    public function logout()
    {
        session()->destroy();
        // Conflict 3: Logout redirect - kept HEAD's version with success message
        return redirect()->to('/login')->with('success', 'You have been successfully logged out.');
    }
}