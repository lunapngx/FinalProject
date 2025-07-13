<?php

namespace App\Controllers;

use App\Models\CategoryModel; // From remote
use App\Models\ProductModel; // From remote

use CodeIgniter\Controller; // Assuming BaseController extends CodeIgniter\Controller

class CategoryController extends BaseController
{
    public function index($slug = null) // Adopt remote's signature to allow for slug
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        if ($slug === null) {
            // Logic from remote: If no slug, show all categories
            $data['categories'] = $categoryModel->findAll();
            // Your original view for index was 'category/index', remote was 'Category/index'
            // Let's standardize to 'Category/index' for consistency.
            return view('Category/index', $data);
        }

        // Logic from remote: Find category by slug and its products
        $category = $categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the category: ' . $slug);
        }

        $data['category'] = $category;
        $data['products'] = $productModel->where('category_id', $category['id'])->findAll();

        return view('Product/index', $data); // Remote's view for products in a category
    }

    // Your original comment block is kept.
    // You can add other methods here, e.g., to display products within a specific category
    // public function show($slug)
    // {
    //     // Logic to fetch a specific category and its products
    // }
}