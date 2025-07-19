<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\CategoryModel; // Added CategoryModel for dropdown in product forms

class AdminController extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $userModel;
    protected $categoryModel; // Added category model

    /**
     * Constructor.
     *
     * This method acts as a security check for all other methods in this controller.
     * It verifies that the user is logged in and has the 'admin' role.
     * If not, it redirects them to the login page.
     */
    public function __construct()
    {
        // Load helpers needed for forms and URLs
        helper(['form', 'url']);

        // Check session data set by AuthController during login
        if (session()->get('isLoggedIn') !== true || session()->get('role') !== 'admin') {
            // If the user is not an admin or not logged in, redirect to the login page.
            session()->setFlashdata('error', 'You do not have permission to access that page.');
            service('response')->redirect('/login')->send();
            exit; // Stop script execution
        }

        // Instantiate models
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->categoryModel = new CategoryModel(); // Initialize CategoryModel
    }

    /**
     * Displays the admin dashboard.
     *
     * This method gathers statistics from various models (Users, Products, Orders)
     * and passes them to the dashboard view.
     */
    public function dashboard()
    {
        $data = [
            'title'          => 'Admin Dashboard',
            'total_products' => $this->productModel->countAllResults(),
            'total_orders'   => $this->orderModel->countAllResults(),
            // It's good practice to count only non-admin users
            'total_users'    => $this->userModel->where('role', 'user')->countAllResults(),
        ];

        return view('Admin/dashboard', $data);
    }

    /**
     * Displays a list of all products for admin management.
     * Includes pagination.
     */
    public function products()
    {
        $products = $this->productModel->paginate(10); // Paginate 10 products per page
        $pager = $this->productModel->pager;

        $data = [
            'title'    => 'Manage Products',
            'products' => $products,
            'pager'    => $pager,
        ];

        return view('Admin/products', $data);
    }

    /**
     * Displays the form for adding a new product.
     */
    public function add_product()
    {
        $data = [
            'title'      => 'Add New Product',
            'categories' => $this->categoryModel->findAll(), // Fetch all categories for dropdown
            'validation' => service('validation'), // Pass validation service to the view
        ];
        return view('Admin/add_product', $data);
    }

    /**
     * Handles the submission of the add/edit product form.
     */
    public function saveProduct()
    {
        // Set validation rules for product data
        $rules = [
            'name'        => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[5000]',
            'price'       => 'required|numeric|greater_than[0]',
            'original_price' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[price]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'category_id' => 'required|integer',
            'product_image' => 'uploaded[product_image]|max_size[product_image,1024]|is_image[product_image]|mime_in[product_image,image/jpg,image/jpeg,image/png,image/gif]',
            'colors'      => 'permit_empty', // Will be manually processed as JSON
            'sizes'       => 'permit_empty',  // Will be manually processed as JSON
        ];

        // If editing, image is optional
        if ($this->request->getPost('id')) {
            $rules['product_image'] = 'permit_empty|max_size[product_image,1024]|is_image[product_image]|mime_in[product_image,image/jpg,image/jpeg,image/png,image/gif]';
        }

        // Validate the request data
        if (! $this->validate($rules)) {
            // If validation fails, redirect back with input and errors
            $id = $this->request->getPost('id');
            if ($id) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('product_id', $id);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare product data
        $productData = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'original_price' => $this->request->getPost('original_price') ?: null, // Use null if empty
            'stock'       => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'colors'      => json_encode(array_map('trim', explode(',', $this->request->getPost('colors')))), // Convert comma-separated string to JSON array
            'sizes'       => json_encode(array_map('trim', explode(',', $this->request->getPost('sizes')))),   // Convert comma-separated string to JSON array
        ];

        // Handle image upload
        $imageFile = $this->request->getFile('product_image');
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/products', $newName); // Move to public/uploads/products
            $productData['image'] = 'uploads/products/' . $newName; // Store relative path
        } else if ($this->request->getPost('id')) {
            // If editing and no new image, retain old image path
            $existingProduct = $this->productModel->find($this->request->getPost('id'));
            $productData['image'] = $existingProduct['image'];
        } else {
            // For new products, if no image is uploaded, set a default or handle as error.
            // For now, let's assume it's handled by validation 'uploaded' rule for new products.
            $productData['image'] = null; // Or a path to a default image
        }

        // Determine if it's an insert or update
        $id = $this->request->getPost('id');
        if ($id) {
            // Update existing product
            $this->productModel->update($id, $productData);
            session()->setFlashdata('success', 'Product updated successfully!');
        } else {
            // Insert new product
            $this->productModel->insert($productData);
            session()->setFlashdata('success', 'Product added successfully!');
        }

        return redirect()->to(url_to('admin_products'));
    }

    /**
     * Displays the form for editing an existing product.
     *
     * @param int $id The ID of the product to edit.
     */
    public function edit_product($id)
    {
        $product = $this->productModel->find($id);

        if (! $product) {
            session()->setFlashdata('error', 'Product not found.');
            return redirect()->to(url_to('admin_products'));
        }

        $data = [
            'title'      => 'Edit Product',
            'product'    => $product,
            'categories' => $this->categoryModel->findAll(),
            'validation' => service('validation'),
        ];
        return view('Admin/edit_product', $data);
    }

    /**
     * Deletes a product.
     *
     * @param int $id The ID of the product to delete.
     */
    public function delete_product($id)
    {
        $product = $this->productModel->find($id);

        if (! $product) {
            session()->setFlashdata('error', 'Product not found.');
            return redirect()->to(url_to('admin_products'));
        }

        // Optionally, delete the associated image file
        if ($product['image'] && file_exists(FCPATH . $product['image'])) {
            unlink(FCPATH . $product['image']);
        }

        $this->productModel->delete($id);
        session()->setFlashdata('success', 'Product deleted successfully!');
        return redirect()->to(url_to('admin_products'));
    }

    /**
     * Displays a list of all orders for admin management.
     */
    public function orders()
    {
        $orders = $this->orderModel->findAll(); // Fetch all orders
        $data = [
            'title'  => 'Manage Orders',
            'orders' => $orders,
        ];
        return view('Admin/orders', $data);
    }

    /**
     * Displays the admin account page.
     */
    public function adminaccount()
    {
        $data = [
            'title' => 'Admin Account Settings',
            // You might fetch admin user details here if needed
        ];
        return view('Admin/adminaccount', $data);
    }

    /**
     * Displays the sales report page.
     */
    public function sales_report()
    {
        $data = [
            'title' => 'Sales Report',
            // Logic to fetch sales data
        ];
        return view('Admin/sales_report', $data);
    }
}
