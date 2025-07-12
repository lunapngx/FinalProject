<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use Config\Services;

class WishlistController extends BaseController
{
    protected $session;
    protected $productModel;

    public function __construct()
    {
        $this->session = Services::session();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $wishlist = $this->session->get('wishlist') ?? []; // array of product_ids
        $items = [];
        $total = 0;

        foreach ($wishlist as $id => $qty) {
            $product = $this->productModel->find($id);
            if ($product) {
                $itemTotal = $product['price'] * $qty;
                $items[] = (object)[
                    'product' => $product,
                    'quantity' => $qty,
                    'itemTotal' => $itemTotal,
                ];
                $total += $itemTotal;
            }
        }

        $data = [
            'wishlistItems' => $items,
            'subtotal' => $total
        ];

        return view('Customer/wishlist', $data); // Point this to your actual wishlist view file
    }

    public function add()
    {
        $productId = (int)$this->request->getPost('product_id');
        $wishlist = $this->session->get('wishlist') ?? [];
        $wishlist[$productId] = ($wishlist[$productId] ?? 0) + 1;
        $this->session->set('wishlist', $wishlist);
        return redirect()->back()->with('success', 'Added to wishlist.');
    }

    public function remove()
    {
        $productId = (int)$this->request->getPost('product_id');
        $wishlist = $this->session->get('wishlist') ?? [];
        unset($wishlist[$productId]);
        $this->session->set('wishlist', $wishlist);
        return redirect()->back()->with('info', 'Removed from wishlist.');
    }

    public function update()
    {
        $productId = (int)$this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');
        $wishlist = $this->session->get('wishlist') ?? [];

        if ($quantity <= 0) {
            unset($wishlist[$productId]);
        } else {
            $wishlist[$productId] = $quantity;
        }

        $this->session->set('wishlist', $wishlist);
        return redirect()->back()->with('success', 'Wishlist updated.');
    }
}