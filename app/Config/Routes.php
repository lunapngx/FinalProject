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

// User authentication routes
$routes->get('/login', 'LoginController::index', ['as' => 'login']);
$routes->post('/login', 'LoginController::attemptLogin');
$routes->get('/logout', 'LoginController::logout', ['as' => 'logout']);
$routes->get('/register', 'RegisterController::index', ['as' => 'register']);
$routes->post('/register', 'RegisterController::attemptRegister');

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
$routes->get('/account', 'UserController::index', ['as' => 'account', 'filter' => 'auth']);
$routes->get('/account/orders', 'OrderController::index', ['as' => 'account_orders', 'filter' => 'auth']);
$routes->get('/account/wishlist', 'WishlistController::index', ['as' => 'account_wishlist', 'filter' => 'auth']);


// ====================================================================
// ADMIN ROUTES - START
// ====================================================================
// This section now has named routes to prevent errors.
$routes->group('admin', static function ($routes) {
    // Admin Login/Logout/Register
    $routes->get('login', 'Admin\LoginController::index', ['as' => 'admin_login']);
    $routes->post('login', 'Admin\LoginController::attemptLogin');
    $routes->get('logout', 'Admin\LoginController::logout', ['as' => 'admin_logout']);
    $routes->get('register', 'Admin\RegisterController::index', ['as' => 'admin_register']);
    $routes->post('register', 'Admin\RegisterController::attemptRegister');

    // Admin Dashboard
    $routes->get('dashboard', 'AdminDashboard::index', ['as' => 'admin_dashboard', 'filter' => 'admin_auth']);
    $routes->get('/', 'AdminDashboard::index', ['filter' => 'admin_auth']);

    // This is the specific fix for your current error
    $routes->get('account', 'AdminController::adminaccount', ['as' => 'admin_account', 'filter' => 'admin_auth']);

    // Admin Resource Management
    $routes->get('products', 'AdminController::products', ['as' => 'admin_products', 'filter' => 'admin_auth']);
    $routes->get('orders', 'AdminController::orders', ['as' => 'admin_orders', 'filter' => 'admin_auth']);
    $routes->get('sales-report', 'AdminController::sales_report', ['as' => 'admin_sales_report', 'filter' => 'admin_auth']);
    $routes->match(['get', 'post'], 'products/add', 'AdminController::add_product', ['as' => 'admin_products_add', 'filter' => 'admin_auth']);
    $routes->match(['get', 'post'], 'products/edit/(:num)', 'AdminController::edit_product/$1', ['as' => 'admin_products_edit', 'filter' => 'admin_auth']);
    $routes->get('products/delete/(:num)', 'AdminController::delete_product/$1', ['as' => 'admin_products_delete', 'filter' => 'admin_auth']);
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
