<?php namespace App\Controllers; // Changed from App\Controllers\User

use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Controller; // Should be BaseController if extending it directly
use CodeIgniter\Exceptions\PageNotFoundException;

// Changed to CategoryModel

class CategoryController extends BaseController // Assuming you want to extend BaseController
{
    public function view(string $slug)
    {
        $catModel = new CategoryModel();
        $category = $catModel->where('slug', $slug)->first();

        if (!$category) {
            throw new PageNotFoundException('Category not found: ' . $slug);
        }

        $prodModel = new ProductModel();
        $products  = $prodModel->where('category_id', $category['id'])->findAll();

        return view('Category/index', [ // Assumed this view should be used for categories listing by slug
            'category' => $category, // Changed 'Category' to 'category' (lowercase) for consistency
            'products' => $products,
            'title' => $category['name'], // Set title dynamically
        ]);
    }
}