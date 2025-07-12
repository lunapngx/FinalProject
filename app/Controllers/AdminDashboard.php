<?php

namespace App\Controllers;

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
        // You can load dashboard data here, e.g., stats
        $data = [
            'total_products' => (new \App\Models\ProductModel())->countAllResults(),
            'total_orders' => (new \App\Models\OrderModel())->countAllResults(),
            'total_users' => (new \App\Models\UserModel())->countAllResults(),
        ];
        return view('Admin/dashboard', $data);
    }
}
