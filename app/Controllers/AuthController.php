<?php

namespace App\Controllers; // Make sure this namespace is correct

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface; // This should be RequestInterface, not IncomingRequest
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AuthController extends BaseController // Class name must match file name
{
    // ... (rest of the controller, ensure login method is public)

    public function login() // This method must be public
    {
        // ...
        return view('login');
    }

    // ...
}