<?php

namespace App\Controllers;

use App\Models\ProductModel;

class CartController extends BaseController
{
    public function index()
    {
        $data['cart'] = \Config\Services::cart();
        return view('Cart/cart', $data);
    }

    public function add()
    {
        $cart = \Config\Services::cart();
        $productModel = new ProductModel();

        $product = $productModel->find($this->request->getPost('id'));

        if ($product) {
            $cart->insert([
                'id'      => $this->request->getPost('id'),
                'qty'     => 1,
                'price'   => $product['price'],
                'name'    => $product['name'],
                'options' => []
            ]);
        }

        return redirect()->back()->with('msg_success', 'Product added to cart!');
    }

    public function remove($rowid)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowid);

        return redirect()->to('/cart');
    }
}
