<?php

namespace App\Controllers;

use App\Models\ProductModel;

class CartController extends BaseController
{
    public function index()
    {
        $cart = \Config\Services::cart();

        // Get all items currently in the cart
        $data['cartItems'] = $cart->contents();

        // Get the total price of all items in the cart
        $data['total'] = $cart->total();

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