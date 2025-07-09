<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('Home/index');
    }
}