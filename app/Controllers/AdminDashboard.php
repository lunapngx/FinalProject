<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;   // <-- ADD THIS LINE
use App\Models\UserModel;

class AdminDashboard extends BaseController
{
    public function __construct()
    {
        if (!session()->get('admin_logged_in')) {
            service('response')->redirect('/admin/login')->send();
            exit();
        }
    }

    public function index()
    {
        $orderModel = new OrderModel();

        $data = [
            'total_products' => (new ProductModel())->countAllResults(), // Now uses the aliased class
            'total_orders' => (new OrderModel())->countAllResults(), // Now uses the aliased class
            'total_users' => (new UserModel())->countAllResults(),   // Now uses the aliased class
        ];
        return view('Admin/dashboard', $data);
    }
}