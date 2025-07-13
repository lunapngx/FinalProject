<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();

        return view('Product/index', $data);
    }

    public function show($slug = null)
    {
        $productModel = new ProductModel();
        $data['product'] = $productModel->where('id', $slug)->first(); // Assuming slug is the ID for now

        if (empty($data['product'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the product: ' . $slug);
        }

        return view('Product/show', $data);
    }
}