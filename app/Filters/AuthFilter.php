<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // If the user is not logged in OR if they are logged in but not a 'user' (e.g., admin), redirect to login
        // This filter protects user-only routes
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            // Assuming regular users redirect to /login
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}