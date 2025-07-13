<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Meraki Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex flex-col min-h-screen">

<header class="bg-white shadow-sm py-4">
    <div class="container mx-auto px-8 flex items-center justify-between">
        <div class="flex items-center">
            <span class="text-2xl font-bold text-gray-800 mr-8">My Account</span>
        </div>
    </div>
</header>

<main class="flex flex-1 container mx-auto py-8 px-4">

    <aside class="w-64 bg-white p-6 shadow-md rounded-r-lg flex flex-col justify-between flex-shrink-0">
        <div>
            <div class="user-profile-widget text-center py-4">
                <div class="relative mx-auto" style="width: 120px; height: 120px;">
                    <img src="https://placehold.co/80x80/e0f2fe/1d4ed8?text=GR" alt="User Profile Picture" class="w-32 h-32 rounded-full border-2 border-blue-500 object-cover cursor-pointer" id="profilePicture">
                    <span class="status-indicator online-indicator" style="background-color: #28a745; position: absolute; bottom: 5px; right: 5px; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white;"></span>
                    <input type="file" id="profilePictureInput" accept="image/*" class="hidden">
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mt-2">
                    <?php if (auth()->loggedIn()): ?>
                        <?= esc(auth()->user()->username ?? auth()->user()->email ?? 'Logged in User') ?>
                    <?php else: ?>
                        Guest User
                    <?php endif; ?>
                </h3>
            </div>

            <nav>
                <ul>
                    <li class="mb-2">
                        <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="myProfileContent">
                            <i class="fas fa-user-circle text-xl mr-3"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="myOrders">
                            <i class="fas fa-box-open text-xl mr-3"></i>
                            <span>My Orders</span>
                            <span class="ml-auto bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-full">3</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="wishlist">
                            <i class="fas fa-heart text-xl mr-3"></i>
                            <span>Wishlist</span>
                            <span class="ml-auto bg-gray-300 text-gray-800 text-xs font-bold px-2 py-1 rounded-full">12</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="paymentMethods">
                            <i class="fas fa-credit-card text-xl mr-3"></i>
                            <span>Payment Methods</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="myReviews">
                            <i class="fas fa-star text-xl mr-3"></i>
                            <span>My Reviews</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="addresses">
                            <i class="fas fa-map-marker-alt text-xl mr-3"></i>
                            <span>Address</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="accountSettings">
                            <i class="fas fa-cog text-xl mr-3"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div>
            <hr class="my-6 border-gray-200">
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 transition duration-200" data-section-id="helpCenter">
                <i class="fas fa-question-circle text-xl mr-3"></i>
                <span>Help Center</span>
            </a>
            <a href="<?= url_to('logout') ?>" class="sidebar-link flex items-center p-3 rounded-lg text-red-600 hover:bg-red-50 transition duration-200">
                <i class="fas fa-sign-out-alt text-xl mr-3"></i>
                <span>Log Out</span>
            </a>
        </div>
    </aside>

    <div class="flex-1 ml-8">
        <section id="myProfileContent" class="content-section">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">My Profile</h1>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-700 mb-4">Welcome to your profile page, <?= esc($user->username ?? 'User') ?>!</p>
                <p class="text-gray-700">Here you can see a summary of your account information.</p>
                <ul class="mt-4 space-y-2 text-gray-800">
                    <li><strong>Email:</strong> <?= esc($user->email ?? 'N/A') ?></li>
                    <li><strong>Member Since:</strong> <?= esc($user->created_at->format('M d, Y') ?? 'N/A') ?></li>
                </ul>
                <div class="mt-6">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200" data-section-id="accountSettings">
                        Edit Profile
                    </button>
                </div>
            </div>
        </section>

        <section id="myOrders" class="content-section hidden">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">My Orders</h1>
            <div class="flex items-center justify-between mb-8">
                <div class="relative w-full max-w-md">
                    <input type="text" placeholder="Search orders..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <button class="ml-4 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </div>
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-lg order-card">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800">Order ID: #ORD-2024-1278</span>
                        <span class="text-sm text-gray-500">Feb 20, 2025</span>
                    </div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="https://placehold.co/60x60/fecaca/dc2626?text=Bag" alt="Product Image" class="rounded-md">
                        <img src="https://placehold.co/60x60/fecaca/dc2626?text=Chair" alt="Product Image" class="rounded-md">
                        <img src="https://placehold.co/60x60/fecaca/dc2626?text=Glasses" alt="Product Image" class="rounded-md">
                    </div>
                    <div class="grid grid-cols-2 gap-y-2 mb-6">
                        <div>
                            <span class="text-gray-500 text-sm">Status</span><br>
                            <span class="text-orange-500 font-medium">Processing</span>
                        </div>
                        <div class="text-right">
                            <span class="text-gray-500 text-sm">Items</span><br>
                            <span class="text-gray-800 font-medium">3 items</span>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-gray-500 text-sm">Total</span><br>
                            <span class="text-gray-800 text-xl font-bold">$789.99</span>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200" data-order-id="ORD-2024-1278" data-sub-section-target="trackOrder">Track Order</button>
                        <button class="flex-1 bg-blue-50 text-blue-600 border border-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-100 transition duration-200" data-order-id="ORD-2024-1278" data-sub-section-target="viewDetails">View Details</button>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg order-card">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800">Order ID: #ORD-2024-1265</span>
                        <span class="text-sm text-gray-500">Feb 15, 2025</span>
                    </div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="https://placehold.co/60x60/fecaca/dc2626?text=Hoodie" alt="Product Image" class="rounded-md">
                        <img src="https://placehold.co/60x60/fecaca/dc2626?text=Shoes" alt="Product Image" class="rounded-md">
                    </div>
                    <div class="grid grid-cols-2 gap-y-2 mb-6">
                        <div>
                            <span class="text-gray-500 text-sm">Status</span><br>
                            <span class="text-green-600 font-medium">Shipped</span>
                        </div>
                        <div class="text-right">
                            <span class="text-gray-500 text-sm">Items</span><br>
                            <span class="text-gray-800 font-medium">2 items</span>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-gray-500 text-sm">Total</span><br>
                            <span class="text-gray-800 text-xl font-bold">$459.99</span>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200" data-order-id="ORD-2024-1265" data-sub-section-target="trackOrder">Track Order</button>
                        <button class="flex-1 bg-blue-50 text-blue-600 border border-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-100 transition duration-200" data-order-id="ORD-2024-1265" data-sub-section-target="viewDetails">View Details</button>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg order-card">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800">Order ID: #ORD-2024-1252</span>
                        <span class="text-sm text-gray-500">Feb 10, 2025</span>
                    </div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="https://placehold.co/60x60/fecaca/dc2626?text=Watch" alt="Product Image" class="rounded-md">
                    </div>
                    <div class="grid grid-cols-2 gap-y-2 mb-6">
                        <div>
                            <span class="text-gray-500 text-sm">Status</span><br>
                            <span class="text-green-600 font-medium">Delivered</span>
                        </div>
                        <div class="text-right">
                            <span class="text-gray-500 text-sm">Items</span><br>
                            <span class="text-gray-800 font-medium">1 item</span>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-gray-500 text-sm">Total</span><br>
                            <span class="text-gray-800 text-xl font-bold">$129.99</span>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200" data-order-id="ORD-2024-1252" data-sub-section-target="trackOrder">Track Order</button>
                        <button class="flex-1 bg-blue-50 text-blue-600 border border-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-100 transition duration-200" data-order-id="ORD-2024-1252" data-sub-section-target="viewDetails">View Details</button>
                    </div>
                </div>
            </div>
        </section>

        <section id="trackOrderSection" class="content-section hidden">
            <button class="text-blue-600 hover:underline mb-4 flex items-center" data-section-id="myOrders">
                <i class="fas fa-arrow-left mr-2"></i> Back to My Orders
            </button>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold text-gray-800" id="trackOrderId">Order ID: #</span>
                    <span class="text-sm text-gray-500" id="trackOrderDate"></span>
                </div>
                <div class="flex items-center space-x-3 mb-4" id="trackOrderImages">
                </div>
                <div class="grid grid-cols-2 gap-y-2 mb-6">
                    <div>
                        <span class="text-gray-500 text-sm">Status</span><br>
                        <span class="text-orange-500 font-medium" id="trackOrderStatus"></span>
                    </div>
                    <div class="text-right">
                        <span class="text-gray-500 text-sm">Items</span><br>
                        <span class="text-gray-800 font-medium">3 items</span>
                    </div>
                    <div class="col-span-2 text-right">
                        <span class="text-gray-500 text-sm">Total</span><br>
                        <span class="text-gray-800 text-xl font-bold">$789.99</span>
                    </div>
                </div>

                <div class="mt-8 space-y-6" id="trackOrderTimeline">
                </div>
            </div>
        </section>

        <section id="viewDetailsSection" class="content-section hidden">
            <button class="text-blue-600 hover:underline mb-4 flex items-center" data-section-id="myOrders">
                <i class="fas fa-arrow-left mr-2"></i> Back to My Orders
            </button>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Payment Method</h3>
                        <p class="text-gray-800" id="viewDetailsPaymentMethod"></p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Shipping Method</h3>
                        <p class="text-gray-800" id="viewDetailsShippingMethod"></p>
                    </div>
                </div>

                <h3 class="font-semibold text-gray-700 mb-4">Items (<span id="viewDetailsItemCount"></span>)</h3>
                <div class="space-y-4 mb-8" id="viewDetailsItems">
                </div>

                <h3 class="font-semibold text-gray-700 mb-4">Price Details</h3>
                <div class="space-y-2 mb-8">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal</span>
                        <span id="viewDetailsSubtotal"></span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Shipping</span>
                        <span id="viewDetailsShipping"></span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Tax</span>
                        <span id="viewDetailsTax"></span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-blue-600 border-t border-gray-300 pt-2">
                        <span>Total</span>
                        <span id="viewDetailsTotal"></span>
                    </div>
                </div>

                <h3 class="font-semibold text-gray-700 mb-4">Shipping Address</h3>
                <address class="text-gray-800 not-italic" id="viewDetailsShippingAddress"></address>
            </div>
        </section>

        <section id="wishlist" class="content-section hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">My Wishlist</h2>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                    Add All to Cart
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="wishlist-item">
                        <span class="absolute top-2 left-2 bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded">
                            -20%
                        </span>
                    <img src="https://placehold.co/300x300/f8f8f8/000?text=Brown+Bag" alt="Brown Bag" class="rounded-md">
                    <div class="text-left w-full mt-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Lorem ipsum dolor sit amet</h3>
                        <div class="flex items-center mb-2 star-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="ml-1 text-sm text-gray-600">(4.5)</span>
                        </div>
                        <p class="price">$79.99 <span class="old-price">$99.99</span></p>
                        <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                            Add to Cart
                        </button>
                    </div>
                </div>

                <div class="wishlist-item">
                    <img src="https://placehold.co/300x300/f8f8f8/000?text=Wooden+Chair" alt="Wooden Chair" class="rounded-md">
                    <div class="text-left w-full mt-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Consectetur adipiscing elit</h3>
                        <div class="flex items-center mb-2 star-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="ml-1 text-sm text-gray-600">(4.0)</span>
                        </div>
                        <p class="price">$149.99</p>
                        <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                            Add to Cart
                        </button>
                    </div>
                </div>

                <div class="wishlist-item relative">
                        <span class="absolute top-2 left-2 bg-gray-700 text-white text-xs font-semibold px-2 py-1 rounded">
                            Out of Stock
                        </span>
                    <img src="https://placehold.co/300x300/f8f8f8/000?text=Sunglasses" alt="Sunglasses" class="rounded-md opacity-70">
                    <div class="text-left w-full mt-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Sed do eiusmod tempor</h3>
                        <div class="flex items-center mb-2 star-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="ml-1 text-sm text-gray-600">(5.0)</span>
                        </div>
                        <p class="price">$199.99</p>
                        <button class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-semibold cursor-not-allowed" disabled>
                            Notify When Available
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section id="paymentMethods" class="content-section hidden">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Payment Methods</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg border-2 border-blue-500 shadow-md">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-money-bill-wave text-blue-600 text-2xl mr-3"></i>
                            <h3 class="text-xl font-semibold text-gray-800">Cash on Delivery</h3>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Default</span>
                    </div>
                    <p class="text-gray-600 mb-4">Pay with cash when your order is delivered to your doorstep.</p>
                    <div class="flex space-x-2">
                        <button class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 border border-blue-600 rounded-lg font-semibold hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-check-circle mr-2"></i> Selected
                        </button>
                    </div>
                </div>
                <div class="md:col-span-1 flex items-center justify-center text-gray-500 text-center p-6 border border-gray-300 rounded-lg bg-gray-50">
                    <p>No other payment methods are currently available.</p>
                </div>
            </div>
        </section>

        <section id="myReviews" class="content-section hidden">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">My Reviews</h2>
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 flex items-center">
                    <i class="fas fa-sort mr-2"></i> Sort by: Recent
                </button>
            </div>
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-lg review-card">
                    <div class="flex items-start mb-4">
                        <img src="https://placehold.co/80x80/fecaca/dc2626?text=Bag" alt="Product Image" class="w-20 h-20 rounded-md mr-4 flex-shrink-0">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Lorem ipsum dolor sit amet</h3>
                            <div class="flex items-center mb-2 star-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="ml-2 text-sm text-gray-600">(5.0)</span>
                            </div>
                            <p class="text-sm text-gray-500">Reviewed on Feb 15, 2025</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="flex space-x-4">
                        <button class="px-4 py-2 bg-blue-50 text-blue-600 border border-blue-600 rounded-lg font-semibold hover:bg-blue-100 transition duration-200">
                            Edit Review
                        </button>
                        <button class="px-4 py-2 bg-red-50 text-red-600 border border-red-600 rounded-lg font-semibold hover:bg-red-100 transition duration-200">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section id="addresses" class="content-section hidden">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">My Addresses</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md border-2 border-blue-500">
                    <h3 class="font-semibold text-gray-800 mb-2">Default Address</h3>
                    <address class="text-gray-700 not-italic mb-4">
                        123 Main Street<br>
                        Apt 4B<br>
                        Springfield, IL 62701<br>
                        United States
                    </address>
                    <div class="flex space-x-2">
                        <button class="px-4 py-2 bg-blue-50 text-blue-600 border border-blue-600 rounded-lg font-semibold hover:bg-blue-100 transition duration-200">
                            Edit
                        </button>
                        <button class="px-4 py-2 bg-red-50 text-red-600 border border-red-600 rounded-lg font-semibold hover:bg-red-100 transition duration-200">
                            Remove
                        </button>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-center items-center text-gray-500 text-center border-dashed border-2 border-gray-300 hover:bg-gray-50 cursor-pointer">
                    <i class="fas fa-plus-circle text-4xl mb-2"></i>
                    <p class="font-semibold">Add New Address</p>
                </div>
            </div>
        </section>

        <section id="accountSettings" class="content-section hidden">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Account Settings</h1>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" id="firstName" value="<?= esc($user->first_name ?? 'Grace') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" id="lastName" value="<?= esc($user->last_name ?? 'Reyes') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" value="<?= esc($user->email ?? 'grace.reyes@example.com') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                    </div>
                    <div class="flex space-x-2">
                        <button id="editProfileBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                            Update Profile
                        </button>
                        <button id="saveChangesBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition duration-200 hidden">
                            Save Changes
                        </button>
                        <button id="cancelEditBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition duration-200 hidden">
                            Cancel
                        </button>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Password Settings</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" id="currentPassword" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                        </div>
                        <div>
                            <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" id="newPassword" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                        </div>
                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" id="confirmPassword" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                        </div>
                    </div>
                    <div class="flex space-x-2 mt-4">
                        <button id="editPasswordBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                            Update Password
                        </button>
                        <button id="savePasswordBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition duration-200 hidden">
                            Save Changes
                        </button>
                        <button id="cancelPasswordEditBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition duration-200 hidden">
                            Cancel
                        </button>
                    </div>
                </div>
                <hr class="my-6 border-gray-200">
            </div>
        </section>
        <section id="helpCenter" class="content-section hidden">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Help Center</h1>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-700 mb-4">Welcome to the Help Center. How can we assist you today?</p>
                <div class="relative mb-6">
                    <input type="text" placeholder="Search for answers..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition duration-200 cursor-pointer">
                        <h4 class="font-semibold text-gray-800 mb-2">Frequently Asked Questions</h4>
                        <p class="text-gray-600 text-sm">Find quick answers to common questions.</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition duration-200 cursor-pointer">
                        <h4 class="font-semibold text-gray-800 mb-2">Contact Support</h4>
                        <p class="text-gray-600 text-sm">Get in touch with our support team.</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition duration-200 cursor-pointer">
                        <h4 class="font-semibold text-gray-800 mb-2">Shipping & Delivery</h4>
                        <p class="text-gray-600 text-sm">Information about your order's journey.</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition duration-200 cursor-pointer">
                        <h4 class="font-semibold text-gray-800 mb-2">Returns & Refunds</h4>
                        <p class="text-gray-600 text-sm">Learn about our return policy.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<div id="photoModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeModal">&times;</span>
        <h2 class="text-xl font-semibold mb-4">Change Profile Photo</h2>
        <button id="addPhotoOption" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200 mb-3">
            Add Photo
        </button>
        <button id="removePhotoOption" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition duration-200">
            Remove Photo
        </button>
    </div>
</div>

<script src="main.js"></script>

</body>
</html>