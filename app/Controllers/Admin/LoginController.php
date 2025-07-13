<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class LoginController extends BaseController
{
    public function index()
    {
        // If already logged in, redirect to the dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('Admin/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new AdminModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $model->where('username', $username)->first();

        if ($admin) {
            // Verify the password
            if (password_verify($password, $admin['password'])) {
                // Password is correct, set session data
                $ses_data = [
                    'admin_id'       => $admin['id'],
                    'admin_username' => $admin['username'],
                    'admin_fullname' => $admin['fullname'],
                    'admin_logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/admin/dashboard');
            }
        }

        // If login fails, redirect back with an error message
        $session->setFlashdata('msg', 'Invalid username or password');
        return redirect()->to('/admin/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
