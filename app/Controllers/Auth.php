<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

class Auth extends BaseController
{
    public function login()
    {
        $data = ['redirect' => $this->request->getGet('redirect') ?? '/'];

        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password_hash'])) {
                session()->set([
                    'user_id' => $user['id'],
                    'isLoggedIn' => true,
                    'role' => $user['role'] ?? 'user'
                ]);
                session()->setFlashdata('success', 'You have been successfully logged in.');

                if (($user['role'] ?? 'user') === 'admin') {
                    return redirect()->to('/admin');
                }

                return redirect()->to($data['redirect']);
            } else {
                $data['error'] = 'Invalid email or password.';
            }
        }
        return view('Auth/login', $data);
    }

    public function register()
    {
        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'matches[password]'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $userModel = new UserModel();
                $userModel->save([
                    'email'         => $this->request->getPost('email'),
                    'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role'          => 'user', // Default role
                ]);
                session()->setFlashdata('success', 'Registration successful! Please log in.');
                return redirect()->to('/login');
            }
        }
        return view('Auth/register', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been successfully logged out.');
    }
}