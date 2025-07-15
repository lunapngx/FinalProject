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
                        <button class="header-action-btn" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i>
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <h6>Welcome to <span class="sitename">Meraki Shop</span></h6>
                            </div>
                            <div class="dropdown-body">
                                <?php if (auth()->loggedIn()): ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('account') ?>">
                                        <i class="bi bi-person-circle me-2"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('account/orders') ?>">
                                        <i class="bi bi-bag-check me-2"></i>
                                        <span>My Orders</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('account') ?>">
                                        <i class="bi bi-heart me-2"></i>
                                        <span>My Wishlist</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('account') ?>">
                                        <i class="bi bi-gear me-2"></i>
                                        <span>Settings</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <<div class="dropdown-footer">
                                <?php if (auth()->loggedIn()): ?>
                                    <li><a href="#" class="profile-icon"><img src="https://via.placeholder.com/30" alt="Profile"></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="user-name"><?= session()->get('user_name') ?></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= url_to('account') ?>">My Profile</a></li>
                                            <li><a class="dropdown-item" href="<?= url_to('account_orders') ?>">My Orders</a></li>
                                            <li><a class="dropdown-item" href="<?= url_to('account_wishlist') ?>">My Wishlist</a></li>
                                            <li><a class="dropdown-item" href="<?= url_to('logout') ?>">Logout</a></li>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    <li><a href="<?= base_url('login') ?>">Sign In</a></li>
                                    <li><a href="<?= base_url('register') ?>">Register</a></li>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <a href="<?= base_url('Wishlist') ?>" class="header-action-btn d-none d-md-block">
                        <i class="bi bi-heart"></i>
                        <span class="badge"></span>
                    </a>

                    <a href="<?= base_url('Cart') ?>" class="header-action-btn">
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