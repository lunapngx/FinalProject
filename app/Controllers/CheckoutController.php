<?php

namespace App\Controllers;

class CheckoutController extends BaseController
{
    public function index()
    {
        $data['cart'] = \Config\Services::cart();

        if ($data['cart']->totalItems() == 0) {
            return redirect()->to('/cart')->with('msg_error', 'Your cart is empty.');
        }

        return view('Checkout/index', $data);
    }
}