<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // You can fetch featured products here later
        return view('Home/index', ['title' => 'Welcome']);
    }
    public function about()
    {
        $data = [
            'title' => 'About',
        ];

        return view('home/about', ['title' => 'About']);
    }
    public function categories()
    {
        $data = [
            'title' => 'CategoryModel',
        ];

        return view('Category/index', ['title' => 'CategoryModel']);
    }

}
