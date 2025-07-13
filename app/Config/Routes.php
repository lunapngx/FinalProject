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

// Public Facing Routes (Combined)
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

// User Authentication & Account Routes (Combined, some might be redundant with Shield but explicit for clarity)
$routes->get('login', 'LoginController::index', ['as' => 'login']); // Remote's route, if not handled by Shield
$routes->post('login', 'LoginController::attemptLogin'); // Remote's route
$routes->get('register', 'RegisterController::index', ['as' => 'register']); // Remote's route
$routes->post('register', 'RegisterController::attemptRegister'); // Remote's route
$routes->get('logout', 'LoginController::logout', ['as' => 'logout']); // Remote's route

// Cart and Checkout Routes (Combined)
$routes->get('cart', 'CartController::index', ['as' => 'cart_view']);
$routes->post('cart/add', 'CartController::add', ['as' => 'cart_add']);
$routes->post('cart/update', 'CartController::update', ['as' => 'cart_update']); // Your route
$routes->post('cart/remove', 'CartController::remove', ['as' => 'cart_remove']); // Your route (remote had remove/(:any))
$routes->get('checkout', 'CheckoutController::index', ['as' => 'checkout_view']);
$routes->post('checkout/process', 'CheckoutController::process', ['as' => 'checkout_process']); // Your route
$routes->post('order/place', 'OrderController::place', ['as' => 'order_place']); // Your route
$routes->post('/checkout/place-order', 'OrderController::placeOrder', ['as' => 'place_order']); // Remote's explicit place order


// ====================================================================
// CUSTOMER ACCOUNT ROUTES (Combined from your local 'account' group and remote's general account routes)
// ====================================================================

// Your comprehensive account group (preferred, assuming controllers are in App\Controllers\AccountController)
$routes->group('account', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'AccountController::index', ['as' => 'account_profile']);
    $routes->get('orders', 'AccountController::orders', ['as' => 'account_orders']);
    $routes->get('wishlist', 'WishlistController::index', ['as' => 'account_wishlist']); // Your route
    $routes->get('settings', 'AccountController::settings', ['as' => 'account_settings']);
    $routes->get('payment-methods', 'AccountController::paymentMethods', ['as' => 'account_payment_methods']);
    $routes->get('reviews', 'AccountController::reviews', ['as' => 'account_reviews']);
    $routes->get('addresses', 'AccountController::addresses', ['as' => 'account_addresses']);
    $routes->get('help', 'AccountController::help', ['as' => 'account_help']);
});

// Remote's general account routes (kept if they map to different controllers, e.g., App\Controllers\UserController)
// Note: Some of these might be redundant with the group above. Harmonize controller usage if possible.
$routes->get('/account', 'UserController::index', ['as' => 'account', 'filter' => 'auth']); // Remote's general account
$routes->get('/account/orders', 'OrderController::index', ['as' => 'account_orders', 'filter' => 'auth']); // Remote's orders, might overlap
// Your `account_wishlist` is already inside the group.
// $routes->get('/account/wishlist', 'WishlistController::index', ['as' => 'account_wishlist', 'filter' => 'auth']); // Remote's wishlist, redundant with group


// ====================================================================
// ADMIN ROUTES (Combined and Harmonized)
// ====================================================================
$routes->group('admin', ['filter' => 'group:admin'], static function ($routes) { // Prioritizing 'group:admin' filter
    // Admin Login/Logout/Register (from remote, within admin group for clarity)
    $routes->get('login', 'Admin\LoginController::index', ['as' => 'admin_login']);
    $routes->post('login', 'Admin\LoginController::attemptLogin');
    $routes->get('logout', 'Admin\LoginController::logout', ['as' => 'admin_logout']);
    $routes->get('register', 'Admin\RegisterController::index', ['as' => 'admin_register']);
    $routes->post('register', 'Admin\RegisterController::attemptRegister');

    // Admin Dashboard
    $routes->get('/', 'AdminDashboard::dashboard', ['as' => 'admin_dashboard_your']); // Your preferred dashboard
    $routes->get('dashboard', 'AdminController::dashboard', ['as' => 'admin_dashboard_remote']); // Remote's dashboard (can point to the same if logic is merged)

    // Admin Account (choose one, or point both to a harmonized controller method)
    $routes->get('account', 'AdminDashboard::account', ['as' => 'admin_account_your']); // Your account route
    $routes->get('account', 'AdminController::adminaccount', ['as' => 'admin_account_remote']); // Remote's account route

    // Admin Product Management
    $routes->get('products', 'AdminDashboard::products', ['as' => 'admin_products_your']); // Your products list
    $routes->get('products', 'AdminController::products', ['as' => 'admin_products_remote']); // Remote's products list
    $routes->match(['get', 'post'], 'add-product', 'AdminDashboard::addProduct', ['as' => 'admin_add_product_your']); // Your add product
    $routes->match(['get', 'post'], 'products/add', 'AdminController::add_product', ['as' => 'admin_products_add_remote']); // Remote's add product
    $routes->match(['get', 'post'], 'edit-product/(:num)', 'AdminDashboard::editProduct/$1', ['as' => 'admin_edit_product_your']); // Your edit product
    $routes->match(['get', 'post'], 'products/edit/(:num)', 'AdminController::edit_product/$1', ['as' => 'admin_products_edit_remote']); // Remote's edit product
    $routes->get('delete-product/(:num)', 'AdminDashboard::deleteProduct/$1', ['as' => 'admin_delete_product_your']); // Your delete product
    $routes->get('products/delete/(:num)', 'AdminController::delete_product/$1', ['as' => 'admin_products_delete_remote']); // Remote's delete product

    // Admin Order and Sales Reports
    $routes->get('orders', 'AdminDashboard::orders', ['as' => 'admin_orders_your']); // Your orders
    $routes->get('orders', 'AdminController::orders', ['as' => 'admin_orders_remote']); // Remote's orders
    $routes->get('sales-report', 'AdminDashboard::salesReport', ['as' => 'admin_sales_report_your']); // Your sales report
    $routes->get('sales-report', 'AdminController::sales_report', ['as' => 'admin_sales_report_remote']); // Remote's sales report
});

// Remote's 'user' group, ensure 'auth:user' filter is configured
$routes->group('user', ['filter' => 'auth:user'], function ($routes) {
    $routes->get('index', 'UserController::dashboard');
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