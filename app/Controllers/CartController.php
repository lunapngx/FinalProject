<?php namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

// Don't forget to define/create this model

class CartController extends BaseController
{
    protected $productModel;
    protected $session;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->session = Services::session();
        helper(['form', 'url']);
    }

    public function index(): string
    {
        $cartItems = $this->session->get('cart') ?? []; // Get cart from session
        $fullCartItems = [];
        $total = 0;

        foreach ($cartItems as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $itemTotal = $product['price'] * $quantity;
                $fullCartItems[] = (object)[
                    'product' => $product,
                    'quantity' => $quantity,
                    'itemTotal' => $itemTotal,
                    // Assume options are stored in cart for now, or fetch from product if applicable
                    'options' => [], // Placeholder for product options if not stored in session
                ];
                $total += $itemTotal;
            }
        }

        $data = [
            'title' => 'Your Shopping Cart',
            'cartItems' => $fullCartItems,
            'total' => $total,
        ];

        return view('Cart/index', $data); // THIS IS THE LINE THAT RENDERS THE VIEW
    }

    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if ($productId <= 0 || $quantity <= 0) {
            $this->session->setFlashdata('error', 'Invalid product or quantity.');
            return redirect()->back();
        }

        $product = $this->productModel->find($productId);

        if (!$product) {
            throw new PageNotFoundException('Product not found.');
        }

        // Get current cart from session
        $cart = $this->session->get('cart') ?? [];

        // Add or update product in cart
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        $this->session->set('cart', $cart);
        $this->session->setFlashdata('success', 'Product added to cart successfully!');

        return redirect()->to(url_to('cart_view'));
    }

    public function update()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if ($productId <= 0 || $quantity < 0) {
            $this->session->setFlashdata('error', 'Invalid product or quantity.');
            return redirect()->back();
        }

        $cart = $this->session->get('cart') ?? [];

        if ($quantity === 0) {
            // Remove item if quantity is 0
            unset($cart[$productId]);
            $this->session->setFlashdata('info', 'Product removed from cart.');
        } elseif (isset($cart[$productId])) {
            // Update quantity
            $product = $this->productModel->find($productId);
            if ($product && $quantity <= ($product['stock'] ?? 99)) { // Check against stock if available
                $cart[$productId] = $quantity;
                $this->session->setFlashdata('success', 'Cart updated successfully!');
            } else {
                $this->session->setFlashdata('error', 'Requested quantity exceeds available stock.');
            }
        }

        $this->session->set('cart', $cart);

        return redirect()->to(url_to('cart_view'));
    }

    public function remove()
    {
        $productId = $this->request->getPost('product_id');

        if ($productId <= 0) {
            $this->session->setFlashdata('error', 'Invalid product.');
            return redirect()->back();
        }

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->session->set('cart', $cart);
            $this->session->setFlashdata('info', 'Product removed from cart.');
        }

        return redirect()->to(url_to('cart_view'));
    }
}
