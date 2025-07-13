<?php

namespace App\Controllers; // Make sure this namespace matches your project structure

class CategoryController extends BaseController
{
    /**
     * Loads the main categories page.
     * You can fetch categories from a model here if needed.
     */
    public function index()
    {
        // Example: If you have a CategoryModel and want to fetch data
        // $categoryModel = new \App\Models\CategoryModel();
        // $data['categories'] = $categoryModel->findAll();

        // This line tells CodeIgniter to load the view file: app/Views/categories/index.php
        return view('category/index' /*, $data*/); // Uncomment $data if you pass data
    }

    // You can add other methods here, e.g., to display products within a specific category
    // public function show($slug)
    // {
    //     // Logic to fetch a specific category and its products
    // }
}