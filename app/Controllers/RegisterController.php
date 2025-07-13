<?php

namespace App\Controllers;

// This is the fix: The class now extends BaseController
class RegisterController extends BaseController
{
    public function index()
    {
        return view('register');
    }

    // In app/Controllers/RegisterController.php

    public function attemptRegister()
    {
        // ... (Your existing validation code) ...

        // If validation passes
        $users = model('UserModel'); // Or your actual User model

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'customer', // Assuming default role is 'customer'
            'is_verified' => false, // New: User is not verified initially
            'verification_hash' => bin2hex(random_bytes(32)), // Generate a unique hash
        ];

        if ($users->save($data)) {
            // Send verification email
            $email = \Config\Services::email();
            $email->setFrom('your_email@example.com', 'Your Shopping System');
            $email->setTo($data['email']);
            $email->setSubject('Verify Your Account');
            $verificationLink = site_url('auth/verify-email/' . $data['verification_hash']);
            $message = "Please click the following link to verify your account: " . $verificationLink;
            $email->setMessage($message);

            if ($email->send()) {
                return redirect()->to('/register')->with('success', 'Registration successful! Please check your email to verify your account.');
            } else {
                log_message('error', $email->printDebugger(['headers']));
                return redirect()->back()->withInput()->with('error', 'Registration successful, but failed to send verification email. Please contact support.');
            }

        } else {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
    }
}
