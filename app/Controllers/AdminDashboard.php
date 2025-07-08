<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Order;     // Assuming you have Order model for sales/orders
use App\Models\UserModel; // Assuming you have UserModel for customers
use App\Models\ProductModel; // Assuming you have ProductModel for products

class AdminDashboard extends BaseController
{
    public function index()
    {
        // --- Fetching Data for Dashboard Cards ---
        // Replace these placeholder values with actual database queries.
        // You'll need to implement logic to count/sum from your models.

        // Example: Total Sales (sum of total_amount from orders)
        // $orderModel = new Order();
        // $totalSales = $orderModel->selectSum('total_amount')->first()['total_amount'] ?? 0;
        $totalSales = 50000.00; // Placeholder value from image

        // Example: Weekly Orders (count of orders from the last 7 days)
        // $weeklyOrders = $orderModel->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))->countAllResults();
        $weeklyOrders = 143; // Placeholder value from image

        // Example: Customers Count
        // $userModel = new UserModel();
        // $customersCount = $userModel->countAllResults();
        $customersCount = 143; // Placeholder value from image

        // Example: Products Count
        // $productModel = new ProductModel();
        // $productsCount = $productModel->countAllResults();
        $productsCount = 156; // Placeholder value from image

        // Data for the dashboard images (adjust paths to your actual images)
        $dashboardImages = [
            'public/assets/img/dashboard/admin_image_1.jpg',
            'public/assets/img/dashboard/admin_image_2.jpg'
        ];

        $data = [
            'title' => 'Admin Dashboard',
            'totalSales' => $totalSales,
            'weeklyOrders' => $weeklyOrders,
            'customersCount' => $customersCount,
            'productsCount' => $productsCount,
            'dashboardImages' => $dashboardImages, // Pass image paths
        ];

        return view('Admin/dashboard', $data);
    }
}