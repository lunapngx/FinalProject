<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\AdminModel;
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
        helper(['form', 'url']);
    }

    public function index()
    {
        $totalSales     = $this->orderModel->selectSum('total_amount')->first()['total_amount'] ?? 0;
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
            }
        }
        return view('Admin/add_product', $data);
    }

    public function editProduct($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/products')->with('error', 'Invalid product ID.');
        }

        $product = $this->productModel->find($id);
        if (!$product) {
            throw new PageNotFoundException('Product not found for ID: ' . $id);
        }

        $data = [
            'title'   => 'Edit Product',
            'product' => $product,
        ];

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
                return redirect()->to('/admin/products')->with('success', 'Product updated successfully.');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('Admin/edit_product', $data);
    }


    public function deleteProduct($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/products')->with('error', 'Invalid product ID.');
        }

        if ($this->productModel->delete($id)) {
            return redirect()->to('/admin/products')->with('success', 'Product deleted successfully.');
        } else {
            return redirect()->to('/admin/products')->with('error', 'Failed to delete product.');
        }
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
        $adminId = $this->session->get('user_id');

        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'You must be logged in to view this page.');
        }
        $admin = $this->adminModel->find($adminId);

        if (!$admin) {
            return redirect()->to('/admin/dashboard')->with('error', 'Admin user not found.');
        }
        $data = [
            'title' => 'Admin Account',
            'admin' => $admin,
        ];

        return view('Admin/adminaccount', $data);
    }

}