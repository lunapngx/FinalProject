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
$routes->get('product', 'ProductController::index', ['as' => 'products_list']); // Removed User\
$routes->get('product/(:num)', 'ProductController::show/$1', ['as' => 'product_detail']); // Removed User\
$routes->get('category/(:segment)', 'CategoryController::view/$1', ['as' => 'products_by_category_slug']); // Removed User\

// Cart Routes (already fixed in previous turn)
$routes->get('cart', 'CartController::index', ['as' => 'cart_view']);
$routes->post('cart/add', 'CartController::add', ['as' => 'cart_add']);
$routes->post('cart/update', 'CartController::update', ['as' => 'cart_update']);
$routes->post('cart/remove', 'CartController::remove', ['as' => 'cart_remove']);

// Checkout Routes
$routes->get('checkout', 'CheckoutController::index', ['as' => 'checkout_view']); // Removed User\
$routes->post('checkout', 'CheckoutController::process', ['as' => 'checkout_process']); // Removed User\

// Order Routes
$routes->post('order/place', 'OrderController::place', ['as' => 'order_place']); // Removed User\

// Admin Group Routes (apply 'group:admin' filter, assuming you have Shield or custom group checking)
$routes->group('admin', ['filter' => 'group:admin'], function ($routes) {
    $routes->get('/', 'AdminDashboard::index', ['as' => 'admin_dashboard']);
    $routes->get('products', 'AdminDashboard::products', ['as' => 'admin_products']);
    $routes->match(['get', 'post'], 'add-product', 'AdminDashboard::addProduct', ['as' => 'admin_add_product']);
    $routes->match(['get', 'post'], 'edit-product/(:num)', 'AdminDashboard::editProduct/$1', ['as' => 'admin_edit_product']);
    $routes->get('delete-product/(:num)', 'AdminDashboard::deleteProduct/$1', ['as' => 'admin_delete_product']);
    $routes->get('orders', 'AdminDashboard::orders', ['as' => 'admin_orders']);
    $routes->get('sales-report', 'AdminDashboard::salesReport', ['as' => 'admin_sales_report']);
    $routes->get('account', 'AdminDashboard::account', ['as' => 'admin_account']);
});

// User Account Routes (apply 'session' filter for logged-in users)
$routes->group('account', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'User\AccountController::index'); // Assuming User\AccountController exists
    $routes->get('orders', 'User\AccountController::orders');
    // ...
});