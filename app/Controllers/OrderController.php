<?php

namespace App\Controllers; // Resolved: Kept standard namespace declaration

use App\Models\OrderModel;
use App\Models\OrderItem; // Added this use statement as it was used in HEAD's conflict block

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
        $orderModel = new OrderModel(); // Initialize OrderModel here as it's used below

        // You would typically have more robust logic here
        if ($cart->totalItems() > 0 && $session->get('isLoggedIn')) {
            // Logic to save the order
            // ...

            // Clear the cart
            $cart->destroy();

            // Redirect with a success message
            return redirect()->to('/account/orders')->with('msg_success', 'Your order has been placed successfully!');
        }

        // --- Start Conflict Block HEAD ---
        // Assume this is a quick "Buy Now" feature
        // In a full implementation, this might involve creating a temporary cart item
        // or directly processing a single item order.

        // WARNING: Variables like $product, $quantity, $color, $size are not defined here.
        // This block needs context from the actual "Buy Now" form/action.
        // For strict conflict resolution, I'm just including it as is.
        // You MUST ensure $product, $quantity, $productId, $color, $size are available here.

        // Placeholder for user ID - for logged in users
        $userId = session()->get('user_id'); // Corrected session usage

        // Dummy values for undefined variables for the sake of the merge (REMOVE/REPLACE IN REAL CODE)
        $product = ['price' => 100, 'id' => 999, 'name' => 'Dummy Product'];
        $quantity = 1;
        $productId = $product['id'];
        $color = 'N/A';
        $size = 'N/A';
        // END Dummy values


        $totalAmount = $product['price'] * $quantity;
        $shippingCost = 0; // Or calculate based on product/location


        $orderData = [
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'subtotal_amount' => $totalAmount,
            'shipping_cost' => $shippingCost,
            'shipping_address' => 'N/A for quick buy, fill from user profile or ask', // This needs proper handling
            'shipping_name' => 'Guest Wishlist', // This needs proper handling
            'shipping_email' => 'guest@example.com', // This needs proper handling
            'shipping_phone' => 'N/A', // This needs proper handling
            'payment_method' => 'cod', // Default for quick buy, or prompt user
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Basic validation before saving the order (add more robust validation as needed)
        $validationRules = [
            'shipping_address' => 'required', // Assuming a basic address is needed
            'shipping_name' => 'required',
            'shipping_email' => 'required|valid_email',
            'shipping_phone' => 'required',
        ];

        // This would require capturing more user details in the form for a complete order
        // For now, we'll make some assumptions or skip strict validation if the form doesn't provide it.
        // It's better to redirect to a checkout page for full details.

        // For now, save with basic data, but note this is incomplete for a real system
        if ($orderId = $orderModel->insert($orderData)) { // Corrected $this->orderModel to $orderModel
            // Also save to order_items table for this order (assuming OrderItem model exists)
            // Ensure OrderItem model is properly initialized/loaded
            $orderItemModel = new OrderItem();
            $orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product['price'],
                'subtotal' => $totalAmount,
                'options' => json_encode(['color' => $color, 'size' => $size]), // Store options
            ]);

            session()->setFlashdata('success', 'Your order has been placed! Order ID: ' . $orderId); // Corrected session usage
            return redirect()->to(url_to('home')); // Redirect to a success page or home
        } else {
            session()->setFlashdata('error', 'Failed to place order.'); // Corrected session usage
            return redirect()->back()->withInput();
        }
        // --- End Conflict Block HEAD ---

        // --- Start Conflict Block REMOTE ---
        return redirect()->to('/checkout')->with('msg_error', 'There was a problem placing your order.');
        // --- End Conflict Block REMOTE ---
    }
}