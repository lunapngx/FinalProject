<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about', ['as' => 'about']);


// --- AUTH ROUTES ---

// Your custom routes should come FIRST
// This tells the app to use your controller for login and logout
$routes->get('login', 'LoginController::loginView');
$routes->post('login', 'LoginController::loginAction');
$routes->get('logout', 'LoginController::logoutAction');

// Registration
$routes->get('register', 'RegisterController::registerView');
$routes->post('register', 'RegisterController::registerAction');


// Product and category routes
$routes->get('/products', 'ProductController::index', ['as' => 'products']);
$routes->get('/product/(:segment)', 'ProductController::show/$1', ['as' => 'product_detail']);
$routes->get('/categories', 'CategoryController::index', ['as' => 'categories_list']);
$routes->get('/category/(:segment)', 'CategoryController::index/$1', ['as' => 'category']);

// Cart and checkout
$routes->get('/cart', 'CartController::index', ['as' => 'cart_view']);
$routes->post('/cart/add', 'CartController::add', ['as' => 'cart_add']);
$routes->get('/cart/remove/(:any)', 'CartController::remove/$1', ['as' => 'cart_remove']);
$routes->get('/checkout', 'CheckoutController::index', ['as' => 'checkout_view']); // ADDED: ['as' => 'checkout_view']
$routes->post('/checkout/place-order', 'OrderController::placeOrder', ['as' => 'place_order']); // Corrected route name if place_order is used

// Customer account routes (auth filter applied in Filters.php)
$routes->group('customer', function($routes) {
    $routes->get('account', 'UserController::index', ['as' => 'account']);
    $routes->get('account/orders', 'OrderController::index', ['as' => 'account_orders']);
    $routes->get('account/wishlist', 'WishlistController::index', ['as' => 'account_wishlist']);
});

// Admin routes (adminAuth filter applied in Filters.php)
$routes->group('admin', function($routes){
    $routes->get('dashboard', 'AdminDashboard::index', ['as' => 'admin_dashboard']);
    $routes->get('/', 'AdminDashboard::index'); // This route is often used as the base admin URL
    $routes->get('account', 'AdminController::adminaccount', ['as' => 'admin_account']);
    $routes->get('products', 'AdminController::products', ['as' => 'admin_products']);
    $routes->get('orders', 'AdminController::orders', ['as' => 'admin_orders']);
    $routes->get('sales-report', 'AdminController::sales_report', ['as' => 'admin_sales_report']);
    $routes->get('products/add', 'AdminController::add_product'); // Keep this if used for GET request to show form
    $routes->match(['GET', 'POST'], 'products/add', 'AdminController::add_product', ['as' => 'admin_add_product']); // Changed to 'GET', 'POST'
    $routes->match(['GET', 'POST'], 'products/edit/(:num)', 'AdminController::edit_product/$1', ['as' => 'admin_edit_product']); // Changed to 'GET', 'POST'
    $routes->get('products/delete/(:num)', 'AdminController::delete_product/$1', ['as' => 'admin_products_delete']);
});

// IMPORTANT: CodeIgniter Shield's routes MUST be included
// These will define 'login', 'register', 'logout', 'magic-link', etc.
service('auth')->routes($routes);