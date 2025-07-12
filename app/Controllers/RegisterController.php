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

        return redirect()->to('/login')->with('msg_success', 'Registration Successful');
    }
}
