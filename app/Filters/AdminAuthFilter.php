<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\RedirectResponse.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return ResponseInterface|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            // User is not logged in, redirect to login page
            session()->setFlashdata('error', 'Please log in to access this area.');
            return redirect()->to('/login?redirect=' . urlencode(current_url()));
        }

        // Check if the logged-in user has the 'admin' role
        if (session()->get('role') !== 'admin') {
            // User is logged in but not an admin, redirect to a forbidden page or home
            session()->setFlashdata('error', 'You do not have administrative privileges to access this area.');
            return redirect()->to('/account'); // Or any other appropriate page for non-admins
        }

        // If logged in and is admin, continue with the request
    }

    /**
     * We aren't doing anything here, so we'll just return the response
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after the request for this filter
    }
}
