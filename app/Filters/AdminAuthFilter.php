<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    /**
     * This method is called before a controller is executed.
     * It checks if the 'admin_logged_in' session variable exists.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // If the admin is not logged in...
        if (! session()->get('admin_logged_in')) {
            // ...redirect them to the admin login page.
            return redirect()->to('/admin/login');
        }
    }

    /**
     * This method is called after a controller is executed.
     * We don't need to do anything here for this filter.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the controller runs.
    }
}
