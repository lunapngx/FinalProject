<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('Admin/home');
    }
}