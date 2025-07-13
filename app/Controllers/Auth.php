<?php

// app/Controllers/Auth.php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

// Ensure this is imported

class Auth extends BaseController
{
    public function login()
    {
        // Capture the redirect URL before processing
        $data['redirect'] = $this->request->getGet('redirect') ?? '/'; // Default redirect to home

        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Wishlist is authenticated
                session()->set('user_id', $user['id']);
                session()->setFlashdata('success', 'You have been successfully logged in.');

                // Redirect to the stored URL or default
                return redirect()->to($data['redirect']);
            } else {
                $data['error'] = 'Invalid email or password.';
            }
        }
        return view('Auth/login', $data); // Assuming Auth/login view exists
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $pass  = $this->request->getPost('password');
            $confirmPass = $this->request->getPost('confirm_password');

            $data = []; // Initialize data array for view

            // Basic validation
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Invalid email address format.';
            } elseif (strlen($pass) < 6) {
                $data['error'] = 'Password must be at least 6 characters long.';
            } elseif ($pass !== $confirmPass) {
                $data['error'] = 'Passwords do not match.';
            } else {
                $userModel = new UserModel();
                try {
                    $userModel->insert([
                        'email'         => $email,
                        'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
                    ]);
                    session()->set('user_id', $userModel->getInsertID());
                    session()->setFlashdata('success', 'Registration successful! You are now logged in.');
                    return redirect()->to('/'); // Redirect to home or a welcome page
                } catch (DatabaseException $e) {
                    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        $data['error'] = 'This email address is already registered.';
                    } else {
                        $data['error'] = 'An unexpected error occurred during registration.';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'An unexpected error occurred: ' . $e->getMessage();
                }
            }
        }
        return view('Auth/register', $data ?? []); // Assuming Auth/register view exists
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been successfully logged out.');
        return redirect()->to(url_to('login')); // Redirect to login page
    }
}
