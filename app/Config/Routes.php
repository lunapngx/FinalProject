<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // Disable auto-routing for security

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('/about', 'Home::about', ['as' => 'about']);

// app/Config/Routes.php

// ... (existing code) ...

// ====================================================================
// UNIFIED AUTHENTICATION ROUTES - START
// All login, registration, and logout now go through AuthController
// ====================================================================
// Changed to allow both GET and POST for login and register directly
$routes->match(['get', 'post'], 'login', 'AuthController::login', ['as' => 'login']);
$routes->match(['get', 'post'], 'register', 'AuthController::register', ['as' => 'register']);
$routes->get('logout', 'AuthController::logout', ['as' => 'logout']);

// Redirecting old admin login/register URLs to the unified authentication forms
$routes->get('admin/login', 'AuthController::login', ['as' => 'admin_login_redirect']);
$routes->get('admin/register', 'AuthController::register', ['as' => 'admin_register_redirect']);
$routes->get('admin/logout', 'AuthController::logout', ['as' => 'admin_logout']);
// ====================================================================
// UNIFIED AUTHENTICATION ROUTES - END
// ====================================================================


// Product and Category Routes
$routes->get('/products', 'ProductController::index', ['as' => 'products']);
$routes->get('/product/(:segment)', 'ProductController::show/$1', ['as' => 'product_detail']);
$routes->get('/categories', 'CategoryController::index', ['as' => 'categories_list']);
$routes->get('/category/(:segment)', 'CategoryController::index/$1', ['as' => 'category']);

// Cart and Checkout
$routes->get('/cart', 'CartController::index', ['as' => 'cart_view']);
$routes->post('/cart/add', 'CartController::add', ['as' => 'cart_add']);
$routes->get('/cart/remove/(:any)', 'CartController::remove/$1', ['as' => 'cart_remove']);
$routes->get('/checkout', 'CheckoutController::index', ['as' => 'checkout_view']);
$routes->post('/checkout/place-order', 'OrderController::placeOrder', ['as' => 'place_order']);

// Customer Account Routes
$routes->group('', ['filter' => 'auth'], function($routes) { // Assuming 'auth' filter for regular users
    $routes->get('account', 'UserController::index', ['as' => 'account']);
    $routes->get('account/orders', 'OrderController::index', ['as' => 'account_orders']);
    $routes->get('account/wishlist', 'WishlistController::index', ['as' => 'account_wishlist']);
});


// ====================================================================
// ADMIN ROUTES - START
// ====================================================================
$routes->group('admin', ['filter' => 'adminAuth'], function($routes){ // Ensure 'adminAuth' filter is correctly configured in app/Config/Filters.php
    $routes->get('dashboard', 'AdminDashboard::index', ['as' => 'admin_dashboard']);
    $routes->get('/', 'AdminDashboard::index'); // Default for /admin
    $routes->get('account', 'AdminController::adminaccount', ['as' => 'admin_account']);
    $routes->get('products', 'AdminController::products', ['as' => 'admin_products']);
    $routes->get('orders', 'AdminController::orders', ['as' => 'admin_orders']);
    $routes->get('sales-report', 'AdminController::sales_report', ['as' => 'admin_sales_report']);
    $routes->get('products/add', 'AdminController::add_product');
    $routes->match(['GET', 'POST'], 'products/add', 'AdminController::add_product', ['as' => 'admin_add_product']);
    $routes->match(['GET', 'POST'], 'products/edit/(:num)', 'AdminController::edit_product/$1', ['as' => 'admin_edit_product']);
    $routes->get('products/delete/(:num)', 'AdminController::delete_product/$1', ['as' => 'admin_products_delete']);
});
// ====================================================================
// ADMIN ROUTES - END
// ====================================================================


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}