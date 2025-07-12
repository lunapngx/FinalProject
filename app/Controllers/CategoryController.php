<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class CategoryController extends BaseController
{
    public function index($slug = null)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        if ($slug === null) {
            // If no slug, show all categories
            $data['categories'] = $categoryModel->findAll();
            return view('Category/index', $data);
        }

        // Find category by slug
        $category = $categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the category: ' . $slug);
        }

        $data['category'] = $category;
        $data['products'] = $productModel->where('category_id', $category['id'])->findAll();

        return view('Product/index', $data); // Re-using the product list view
    }
}