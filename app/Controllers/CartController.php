<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class CartController extends BaseController
{
    protected $session;
    protected $productModel;

    public function __construct()
    {
        $this->session = Services::session();
        $this->productModel = new ProductModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $cartItems = $this->session->get('cart') ?? [];
        $fullCartItems = [];
        $total = 0;

        foreach ($cartItems as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $itemTotal = $product['price'] * $quantity;

                // Handle JSON-decoded options
                $options = [];

                if (!empty($product['colors'])) {
                    $colors = json_decode($product['colors'], true);
                    if (is_array($colors) && count($colors) > 0) {
                        $options['color'] = $colors[0]; // Default or first value
                    }
                }

                if (!empty($product['sizes'])) {
                    $sizes = json_decode($product['sizes'], true);
                    if (is_array($sizes) && count($sizes) > 0) {
                        $options['size'] = $sizes[0]; // Default or first value
                    }
                }

                $fullCartItems[] = (object)[
                    'product' => $product,
                    'quantity' => $quantity,
                    'itemTotal' => $itemTotal,
                    'options' => $options,
                ];
                $total += $itemTotal;
            }
        }

        $data = [
            'title' => 'Your Cart',
            'cartItems' => $fullCartItems,
            'total' => $total,
        ];

        return view('Cart/cart', $data); // View file you posted
    }

    public function add()
    {
        $productId = (int) $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');

        if ($productId <= 0 || $quantity <= 0) {
            return redirect()->back()->with('error', 'Invalid product or quantity.');
        }

        $product = $this->productModel->find($productId);

        if (!$product) {
            throw new PageNotFoundException('Product not found.');
        }

        $cart = $this->session->get('cart') ?? [];

        // Update or add
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;

        $this->session->set('cart', $cart);
        return redirect()->to(route_to('cart_view'))->with('success', 'Product added to cart!');
    }

    public function update()
    {
        $productId = (int) $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');

        $cart = $this->session->get('cart') ?? [];

        if ($productId <= 0 || $quantity < 0) {
            return redirect()->back()->with('error', 'Invalid quantity or product.');
        }

        if ($quantity === 0) {
            unset($cart[$productId]);
            $this->session->setFlashdata('info', 'Item removed from cart.');
        } else {
            $product = $this->productModel->find($productId);
            if ($product && $quantity <= ($product['stock'] ?? 99)) {
                $cart[$productId] = $quantity;
                $this->session->setFlashdata('success', 'Cart updated!');
            } else {
                return redirect()->back()->with('error', 'Quantity exceeds stock.');
            }
        }

        $this->session->set('cart', $cart);
        return redirect()->to(route_to('cart_view'));
    }

    public function remove()
    {
        $productId = (int) $this->request->getPost('product_id');
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->session->set('cart', $cart);
            return redirect()->to(route_to('cart_view'))->with('info', 'Product removed.');
        }

        return redirect()->back()->with('error', 'Product not found in cart.');
    }
}
