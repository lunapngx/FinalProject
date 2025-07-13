<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class RegisterController extends BaseController
{
    public function __construct()
    {
        // This is the fix: Load the form helper to make functions
        // like set_value() available in the view.
        helper('form');
    }

    public function index()
    {
        // Show the registration form
        return view('Admin/register');
    }

    public function attemptRegister()
    {
        $session = session();
        $model = new AdminModel();

        // Validation rules
        $rules = [
            'fullname' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|min_length[3]|max_length[255]|is_unique[admins.username]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            // If validation fails, return to the form with errors
            return view('Admin/register', [
                'validation' => $this->validator
            ]);
        }

        // If validation passes, create the new admin
        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $model->save($data);

        // Redirect to the login page with a success message
        $session->setFlashdata('msg_success', 'Registration successful! Please log in.');
        return redirect()->to('/admin/login');
    }
}
