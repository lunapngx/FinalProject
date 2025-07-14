<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Exception;

class AuthController extends BaseController
{
    protected $session;
    protected $helpers = ['form', 'url', 'auth'];

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }

    /**
     * Login page for both admin and user.
     */
    public function login()
    {
        helper(['form', 'url']);

        // If already logged in, redirect accordingly
        if ($this->session->get('isLoggedIn')) {
            if ($this->session->get('role') === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            return redirect()->to('/account');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[8]|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                return view('login', $data);
            }

            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user      = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password_hash'])) {
                if (isset($user['is_verified']) && !$user['is_verified']) {
                    return redirect()->back()->withInput()->with('error', 'Please verify your email address before logging in.');
                }

                $ses_data = [
                    'id'        => $user['id'],
                    'fullname'  => $user['fullname'],
                    'username'  => $user['username'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'isLoggedIn' => true,
                ];
                $this->session->set($ses_data);

                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/account');
                }
            } else {
                session()->setFlashdata('error', 'Invalid Email or Password.');
                $data['validation'] = $this->validator;
                return view('login', $data);
            }
        }

        // GET: show login form
        return view('login');
    }

    /**
     * Registration page for users.
     */
    public function register()
    {
        if ($this->session->get('isLoggedIn')) {
            if ($this->session->get('role') === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            return redirect()->to('/account');
        }

        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'fullname'         => 'required|min_length[3]|max_length[255]',
                'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email'            => 'required|valid_email|is_unique[users.email]',
                'password'         => 'required|min_length[8]',   // strong passwords
                'password_confirm' => 'required|matches[password]',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $userModel = new UserModel();
                try {
                    $userData = [
                        'fullname'      => $this->request->getPost('fullname'),
                        'username'      => $this->request->getPost('username'),
                        'email'         => $this->request->getPost('email'),
                        'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                        'role'          => 'user', // Default to user
                        'is_verified'   => 0,
                        'status'        => 'active',
                    ];
                    $userModel->save($userData);
                    session()->setFlashdata('success', 'Registration successful! Please log in.');
                    return redirect()->to('/login');
                } catch (DatabaseException $e) {
                    session()->setFlashdata('error', 'Database error: Could not complete registration. Please try again.');
                    return redirect()->back()->withInput();
                } catch (Exception $e) {
                    session()->setFlashdata('error', 'An unexpected error occurred during registration. Please try again.');
                    return redirect()->back()->withInput();
                }
            }
        }
        return view('register', $data);
    }

    /**
     * Logout for both admin and user.
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')->with('success', 'You have been successfully logged out.');
    }

    /**
     * Email Verification (if used).
     */
    public function verifyEmail($hash)
    {
        $userModel = new UserModel();
        $user = $userModel->where('verification_hash', $hash)->first();

        if ($user) {
            $userModel->update($user['id'], [
                'is_verified' => true,
                'verification_hash' => null,
            ]);
            return redirect()->to('/login')->with('success', 'Email successfully verified! You can now log in.');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid or expired verification link.');
        }
    }
}