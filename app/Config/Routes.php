<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */

service('auth')->routes($routes);

$routes->get('login', 'Auth::login', ['as' => 'login']);
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register', ['as' => 'register']);
$routes->post('register', 'Auth::register');
$routes->get('logout', 'Auth::logout', ['as' => 'logout']);
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('about', 'Home::about', ['as' => 'about']);
$routes->get('categories', 'Home::categories', ['as' => 'categories_list']);
$routes->get('product', 'ProductController::index', ['as' => 'products_list']);
$routes->get('product/(:num)', 'ProductController::show/$1', ['as' => 'product_detail']);
$routes->get('category/(:segment)', 'CategoryController::view/$1', ['as' => 'products_by_category_slug']);
$routes->get('cart', 'CartController::index', ['as' => 'cart_view']);
$routes->post('cart/add', 'CartController::add', ['as' => 'cart_add']);
$routes->post('cart/update', 'CartController::update', ['as' => 'cart_update']);
$routes->post('cart/remove', 'CartController::remove', ['as' => 'cart_remove']);
$routes->get('checkout', 'CheckoutController::index', ['as' => 'checkout_view']);
$routes->post('checkout/process', 'CheckoutController::process', ['as' => 'checkout_process']);
$routes->post('order/place', 'OrderController::place', ['as' => 'order_place']);

$routes->get('Wishlist', 'WishlistController::index', ['as' => 'wishlist_view']);
$routes->post('Wishlist/add', 'WishlistController::add');
$routes->post('Wishlist/remove', 'WishlistController::remove');
$routes->post('Wishlist/update', 'WishlistController::update');
$routes->group('admin', ['filter' => 'group:admin'], function ($routes) {

    $routes->get('/', 'AdminDashboard::dashboard', ['as' => 'admin_dashboard']);
    $routes->get('products', 'AdminDashboard::products', ['as' => 'admin_products']);
    $routes->match(['get', 'post'], 'add-product', 'AdminDashboard::addProduct', ['as' => 'admin_add_product']);
    $routes->match(['get', 'post'], 'edit-product/(:num)', 'AdminDashboard::editProduct/$1', ['as' => 'admin_edit_product']);
    $routes->get('delete-product/(:num)', 'AdminDashboard::deleteProduct/$1', ['as' => 'admin_delete_product']);
    $routes->get('orders', 'AdminDashboard::orders', ['as' => 'admin_orders']);
    $routes->get('sales-report', 'AdminDashboard::salesReport', ['as' => 'admin_sales_report']);
    $routes->get('account', 'AdminDashboard::account', ['as' => 'admin_account']);

});

$routes->group('account', ['filter' => 'session'], function ($routes) {

    $routes->get('/', 'AccountController::index', ['as' => 'account_profile']);
    $routes->get('orders', 'AccountController::orders', ['as' => 'account_orders']);
    $routes->get('wishlist', 'WishlistController::index', ['as' => 'account_wishlist']);
    $routes->get('settings', 'AccountController::settings', ['as' => 'account_settings']);
    $routes->get('payment-methods', 'AccountController::paymentMethods', ['as' => 'account_payment_methods']);
    $routes->get('reviews', 'AccountController::reviews', ['as' => 'account_reviews']);
    $routes->get('addresses', 'AccountController::addresses', ['as' => 'account_addresses']);
    $routes->get('help', 'AccountController::help', ['as' => 'account_help']);



});