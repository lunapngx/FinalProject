<?php

namespace App\Controllers;

// This is the fix: The class now extends BaseController
class RegisterController extends BaseController
{
    public function index()
    {
        return view('register');
    }

    public function attemptRegister()
    {
        $userModel = new \App\Models\UserModel();

        // Validation rules
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'    => 'required|min_length[6]|max_length[100]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            return view('register', [
                'validation' => $this->validator
            ]);
        }

        // If validation passes, create the user
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $userModel->save($data);

        // Get the newly created user's ID and data
        $lastInsertId = $userModel->insertID();
        $newlyRegisteredUser = $userModel->find($lastInsertId);

// Set session data to log the user in
        $ses_data = [
            'user_id'    => $newlyRegisteredUser['id'],
            'user_name'  => $newlyRegisteredUser['username'],
            'user_email' => $newlyRegisteredUser['email'],
            'isLoggedIn' => TRUE
        ];
        session()->set($ses_data);

// Redirect to the account page with a success message
        return redirect()->to('/account')->with('msg_success', 'Registration successful! Welcome to your account!');
    }
}
