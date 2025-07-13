<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        // Fetch some products to display on the homepage
        $data['products'] = $productModel->limit(8)->find();

        return view('Home/index', $data);
    }

    public function about()
    {
        return view('Home/about');
    }
}
