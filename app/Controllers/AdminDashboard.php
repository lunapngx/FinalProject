<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\UserModel; // Assuming you have UserModel for customers
use App\Models\ProductModel; // Assuming you have ProductModel for products
use App\Models\AdminModel; // New AdminModel
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminDashboard extends BaseController
{
    protected $orderModel;
    protected $userModel;
    protected $productModel;
    protected $adminModel;
    protected $session;

    public function __construct()
    {
        $this->orderModel   = new Order();
        $this->userModel    = new UserModel();
        $this->productModel = new ProductModel();
        $this->adminModel   = new AdminModel(); // Initialize AdminModel
        $this->session      = \Config\Services::session();
    }

    public function index()
    {
        // Fetching Data for Dashboard Cards
        $totalSales     = $this->orderModel->selectSum('total_amount')->first()['total_amount'] ?? 0;
        // For weekly orders, you would query orders from the last 7 days. This is a placeholder.
        $weeklyOrders   = $this->orderModel->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))->countAllResults();
        $customersCount = $this->userModel->countAllResults();
        $productsCount  = $this->productModel->countAllResults();

        $data = [
            'title'        => 'Admin Dashboard',
            'totalSales'   => $totalSales,
            'weeklyOrders' => $weeklyOrders,
            'customersCount' => $customersCount,
            'productsCount'  => $productsCount,
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
                $this->session->setFlashdata('success', 'Product added successfully.');
                return redirect()->to('/admin/products');
            } else {
                $data['validation'] = $this->validator;
                $this->session->setFlashdata('error', 'Product addition failed.');
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
                $this->session->setFlashdata('success', 'Product updated successfully.');
                return redirect()->to('/admin/products');
            } else {
                $data['validation'] = $this->validator;
                $this->session->setFlashdata('error', 'Product update failed.');
            }
        }
        return view('Admin/edit_product', $data);
    }

    public function deleteProduct($id = null)
    {
        if ($id === null) {
            $this->session->setFlashdata('error', 'Invalid product ID.');
            return redirect()->to('/admin/products');
        }

        $this->productModel->delete($id);
        $this->session->setFlashdata('success', 'Product deleted successfully.');
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
        $data['username'] = $this->session->get('admin_username') ?? 'Admin User';
        return view('Admin/account', $data);
    }
}