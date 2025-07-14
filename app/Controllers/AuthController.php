<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\RequestInterface;  // Crucial: Ensures compatibility with BaseController's initController
use CodeIgniter\HTTP\ResponseInterface; // Crucial: Ensures compatibility with BaseController's initController
use Psr\Log\LoggerInterface;            // Crucial: Ensures compatibility with BaseController's initController
use Exception;                          // General exception for broader error handling

class AuthController extends BaseController
{
    /**
     * @var \CodeIgniter\Session\Session
     * The session instance for managing user sessions.
     */
    protected $session;

    /**
     * Initializes the controller with the request, response, and logger.
     * This method is called before any action methods in the controller.
     * It ensures that the controller's environment is properly set up,
     * including inheriting the parent's initialization and setting up the session.
     *
     * @param RequestInterface  $request  The incoming HTTP request object.
     * @param ResponseInterface $response The outgoing HTTP response object.
     * @param LoggerInterface   $logger   The logger instance for logging messages.
     * @return void
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        // Call the parent's initController method. This is essential
        // for CodeIgniter's core functionalities (like services, etc.)
        // to be properly initialized for this controller.
        parent::initController($request, $response, $logger);

        // Get the CodeIgniter session service. This makes the session
        // available via `$this->session` throughout the controller.
        $this->session = \Config\Services::session();
        log_message('debug', 'AuthController initController called. Session service initialized.');
    }

    /**
     * @var array
     * An array of helper files to be loaded automatically for this controller.
     * 'form' for form-related functions, 'url' for URL functions, and 'auth' for custom auth helpers.
     */
    protected $helpers = ['form', 'url', 'auth'];

    /**
     * Displays the login form or handles login submission.
     *
     * If a user is already logged in, they are redirected to their
     * respective dashboard (admin) or account page (regular user).
     *
     * @param $user
     * @return \CodeIgniter\HTTP\RedirectResponse|string A redirect response if already logged in or on successful login,
     * otherwise, the login view string.
     */
    // In app/Controllers/AuthController.php

    // app/Controllers/AuthController.php at line 66
    public function login() // No arguments expected here
    {
        helper(['form', 'url']); // Load form and URL helpers if not already loaded

        // If the request is a POST, attempt to authenticate
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required',
            ];

            $errors = [
                'email' => [
                    'required'    => 'Email is required.',
                    'valid_email' => 'Please enter a valid email address.',
                ],
                'password' => [
                    'required' => 'Password is required.',
                ],
            ];

            if ($this->validate([
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[8]|max_length[255]',
            ])) {
                // ... login logic
            } else {
                $data['validation'] = $this->validator;
                return view('login', $data);
            }

            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel(); // Instantiate your UserModel
            $user      = $userModel->where('email', $email)->first(); // Find user by email

