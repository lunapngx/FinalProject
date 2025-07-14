<?php namespace App\Controllers;

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

        // Log current session state before processing login attempt
        log_message('debug', 'Login Page Access - Current Session: ' . print_r($this->session->get(), true));
        log_message('debug', 'Login Page Access - IsLoggedIn: ' . ($this->session->get('isLoggedIn') ? 'true' : 'false') . ', Role: ' . $this->session->get('role'));

        // If already logged in, redirect accordingly
        if ($this->session->get('isLoggedIn')) {
            if ($this->session->get('role') === 'admin') {
                log_message('debug', 'Already logged in as admin, redirecting to /admin/dashboard');
                return redirect()->to('/admin/dashboard');
            }
            log_message('debug', 'Already logged in as user, redirecting to /account');
            return redirect()->to('/account');
        }

        if ($this->request->getMethod() === 'post') {
            log_message('debug', 'Login form submitted.');

            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[8]|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                log_message('debug', 'Login validation failed: ' . print_r($this->validator->getErrors(), true));
                $data['validation'] = $this->validator;
                return view('login', $data);
            }

            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user      = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password_hash'])) {
                if (isset($user['is_verified']) && !$user['is_verified']) {
                    log_message('debug', 'User email not verified: ' . $email);
                    return redirect()->back()->withInput()->with('error', 'Please verify your email address before logging in.');
                }

                // After successful user verification
                $ses_data = [
                    'id'        => $user['id'],
                    'fullname'  => $user['fullname'],
                    'username'  => $user['username'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'isLoggedIn' => true,
                ];
                $this->session->set($ses_data);

                // Add debug log here to check session data after setting
                log_message('debug', 'Login successful! Session data set: ' . print_r($this->session->get(), true));

                if ($user['role'] === 'admin') {
                    log_message('debug', 'User is admin, redirecting to /admin/dashboard');
                    return redirect()->to('/admin/dashboard');
                } else {
                    log_message('debug', 'User is regular user, redirecting to /account');
                    return redirect()->to('/account');
                }
            } else {
                log_message('debug', 'Invalid login credentials for email: ' . $email);
                session()->setFlashdata('error', 'Invalid Email or Password.');
                $data['validation'] = $this->validator;
                return view('login', $data);
            }
        }

        // GET: show login form
        log_message('debug', 'Displaying login form.');
        return view('login');
    }

    /**
     * Registration page for users.
     */
    public function register()
    {
        // Log current session state before processing registration attempt
        log_message('debug', 'Register Page Access - Current Session: ' . print_r($this->session->get(), true));
        log_message('debug', 'Register Page Access - IsLoggedIn: ' . ($this->session->get('isLoggedIn') ? 'true' : 'false') . ', Role: ' . $this->session->get('role'));

        if ($this->session->get('isLoggedIn')) {
            if ($this->session->get('role') === 'admin') {
                log_message('debug', 'Already logged in as admin, redirecting to /admin/dashboard from register.');
                return redirect()->to('/admin/dashboard');
            }
            log_message('debug', 'Already logged in as user, redirecting to /account from register.');
            return redirect()->to('/account');
        }

        $data = [];
        if ($this->request->getMethod() === 'post') {
            log_message('debug', 'Registration form submitted.');

            $rules = [
                'fullname'         => 'required|min_length[3]|max_length[255]',
                'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email'            => 'required|valid_email|is_unique[users.email]',
                'password'         => 'required|min_length[8]',   // strong passwords
                'password_confirm' => 'required|matches[password]',
            ];

            if (!$this->validate($rules)) {
                log_message('debug', 'Registration validation failed: ' . print_r($this->validator->getErrors(), true));
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
                    log_message('debug', 'User registered successfully: ' . $userData['email']);
                    session()->setFlashdata('success', 'Registration successful! Please log in.');
                    return redirect()->to('/login');
                } catch (DatabaseException $e) {
                    log_message('error', 'Database error during registration: ' . $e->getMessage());
                    session()->setFlashdata('error', 'Database error: Could not complete registration. Please try again.');
                    return redirect()->back()->withInput();
                } catch (Exception $e) {
                    log_message('error', 'Unexpected error during registration: ' . $e->getMessage());
                    session()->setFlashdata('error', 'An unexpected error occurred during registration. Please try again.');
                    return redirect()->back()->withInput();
                }
            }
        }
        log_message('debug', 'Displaying register form.');
        return view('register', $data);
    }

    /**
     * Logout for both admin and user.
     */
    public function logout()
    {
        log_message('debug', 'User attempting to log out. Session before destroy: ' . print_r($this->session->get(), true));
        $this->session->destroy();
        log_message('debug', 'Session destroyed. Redirecting to /login');
        return redirect()->to('/login')->with('success', 'You have been successfully logged out.');
    }
}