<?php

namespace App\Controllers;

// This is the fix: The class now extends BaseController
class LoginController extends BaseController
{
    public function index()
    {
        // If user is already logged in, redirect to account page
        if (session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        return view('login');
    }

    public function attemptLogin()
    {
        $session = session();
        $userModel = new \App\Models\UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // In a real app, you'd use the password_hash from the database
            // For this project, it seems the auth library handles it.
            // This is a simplified check.
            if (password_verify($password, $user['password_hash'])) {
                $ses_data = [
                    'user_id'    => $user['id'],
                    'user_name'  => $user['username'],
                    'user_email' => $user['email'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/account');
            }
        }

        $session->setFlashdata('msg', 'Wrong Email or Password');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
