<?php



namespace App\Controllers;



class WishlistController extends BaseController

{

    public function wishlist()

    {

// You can pass user data here if needed, e.g., from session

        return view('wishlist');

    }

}

