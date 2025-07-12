<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Added for clarity, assuming it's used if not already

class AdminDashboard extends BaseController
{
    // Property to hold ProductModel instance, assuming it's used in BaseController or should be initialized here
    protected $productModel;
    protected $orderModel; // Assuming OrderModel is also used

    public function __construct()
    {
        // Ensure parent constructor is called if BaseController has one
        parent::__construct();

        // Initialize models
        $this->productModel = new \App\Models\ProductModel();
        $this->orderModel = new \App\Models\OrderModel();

        // This authorization logic should ideally use Shield's filters on routes,
        // but keeping it as is based on your provided code for non-removal of features.
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

    public function products()
    {
        $data['title']    = 'Manage Products';
        $data['products'] = $this->productModel->findAll();
        return view('Admin/products', $data);
    }

    public function addProduct()
    {
        $data['title'] = 'Add New Product';
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'        => 'required|min_length[3]|max_length[255]',
                'price'       => 'required|numeric|greater_than[0]',
                'description' => 'permit_empty',
                'stock'       => 'required|integer|greater_than_equal_to[0]',
            ];

            if ($this->validate($rules)) {
                $this->productModel->save([
                    'name'        => $this->request->getPost('name'),
                    'price'       => $this->request->getPost('price'),
                    'description' => $this->request->getPost('description'),
                    'stock'       => $this->request->getPost('stock'),
                ]);
                session()->setFlashdata('success', 'Product added successfully.'); // Corrected session usage
                return redirect()->to('/admin/products');
            } else {
                $data['validation'] = $this->validator;
                session()->setFlashdata('error', 'Product addition failed.'); // Corrected session usage
            }
        }
        return view('Admin/add_product', $data);
    }

    public function editProduct($id = null)
    {
        $data['title']   = 'Edit Product';
        $product = $this->productModel->find($id);

        if (!$product) {
            throw new PageNotFoundException('Product not found.');
        }
        $data['product'] = $product;

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'        => 'required|min_length[3]|max_length[255]',
                'price'       => 'required|numeric|greater_than[0]',
                'description' => 'permit_empty',
                'stock'       => 'required|integer|greater_than_equal_to[0]',
            ];

            if ($this->validate($rules)) {
                $this->productModel->update($id, [
                    'name'        => $this->request->getPost('name'),
                    'price'       => $this->request->getPost('price'),
                    'description' => $this->request->getPost('description'),
                    'stock'       => $this->request->getPost('stock'),
                ]);
                session()->setFlashdata('success', 'Product updated successfully.'); // Corrected session usage
                return redirect()->to('/admin/products');
            } else {
                $data['validation'] = $this->validator;
                session()->setFlashdata('error', 'Product update failed.'); // Corrected session usage
            }
        }
        return view('Admin/edit_product', $data);
    }

    public function deleteProduct($id = null)
    {
        if ($id === null) {
            session()->setFlashdata('error', 'Invalid product ID.'); // Corrected session usage
            return redirect()->to('/admin/products');
        }

        $this->productModel->delete($id);
        session()->setFlashdata('success', 'Product deleted successfully.'); // Corrected session usage
        return redirect()->to('/admin/products');
    }

    public function orders()
    {
        $data['title']  = 'Manage Orders';
        $data['orders'] = $this->orderModel->getOrdersWithUserProduct();
        return view('Admin/orders', $data);
    }

    public function salesReport()
    {
        $data['title']  = 'Sales Report';
        $data['report'] = $this->orderModel->getSalesReport();
        return view('Admin/sales_report', $data);
    }

    public function account()
    {
        $data['title']    = 'Admin Account';
        // This assumes admin username is stored in session upon login.
        // If using Shield, you'd fetch user details via auth()->user()
        $data['username'] = session()->get('admin_username') ?? 'Admin Wishlist'; // Corrected session usage and capitalization
        return view('Admin/account', $data);
    }
}