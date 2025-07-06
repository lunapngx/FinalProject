<?php namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController // Ensure this extends BaseController if it exists, otherwise CodeIgniter\Controller
{
    public function index()
    {
        $productModel = new \App\Models\ProductModel(); // Use fully qualified name for clarity
        $data['products'] = $productModel->findAll(); // Fetches ALL products

        // Render the new product list view (index.php)
        return view('Product/index', $data + ['title' => 'Our Flowers']);
    }

    public function show(int $id)
    {
        $prodModel = new \App\Models\ProductModel(); // Use fully qualified name
        $product = $prodModel->find($id); // Fetches a single product

        if (!$product) {
            throw new PageNotFoundException('Product not found');
        }

        // Decode JSON arrays for the view (if stored as JSON strings)
        $product['colors'] = json_decode($product['colors'] ?? '[]', true);
        $product['sizes'] = json_decode($product['sizes'] ?? '[]', true);

        // Placeholder for reviews (if ReviewModel is not used or defined yet)
        // $revModel = new \App\Models\ReviewModel();
        // $reviews  = $revModel->where('product_id', $id)->findAll();

        // Render the renamed product detail view (show.php)
        return view('Product/show', [
            'product' => $product,
            'reviews' => [], // Pass actual reviews if available
            'title' => $product['name'],
        ]);
    }
}