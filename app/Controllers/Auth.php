<?php

// app/Controllers/Auth.php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $model = new UserModel();
            $user = $model->where('email', $this->request->getPost('email'))->first();

            // Verify password and user existence
            if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                $session = session();
                $session->set([
                    'id' => $user['id'],
                    'role' => $user['role'],
                    'isLoggedIn' => true,
                ]);

                // Redirect based on user role
                if ($user['role'] === 'admin') {
                    // Correct: Redirect to the named admin route
                    return redirect()->route('/admin/dashboard');
                } else {
                    // Correct: Redirect to the user's view
                    return redirect()->to('/user/dashboard');
                }
            } else {
                return redirect()->to('/login')->with('error', 'Invalid credentials');
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $pass  = $this->request->getPost('password');
            $confirmPass = $this->request->getPost('confirm_password');

            $data = [];

            // Validation
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
                    return redirect()->to('/');
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
        return view('Auth/register', $data ?? []);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}