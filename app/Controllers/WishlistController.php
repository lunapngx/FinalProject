<?php

namespace App\Controllers;

class WishlistController extends BaseController
{
    /**
     * Displays the user's wishlist.
     */
    public function index()
    {
        // You would load wishlist data from the database here
        $data = [
            'wishlist_items' => [] // Placeholder for wishlist items
        ];

        return view('Account/wishlist', $data);
    }
}
