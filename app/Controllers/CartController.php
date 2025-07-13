<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CartController extends Controller
{
    // Simulate cart items (replace with actual database integration later)
    private $cartItems = [];
    private $subtotal = 0;

    public function __construct()
    {
        // Load session library
        helper('url'); // For url_to() function
        $session = session();

        // Initialize cart items from session or set defaults
        $this->cartItems = $session->get('cartItems') ?? [
            (object)[
                'product' => [
                    'id' => 1,
                    'name' => 'Lorem ipsum dolor sit amet',
                    'image' => 'chair.png', // Make sure this image exists in public/assets/img/
                    'price' => 89.99,
                    'stock' => 10,
                ],
                'options' => ['color' => 'Black', 'size' => 'M'],
                'quantity' => 1,
                'itemTotal' => 89.99,
            ],
            (object)[
                'product' => [
                    'id' => 2,
                    'name' => 'Consectetur adipiscing elit',
                    'image' => 'jacket.png', // Make sure this image exists in public/assets/img/
                    'price' => 64.99,
                    'stock' => 5,
                ],
                'options' => ['color' => 'White', 'size' => 'L'],
                'quantity' => 2,
                'itemTotal' => 129.98, // 64.99 * 2
            ],
            (object)[
                'product' => [
                    'id' => 3,
                    'name' => 'Sed do eiusmod tempor',
                    'image' => 'polo.png', // Make sure this image exists in public/assets/img/
                    'price' => 49.99,
                    'stock' => 20,
                ],
                'options' => ['color' => 'Blue', 'size' => 'S'],
                'quantity' => 1,
                'itemTotal' => 49.99,
            ],
        ];

        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        $this->subtotal = 0;
        foreach ($this->cartItems as &$item) { // Use & to modify original item in array
            // Ensure product price is a float
            $price = (float)$item->product['price'];
            // Ensure quantity is an integer
            $quantity = (int)$item->quantity;
            $item->itemTotal = $price * $quantity;
            $this->subtotal += $item->itemTotal;
        }
        session()->set('cartItems', $this->cartItems);
        session()->set('subtotal', $this->subtotal);
    }

    public function index()
    {
        $data = [
            'cartItems' => $this->cartItems,
            'total' => $this->subtotal, // This is the subtotal before shipping/tax
        ];
        // Corrected view path: It looks for app/Views/Cart/cart.php based on your file structure
        return view('Cart/cart', $data); // IMPORTANT: Changed 'cart/index' to 'Cart/cart'
    }

    public function updateQuantity()
    {
        $session = session();
        $productId = $this->request->getPost('product_id');
        $newQuantity = (int)$this->request->getPost('quantity');

        foreach ($this->cartItems as &$item) {
            if ($item->product['id'] == $productId) {
                // Validate quantity
                $maxStock = $item->product['stock'] ?? 99; // Assume 99 if stock isn't defined
                if ($newQuantity > $maxStock) {
                    $newQuantity = $maxStock;
                    $session->setFlashdata('info', 'Quantity adjusted to maximum available stock.');
                }
                if ($newQuantity < 1) {
                    $newQuantity = 1;
                    $session->setFlashdata('info', 'Quantity cannot be less than 1. Adjusted to 1.');
                }

                $item->quantity = $newQuantity;
                $item->itemTotal = (float)$item->product['price'] * $item->quantity;
                $session->setFlashdata('success', 'Cart updated successfully!');
                break;
            }
        }

        $this->calculateTotals(); // Recalculate after updating an item
        return redirect()->to(url_to('cart_view'));
    }

    public function removeItem()
    {
        $session = session();
        $productId = $this->request->getPost('product_id');

        $initialCount = count($this->cartItems);
        $this->cartItems = array_filter($this->cartItems, function ($item) use ($productId) {
            return $item->product['id'] != $productId;
        });

        if (count($this->cartItems) < $initialCount) {
            $session->setFlashdata('success', 'Product removed from cart.');
        } else {
            $session->setFlashdata('error', 'Product not found in cart.');
        }

        $this->calculateTotals(); // Recalculate after removing an item
        return redirect()->to(url_to('cart_view'));
    }
}