<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // If the user is not logged in OR if their role is not 'admin', redirect to admin login
        // This filter protects admin-only routes
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            // Assuming admins redirect to /admin/login (which now redirects to /login)
            return redirect()->to('/admin/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}