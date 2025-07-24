<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // Keep this false for better security and explicit routing

// --- Public Routes ---
$routes->get('/', 'Home::index', ['as' => 'home_page']); // <<< Make sure this line is exactly like this
$routes->get('/about', 'Home::about', ['as' => 'about']);

// Product and category routes
$routes->get('/products', 'ProductController::index', ['as' => 'products']);
$routes->get('/product/(:segment)', 'ProductController::show/$1', ['as' => 'product_detail']);
$routes->get('/categories', 'CategoryController::index', ['as' => 'categories_list']);
$routes->get('/category/(:segment)', 'CategoryController::index/$1', ['as' => 'category']);

// Cart and checkout
$routes->get('/cart', 'CartController::index', ['as' => 'cart_view']);
$routes->post('/cart/add', 'CartController::add', ['as' => 'cart_add']);
$routes->get('/cart/remove/(:any)', 'CartController::remove/$1', ['as' => 'cart_remove']);
$routes->get('/checkout', 'CheckoutController::index', ['as' => 'checkout_view']);
$routes->post('/checkout/place-order', 'OrderController::placeOrder', ['as' => 'place_order']);


// --- AUTH ROUTES (Your Custom Routes Take Precedence Over Shield's Here) ---
// If you want to fully control login/logout/register forms and logic, keep these.
// Ensure LoginController::loginView/loginAction and RegisterController::registerView/registerAction exist.
$routes->get('login', 'LoginController::loginView', ['as' => 'login']); // Added 'as' alias
$routes->post('login', 'LoginController::loginAction');
$routes->get('logout', 'LoginController::logoutAction', ['as' => 'logout']); // Added 'as' alias

$routes->get('register', 'RegisterController::registerView', ['as' => 'register']); // Added 'as' alias
$routes->post('register', 'RegisterController::registerAction');


// --- Customer Account Routes ---
// Applies the 'session' filter (which checks if user is logged in)
// You might want to define this in app/Config/Filters.php as a simple 'auth' filter.
$routes->group('customer', ['filter' => 'session'], static function($routes) {
    $routes->get('account', 'UserController::index', ['as' => 'account']);
    $routes->get('account/orders', 'OrderController::index', ['as' => 'account_orders']);
    $routes->get('account/wishlist', 'WishlistController::index', ['as' => 'account_wishlist']);
    // Add routes for managing addresses, profile edits etc. here
    $routes->get('account/addresses', 'AddressController::index', ['as' => 'account_addresses']);
    $routes->match(['GET', 'POST'], 'account/profile', 'UserController::profile', ['as' => 'account_profile']);
});


// --- Admin Routes ---
// Filter ensures user has an active session AND belongs to the 'admin' group
$routes->group('admin', ['filter' => ['session', 'group:admin']], static function($routes){
    // Admin Dashboard
    $routes->get('/', 'AdminDashboard::index', ['as' => 'admin_dashboard']); // Main admin URL (e.g., /admin)

    // Admin Account (often part of a user management section)
    $routes->get('account', 'AdminController::admin_account', ['as' => 'admin_account']); // Renamed method for consistency

    // Product Management
    // Use resource routing for CRUD operations if appropriate, or define individually
    $routes->get('products', 'AdminController::products', ['as' => 'admin_products']);
    $routes->get('products/add', 'AdminController::add_product', ['as' => 'admin_add_product']);
    $routes->post('products/add', 'AdminController::saveProduct');
    $routes->match(['GET', 'POST'], 'products/edit/(:num)', 'AdminController::edit_product/$1', ['as' => 'admin_edit_product']);
    $routes->get('products/delete/(:num)', 'AdminController::delete_product/$1', ['as' => 'admin_products_delete']);

    // Order Management
    $routes->get('orders', 'AdminController::orders', ['as' => 'admin_orders']);
    // Add specific routes for viewing/updating orders (e.g., /admin/orders/(:num), /admin/orders/update-status/(:num))

    // Sales Report
    $routes->get('sales-report', 'AdminController::sales_report', ['as' => 'admin_sales_report']);

    // Other Admin Sections (e.g., Categories, Payments, Users management by admin)
    // Example: For Categories
    $routes->get('categories', 'AdminController::categories', ['as' => 'admin_categories']);
    // ... add more for add, edit, delete categories
    // Example: For Users managed by admin (customers)
    $routes->get('users', 'AdminController::users', ['as' => 'admin_users_list']);
    // ... add more for view, edit, delete customers
});

// IMPORTANT: CodeIgniter Shield's routes MUST be included
// These will define 'login', 'register', 'logout', 'magic-link', etc.
// Since you have custom routes above, Shield's won't be hit for those paths.
service('auth')->routes($routes);