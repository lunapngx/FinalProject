<?php namespace App\Controllers; // Changed from App\Controllers\wishlist
// Changed namespace

use App\Controllers\BaseController;
use App\Models\Order; // Assuming App\Models\Order exists
use App\Models\OrderItem; // Assuming App\Models\OrderItem exists
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

// Using the more complete Order model

// Added BaseController import

// Added for exception handling

class OrderController extends BaseController // Extends BaseController
{
    protected $orderModel;
    protected $productModel;
    protected $session; // Added session property

    public function __construct()
    {
        $this->orderModel = new Order(); // Using the Order model
        $this->productModel = new ProductModel(); // Using ProductModel
        $this->session = Services::session(); // Initialize session
        helper(['form', 'url']);
    }

    public function place()
    {
        $productId = (int)$this->request->getPost('product_id');
        $color = $this->request->getPost('color');
        $size = $this->request->getPost('size');
        $quantity = (int)$this->request->getPost('quantity') ?: 1; // Default to 1 if not provided

        $product = $this->productModel->find($productId);
        if (!$product) {
            throw new PageNotFoundException('Product not found.');
        }

        // Assume this is a quick "Buy Now" feature
        // In a full implementation, this might involve creating a temporary cart item
        // or directly processing a single item order.
        $totalAmount = $product['price'] * $quantity;
        $shippingCost = 0; // Or calculate based on product/location

        // Placeholder for user ID - for logged in users
        $userId = $this->session->get('user_id');

        $orderData = [
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'subtotal_amount' => $totalAmount,
            'shipping_cost' => $shippingCost,
            'shipping_address' => 'N/A for quick buy, fill from user profile or ask', // This needs proper handling
            'shipping_name' => 'Guest wishlist', // This needs proper handling
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
        if ($orderId = $this->orderModel->insert($orderData)) {
            // Also save to order_items table for this order (assuming OrderItem model exists)
            $orderItemModel = new OrderItem();
            $orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product['price'],
                'subtotal' => $totalAmount,
                'options' => json_encode(['color' => $color, 'size' => $size]), // Store options
            ]);

            $this->session->setFlashdata('success', 'Your order has been placed! Order ID: ' . $orderId);
            return redirect()->to(url_to('home')); // Redirect to a success page or home
        } else {
            $this->session->setFlashdata('error', 'Failed to place order.');
            return redirect()->back()->withInput();
        }
    }
}