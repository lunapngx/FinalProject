<?php namespace App\Controllers\User;

use App\Models\ProductModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

// Using ProductModel

class ProductController extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll(); // Fetch all products
        return view('Product/product', $data + ['title' => 'Our Flowers']); // Corrected view path to Product/index
    }

    public function show(int $id)
    {
        $prodModel = new ProductModel();
        $product = $prodModel->find($id);

        if (!$product) {
            throw new PageNotFoundException('Product not found');
        }

        // decode JSON arrays for the view (if stored as JSON strings)
        // Ensure these keys exist in your database or are handled correctly
        $product['colors'] = json_decode($product['colors'] ?? '[]', true);
        $product['sizes'] = json_decode($product['sizes'] ?? '[]', true);

        // Assuming ReviewModel exists and is functional
        // $revModel = new ReviewModel(); // Make sure ReviewModel is properly defined if used
        // $reviews  = $revModel->where('product_id', $id)->findAll();

        return view('Product/show', [ // Corrected view path to Product/show
            'product' => $product, // Changed 'Product' to 'product' (lowercase) for consistency
            'reviews' => [], // Placeholder for reviews if ReviewModel is not used or defined yet
            'title' => $product['name'], // Set title dynamically
        ]);
    }
}