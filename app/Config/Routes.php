<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Remove duplicate: $routes->get('/', 'Home::index');

// IMPORTANT: Uncomment this line only if you want to use CodeIgniter Shield for authentication.
// If you use your custom App\Controllers\Auth, keep this line commented out.
service('auth')->routes($routes);

// Custom Authentication Routes (if not using Shield)
$routes->get('login', 'Auth::login', ['as' => 'login']);
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register', ['as' => 'register']);
$routes->post('register', 'Auth::register');
$routes->get('logout', 'Auth::logout', ['as' => 'logout']);

// Frontend Routes
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('about', 'Home::about', ['as' => 'about']);
$routes->get('categories', 'Home::categories', ['as' => 'categories_list']); // Route to list all categories if Home::categories handles it

// Product Routes
$routes->get('product', 'User\ProductController::index', ['as' => 'products_list']);
$routes->get('product/(:num)', 'User\ProductController::show/$1', ['as' => 'product_detail']); // View single product
$routes->get('category/(:segment)', 'User\CategoryController::view/$1', ['as' => 'products_by_category_slug']); // View products by category slug

// Cart Routes
$routes->get('cart', 'User\CartController::index', ['as' => 'cart_view']);
$routes->post('cart/add', 'User\CartController::add', ['as' => 'cart_add']);
$routes->post('cart/update', 'User\CartController::update', ['as' => 'cart_update']);
$routes->post('cart/remove', 'User\CartController::remove', ['as' => 'cart_remove']);

// Checkout Routes
$routes->get('checkout', 'User\CheckoutController::index', ['as' => 'checkout_view']);
$routes->post('checkout', 'User\CheckoutController::process', ['as' => 'checkout_process']); // Changed from checkout/process

// Order Routes
$routes->post('order/place', 'User\OrderController::place', ['as' => 'order_place']);

// Admin Group Routes (apply 'group:admin' filter, assuming you have Shield or custom group checking)
$routes->group('admin', ['filter' => 'group:admin'], function ($routes) {
    $routes->get('/', 'Dashboard::index', ['as' => 'admin_dashboard']); // Dashboard controller is at App\Controllers\Dashboard
    $routes->resource('products', ['controller' => 'Admin\Product']); // CRUD for products (Admin\Product controller)
    $routes->resource('categories', ['controller' => 'Admin\Category']); // CRUD for categories (Admin\Category controller)
    $routes->resource('orders', ['controller' => 'Admin\Order']); // Manage orders (Admin\Order controller)
    // ... more admin routes
});

// User Account Routes (apply 'session' filter for logged-in users)
$routes->group('account', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'User\AccountController::index'); // Assuming User\AccountController exists
    $routes->get('orders', 'User\AccountController::orders');
    // ...
});