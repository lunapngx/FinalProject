<?php

namespace App\Controllers;

use App\Models\OrderModel;

class OrderController extends BaseController
{
    /**
     * Displays the user's order history.
     */
    public function index()
    {
        $orderModel = new OrderModel();
        $userId = session()->get('user_id');

        $data['orders'] = $orderModel->where('user_id', $userId)->findAll();

        return view('Account/orders', $data);
    }

    /**
     * Handles the checkout process to place a new order.
     */
    public function placeOrder()
    {
        // This is a placeholder for your order placement logic
        // e.g., processing payment, saving order to database, clearing cart.

        $session = session();
        $cart = \Config\Services::cart();

        // You would typically have more robust logic here
        if ($cart->totalItems() > 0 && $session->get('isLoggedIn')) {
            // Logic to save the order
            // ...

            // Clear the cart
            $cart->destroy();

            // Redirect with a success message
            return redirect()->to('/account/orders')->with('msg_success', 'Your order has been placed successfully!');
        }

        return redirect()->to('/checkout')->with('msg_error', 'There was a problem placing your order.');
    }
}
