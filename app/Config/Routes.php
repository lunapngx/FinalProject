<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Router\RouteCollection;

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
$routes->setAutoRoute(false); // Disable auto-routing for security (recommended)

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// CodeIgniter Shield Authentication Routes (from your local)
service('auth')->routes($routes);

// Public Facing Routes
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('about', 'Home::about', ['as' => 'about']);
$routes->get('categories', 'Home::categories', ['as' => 'categories_list']); // Your route
$routes->get('products', 'ProductController::index', ['as' => 'products']); // Remote's route, more generic
$routes->get('product', 'ProductController::index', ['as' => 'products_list']); // Your route, similar to remote's 'products'
$routes->get('product/(:num)', 'ProductController::show/$1', ['as' => 'product_detail']); // Your route
$routes->get('category/(:segment)', 'CategoryController::view/$1', ['as' => 'products_by_category_slug']); // Your route
// Merged Wishlist routes (from your local)
$routes->get('Wishlist', 'WishlistController::index', ['as' => 'wishlist_view']);
$routes->post('Wishlist/add', 'WishlistController::add');
$routes->post('Wishlist/remove', 'WishlistController::remove');
$routes->post('Wishlist/update', 'WishlistController::update');

// User Authentication & Account Routes
// Some of these might be redundant with Shield routes above, but kept for explicit definition
$routes->get('login', 'LoginController::index', ['as' => 'login']); // Remote's route, if not handled by Shield
$routes->post('login', 'LoginController::attemptLogin'); // Remote's route
$routes->get('register', 'RegisterController::index', ['as' => 'register']); // Remote's route
$routes->post('register', 'RegisterController::attemptRegister'); // Remote's route
$routes->get('logout', 'LoginController::logout', ['as' => 'logout']); // Remote's route

// Cart and Checkout Routes
$routes->get('cart', 'CartController::index', ['as' => 'cart_view']);
$routes->post('cart/add', 'CartController::add', ['as' => 'cart_add']);
$routes->post('cart/update', 'CartController::update', ['as' => 'cart_update']); // Your route
$routes->post('cart/remove', 'CartController::remove', ['as' => 'cart_remove']); // Your route (remote had remove/(:any))
$routes->get('checkout', 'CheckoutController::index', ['as' => 'checkout_view']);
$routes->post('checkout/process', 'CheckoutController::process', ['as' => 'checkout_process']); // Your route
$routes->post('order/place', 'OrderController::place', ['as' => 'order_place']); // Your route
// Remote's explicit place order
$routes->post('/checkout/place-order', 'OrderController::placeOrder', ['as' => 'place_order']);


// ====================================================================
// CUSTOMER ACCOUNT ROUTES (from your local 'account' group and remote's general account routes)
// ====================================================================
$routes->group('account', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'AccountController::index', ['as' => 'account_profile']); // Your route
    $routes->get('orders', 'AccountController::orders', ['as' => 'account_orders']); // Your route
    $routes->get('wishlist', 'WishlistController::index', ['as' => 'account_wishlist']); // Your route
    $routes->get('settings', 'AccountController::settings', ['as' => 'account_settings']); // Your route
    $routes->get('payment-methods', 'AccountController::paymentMethods', ['as' => 'account_payment_methods']); // Your route
    $routes->get('reviews', 'AccountController::reviews', ['as' => 'account_reviews']); // Your route
    $routes->get('addresses', 'AccountController::addresses', ['as' => 'account_addresses']); // Your route
    $routes->get('help', 'AccountController::help', ['as' => 'account_help']); // Your route
});
// Remote's general account routes (kept as backup, consider if these overlap with the group)
$routes->get('/account', 'UserController::index', ['as' => 'account', 'filter' => 'auth']);
$routes->get('/account/orders', 'OrderController::index', ['as' => 'account_orders', 'filter' => 'auth']);
$routes->get('/account/wishlist', 'WishlistController::index', ['as' => 'account_wishlist', 'filter' => 'auth']);


// ====================================================================
// ADMIN ROUTES
// ====================================================================
$routes->group('admin', static function ($routes) {
    // Admin Login/Logout/Register (from remote)
    $routes->get('login', 'Admin\LoginController::index', ['as' => 'admin_login']);
    $routes->post('login', 'Admin\LoginController::attemptLogin');
    $routes->get('logout', 'Admin\LoginController::logout', ['as' => 'admin_logout']);
    $routes->get('register', 'Admin\RegisterController::index', ['as' => 'admin_register']);
    $routes->post('register', 'Admin\RegisterController::attemptRegister');

    // Admin Dashboard (combined from both)
    $routes->get('/', 'AdminDashboard::dashboard', ['as' => 'admin_dashboard', 'filter' => 'group:admin']); // Your route filter
    $routes->get('dashboard', 'AdminDashboard::index', ['as' => 'admin_dashboard', 'filter' => 'admin_auth']); // Remote's specific dashboard route

    // Admin Account (combined)
    $routes->get('account', 'AdminDashboard::account', ['as' => 'admin_account']); // Your route
    $routes->get('account', 'AdminController::adminaccount', ['as' => 'admin_account', 'filter' => 'admin_auth']); // Remote's explicit fix

    // Admin Product Management (combined and expanded)
    $routes->get('products', 'AdminDashboard::products', ['as' => 'admin_products']); // Your products list
    $routes->get('products', 'AdminController::products', ['as' => 'admin_products', 'filter' => 'admin_auth']); // Remote's products list
    $routes->match(['get', 'post'], 'add-product', 'AdminDashboard::addProduct', ['as' => 'admin_add_product']); // Your add product
    $routes->match(['get', 'post'], 'products/add', 'AdminController::add_product', ['as' => 'admin_products_add', 'filter' => 'admin_auth']); // Remote's add product
    $routes->match(['get', 'post'], 'edit-product/(:num)', 'AdminDashboard::editProduct/$1', ['as' => 'admin_edit_product']); // Your edit product
    $routes->match(['get', 'post'], 'products/edit/(:num)', 'AdminController::edit_product/$1', ['as' => 'admin_products_edit', 'filter' => 'admin_auth']); // Remote's edit product
    $routes->get('delete-product/(:num)', 'AdminDashboard::deleteProduct/$1', ['as' => 'admin_delete_product']); // Your delete product
    $routes->get('products/delete/(:num)', 'AdminController::delete_product/$1', ['as' => 'admin_products_delete', 'filter' => 'admin_auth']); // Remote's delete product

    // Admin Order and Sales Reports (combined)
    $routes->get('orders', 'AdminDashboard::orders', ['as' => 'admin_orders']); // Your orders
    $routes->get('orders', 'AdminController::orders', ['as' => 'admin_orders', 'filter' => 'admin_auth']); // Remote's orders
    $routes->get('sales-report', 'AdminDashboard::salesReport', ['as' => 'admin_sales_report']); // Your sales report
    $routes->get('sales-report', 'AdminController::sales_report', ['as' => 'admin_sales_report', 'filter' => 'admin_auth']); // Remote's sales report
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}