            if ($user) {
                // User found, now verify password
                if (password_verify($password, $user['password_hash'])) {
                    // Password matches, check if user is verified (if you implemented this step)
                    if (isset($user['is_verified']) && !$user['is_verified']) {
                        return redirect()->back()->withInput()->with('error', 'Please verify your email address before logging in.');
                    }

                    // In AuthController.php's login() method after successful password_verify
                    $ses_data = [
                        'id'        => $user['id'],
                        'fullname'  => $user['fullname'],
                        'username'  => $user['username'],
                        'email'     => $user['email'],
                        'role'      => $user['role'],
                        'isLoggedIn' => TRUE, // This is crucial
                    ];
                    $this->session->set($ses_data);

                    // Redirect based on role or to a default dashboard
                    if ($user['role'] === 'admin') {
                        return view('Admin/login');
                    } else {
                        return view('login');
                    }

                } else {
                    // Invalid password
                    session()->setFlashdata('error', 'Invalid Email or Password.');
                    return redirect()->back()->withInput();
                }
            } else {
                // User not found
                session()->setFlashdata('error', 'Invalid Email or Password.');
                return redirect()->back()->withInput();
            }
        }

        // If it's a GET request, just show the login form
        return redirect()->to('/login');
    }

    /**
     * Displays the registration form or handles registration submission.
     *
     * If a user is already logged in, they are redirected to their
     * respective dashboard (admin) or account page (regular user).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string A redirect response if already logged in or on successful registration,
     * otherwise, the registration view string.
     */
    public function register()
    {
        log_message('debug', 'Register method accessed.');

        // Check if the user is already logged in.
        if (session()->get('isLoggedIn')) {
            log_message('debug', 'User already logged in, redirecting from register page.');
            // If logged in as admin, redirect to admin dashboard.
            if (session()->get('role') === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            // Otherwise, redirect to the default account page.
            return redirect()->to('/account');
        }

        $data = [];
        // Process the registration form submission if the request method is POST.
        if ($this->request->getMethod() === 'post') {
            log_message('debug', 'Registration form submitted (POST request detected).');
            // Define validation rules for the registration form fields.
            $rules = [
                'fullname'         => 'required|min_length[3]|max_length[255]',
                'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]', // Ensure username is unique
                'email'            => 'required|valid_email|is_unique[users.email]',                     // Ensure email is unique and valid
                'password'         => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]' // Confirm password matches
            ];

            // Validate the submitted data against the defined rules.
            if (!$this->validate($rules)) {
                // If validation fails, pass the validator instance to the view to display errors.
                log_message('debug', 'Registration validation FAILED. Errors: ' . json_encode($this->validator->getErrors()));
                $data['validation'] = $this->validator;
            } else {
                log_message('debug', 'Registration validation PASSED. Attempting to save user to database.');
                $userModel = new UserModel();
                log_message('debug', 'UserModel instance created for registration.');

                try {
                    // Attempt to save the new user data to the database.
                    $userData = [
                        'fullname'      => $this->request->getPost('fullname'),
                        'username'      => $this->request->getPost('username'),
                        'email'         => $this->request->getPost('email'),
                        'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash the password
                        'role'          => 'user', // Assign 'user' as the default role for new registrations
                        'is_verified'   => 0,      // New users are not verified initially (if email verification is used)
                        'status'        => 'active', // Set user status to 'active'
                    ];
                    log_message('debug', 'User data prepared for saving: ' . json_encode($userData));

                    $userModel->save($userData);
                    log_message('debug', 'User data saved successfully to database via UserModel.');

                    // Set a success flash message and redirect to the login page.
                    session()->setFlashdata('success', 'Registration successful! Please log in.');
                    log_message('debug', 'Redirecting to /login after successful registration.');
                    return redirect()->to('/login');
                } catch (DatabaseException $e) {
                    // Catch and log database-specific errors during registration.
                    log_message('error', 'DatabaseException during registration: ' . $e->getMessage());
                    session()->setFlashdata('error', 'Database error: Could not complete registration. Please try again.');
                    return redirect()->back()->withInput();
                } catch (Exception $e) {
                    // Catch and log any other unexpected errors during registration.
                    log_message('error', 'Generic Exception during registration: ' . $e->getMessage());
                    session()->setFlashdata('error', 'An unexpected error occurred during registration. Please try again.');
                    return redirect()->back()->withInput();
                }
            }
        }
        // If not a POST request or validation fails, display the registration form.
        log_message('debug', 'Displaying registration form (GET request or validation failed).');
        return view('register', $data);
    }

    /**
     * Handles user logout.
     *
     * Destroys the current user session and redirects the user to the login page
     * with a success message.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse A redirect response to the login page.
     */
    public function logout()
    {
        log_message('debug', 'Logout method accessed. Attempting to destroy session.');
        // Destroy the current session, effectively logging out the user.
        session()->destroy();
        // Redirect to the login page with a success message.
        log_message('debug', 'Session destroyed. Redirecting to /login.');
        return redirect()->to('/login')->with('success', 'You have been successfully logged out.');
    }
    // In app/Controllers/AuthController.php

    public function verifyEmail($hash)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('verification_hash', $hash)->first();

        if ($user) {
            $userModel->update($user['id'], [
                'is_verified' => true,
                'verification_hash' => null, // Clear the hash after verification
            ]);
            return redirect()->to('/login')->with('success', 'Email successfully verified! You can now log in.');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid or expired verification link.');
        }
    }
}
