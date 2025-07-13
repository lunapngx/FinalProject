<?php

namespace App\Controllers;

use App\Models\ProductModel; // From remote
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException; // Assuming this might be useful for product lookups

class CartController extends Controller
{
    // Simulate cart items (replace with actual database integration later) - From HEAD
    private $cartItems = [];
    private $subtotal = 0;
    protected $productModel; // To use ProductModel

    public function __construct()
    {
        // Call parent constructor if Controller has one (it doesn't by default for CI4's Controller)
        // parent::__construct(); // No need for this in CI4's Controller

        // Initialize ProductModel
        $this->productModel = new ProductModel();

        // Load session helper
        helper(['url', 'session']); // For url_to() and session()

        // Initialize cart items from session or set defaults (from HEAD)
        // NOTE: This initial simulated data might override real cart data if not handled carefully
        $this->cartItems = session()->get('cartItems') ?? [
            (object)[
                'product' => [
                    'id' => 1,
                    'name' => 'Lorem ipsum dolor sit amet',
                    'image' => 'chair.png',
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
                    'image' => 'jacket.png',
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
                    'image' => 'polo.png',
                    'price' => 49.99,
                    'stock' => 20,
                ],
                'options' => ['color' => 'Blue', 'size' => 'S'],
                'quantity' => 1,
                'itemTotal' => 49.99,
            ],
        ];

        // Ensure real cart items from CodeIgniter's Cart service are reflected in $this->cartItems
        // This is a complex point of integration. For now, we'll try to sync.
        $ciCart = \Config\Services::cart();
        $ciCartItems = $ciCart->contents();

        // Simple sync: if CI cart has items, use them to populate $this->cartItems,
        // or ensure your $this->cartItems is built from the CI cart for consistency.
        // This might require a more robust sync logic depending on your actual cart needs.
        // For this merge, I'm prioritizing your existing $this->cartItems structure
        // but acknowledging the CI cart's presence.
        if (empty($this->cartItems) && !empty($ciCartItems)) {
            // If your custom cart is empty but CI cart has items, populate your custom cart from it.
            $this->cartItems = [];
            foreach ($ciCartItems as $ciItem) {
                $productData = $this->productModel->find($ciItem['id']);
                $this->cartItems[] = (object)[
                    'product' => $productData, // Assuming product data is needed
                    'options' => $ciItem['options'],
                    'quantity' => $ciItem['qty'],
                    'itemTotal' => $ciItem['subtotal'],
                ];
            }
            session()->set('cartItems', $this->cartItems);
        } elseif (!empty($this->cartItems) && empty($ciCartItems)) {
            // If your custom cart has items but CI cart is empty, populate CI cart from yours.
            foreach ($this->cartItems as $customItem) {
                $ciCart->insert([
                    'id'      => $customItem->product['id'],
                    'qty'     => $customItem->quantity,
                    'price'   => $customItem->product['price'],
                    'name'    => $customItem->product['name'],
                    'options' => $customItem->options
                ]);
            }
        }


        $this->calculateTotals(); // Call to calculate totals from HEAD
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
        // Merged index logic: provide both your custom cart items and the CI Cart service
        $data = [
            'cartItems' => $this->cartItems, // Your custom cart structure
            'total' => $this->subtotal, // Your custom subtotal
            'cart' => \Config\Services::cart(), // The CI Cart service instance
        ];
        // Corrected view path: It looks for app/Views/Cart/cart.php based on your file structure
        return view('Cart/cart', $data);
    }

    // New add method combining logic from remote and integrating with your custom cart
    public function add()
    {
        $cart = \Config\Services::cart();
        $productModel = new ProductModel(); // Re-instantiate if not already in constructor or property

        $productId = $this->request->getPost('id');
        $product = $productModel->find($productId);
        $quantity = (int)$this->request->getPost('qty') ?: 1; // Get quantity, default to 1

        if ($product) {
            // Add to CodeIgniter's Cart service
            $cart->insert([
                'id'      => $productId,
                'qty'     => $quantity,
                'price'   => $product['price'],
                'name'    => $product['name'],
                'options' => [], // Add any product options here if needed from request
            ]);

            // Now, sync with your custom $this->cartItems array
            // Check if product already exists in your custom cartItems array
            $found = false;
            foreach ($this->cartItems as &$item) {
                if ($item->product['id'] == $productId) {
                    $item->quantity += $quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                // If not found, add as a new item to your custom cartItems
                $this->cartItems[] = (object)[
                    'product' => $product, // Assuming $product contains all necessary details
                    'options' => [], // Match options if they exist in request
                    'quantity' => $quantity,
                    'itemTotal' => (float)$product['price'] * $quantity,
                ];
            }

            $this->calculateTotals(); // Recalculate your custom totals

            return redirect()->back()->with('msg_success', 'Product added to cart!');
        } else {
            return redirect()->back()->with('msg_error', 'Product not found!');
        }
    }


    // Your updateQuantity method from HEAD
    public function updateQuantity()
    {
        $session = session();
        $productId = $this->request->getPost('product_id');
        $newQuantity = (int)$this->request->getPost('quantity');

        $ciCart = \Config\Services::cart();
        $rowidToUpdate = null; // To find the rowid for CI Cart

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

                // Find the corresponding item in CI Cart to update it
                foreach ($ciCart->contents() as $ciItem) {
                    if ($ciItem['id'] == $productId) {
                        $rowidToUpdate = $ciItem['rowid'];
                        break;
                    }
                }
                if ($rowidToUpdate) {
                    $ciCart->update([
                        'rowid' => $rowidToUpdate,
                        'qty'   => $newQuantity,
                    ]);
                }

                $session->setFlashdata('success', 'Cart updated successfully!');
                break;
            }
        }

        $this->calculateTotals(); // Recalculate after updating an item
        return redirect()->to(url_to('cart_view'));
    }

    // Your removeItem method from HEAD
    public function removeItem()
    {
        $session = session();
        $productId = $this->request->getPost('product_id');

        $ciCart = \Config\Services::cart();
        $rowidToRemove = null;

        // Find the corresponding item in CI Cart and get its rowid
        foreach ($ciCart->contents() as $ciItem) {
            if ($ciItem['id'] == $productId) {
                $rowidToRemove = $ciItem['rowid'];
                break;
            }
        }

        if ($rowidToRemove) {
            $ciCart->remove($rowidToRemove); // Remove from CI Cart
        }

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

    // Remote's specific remove method (kept for completeness, though removeItem covers similar functionality)
    public function remove($rowid)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowid);

        // After removing from CI cart, you might want to re-sync your custom cartItems array.
        // A simple way is to re-initialize or rebuild $this->cartItems from $cart->contents()
        // For simplicity in this merge, I'm just leaving the direct CI cart removal.
        // If your custom cart is the primary source of truth, you'll need to rebuild $this->cartItems
        // based on the CI Cart's new state, and then call calculateTotals().

        return redirect()->to('/cart');
    }
}