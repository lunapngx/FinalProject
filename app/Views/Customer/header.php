<header id="header" class="header position-relative">
    <div class="top-bar py-2">
        <div class="container-fluid container-xl">
            <div class="row align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="d-flex justify-content-end">
                        <div class="top-bar-item dropdown me-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-header">
        <div class="container-fluid container-xl">
            <div class="d-flex py-3 align-items-center justify-content-between">

                <a href="<?= base_url('/') ?>" class="logo d-flex align-items-center">
                    <h1 class="sitename">Meraki Shop</h1>
                </a>

                <form class="search-form desktop-search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <button class="btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <div class="header-actions d-flex align-items-center justify-content-end">

                    <button class="header-action-btn mobile-search-toggle d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch" aria-expanded="false" aria-controls="mobileSearch">
                        <i class="bi bi-search"></i>
                    </button>

                    <div class="dropdown account-dropdown">
                        <button class="header-action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header">
                                <h6>Welcome to <span class="sitename">Meraki Shop</span></h6>
                            </div>
                            <div class="dropdown-body">
                                <?php if (auth()->loggedIn()): ?>
                                <a class="dropdown-item d-flex align-items-center" href="<?= url_to('account_profile') ?>">
                                    <i class="bi bi-person-circle me-2"></i>
                                    <span>My Profile</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="<?= url_to('account_orders') ?>">
                                    <i class="bi bi-bag-check me-2"></i>
                                    <span>My Orders</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="<?= url_to('account_profile') ?>#wishlist">
                                    <i class="bi bi-heart me-2"></i>
                                    <span>My Wishlist</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="<?= url_to('account_settings') ?>">
                                    <i class="bi bi-gear me-2"></i>
                                    <span>Settings</span>
                                    <?php endif; ?>
                            </div>
                            <div class="dropdown-footer">
                                <?php if (auth()->loggedIn()): ?>
                                    <?php if (auth()->user() && auth()->user()->inGroup('admin')): ?>
                                        <a href="<?= url_to('admin_dashboard') ?>" class="btn btn-warning w-100 mb-2">Admin Dashboard</a>
                                    <?php endif; ?>
                                    <a href="<?= url_to('logout') ?>" class="btn btn-outline-danger w-100">Logout</a>
                                <?php else: ?>
                                    <!-- These buttons only show when NOT logged in -->
                                    <a href="<?= url_to('login') ?>" class="btn btn-primary w-100 mb-2">Sign In</a>
                                    <a href="<?= url_to('register') ?>" class="btn btn-outline-primary w-100">Register</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <a href="<?= url_to('account_profile') ?>#wishlist" class="header-action-btn d-none d-md-block">
                        <i class="bi bi-heart"></i>
                        <span class="badge"></span>
                    </a>

                    <a href="<?= url_to('cart_view') ?>" class="header-action-btn">
                        <i class="bi bi-cart3"></i>
                        <span class="badge"></span>
                    </a>

                    <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>

                </div>
            </div>
        </div>
    </div>

    <div class="header-nav">
        <div class="container-fluid container-xl">
            <div class="position-relative">
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="<?= base_url('/') ?>" class="active">Home</a></li>
                        <li><a href="<?= base_url('about') ?>">About</a></li>
                        <li><a href="<?= url_to('categories_list') ?>">Category</a></li>
                        <li><a href="<?= url_to('cart_view') ?>">Cart</a></li>
                        <li><a href="<?= url_to('checkout_view') ?>">Checkout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="collapse" id="mobileSearch">
        <div class="container">
            <form class="search-form">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
                    <button class="btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

</header>
