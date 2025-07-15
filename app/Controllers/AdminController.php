<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    /**
     * Constructor.
     *
     * This method acts as a security check for all other methods in this controller.
     * It verifies that the user is logged in and has the 'admin' role.
     * If not, it redirects them to the login page.
     */
    public function __construct()
    {
        // Check session data set by AuthController during login
        if (session()->get('isLoggedIn') !== true || session()->get('role') !== 'admin') {
            // If the user is not an admin or not logged in, redirect to the login page.
            session()->setFlashdata('error', 'You do not have permission to access that page.');
            service('response')->redirect('/login')->send();
            exit; // Stop script execution
        }
    }

    /**
     * Displays the admin dashboard.
     *
     * This method gathers statistics from various models (Users, Products, Orders)
     * and passes them to the dashboard view.
     */
    public function dashboard()
    {
        // Instantiate your models
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $userModel = new UserModel();

        // Prepare an array of data to pass to the view
        $data = [
            'title'          => 'Admin Dashboard',
            'total_products' => $productModel->countAllResults(),
            'total_orders'   => $orderModel->countAllResults(),
            // It's good practice to count only non-admin users
            'total_users'    => $userModel->where('role', 'user')->countAllResults(),
        ];

        // Load the dashboard view and pass the data to it.
        // Assumes your view file is at app/Views/Admin/dashboard.php
        return view('Admin/dashboard', $data);
    }
}