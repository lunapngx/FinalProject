<?php

namespace App\Controllers;

class UserController extends BaseController
{
    /**
     * Displays the main user account page.
     */
    public function index()
    {
        // You can load user data here to pass to the view
        $data = [
            'user' => [
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email'),
            ]
        ];

        return view('Account/account', $data);
    }
}