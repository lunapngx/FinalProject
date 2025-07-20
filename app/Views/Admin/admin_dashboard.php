<?= $this->extend('layout/admin_master') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <div class="content-header" style="display: none;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= url_to('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div></div></div></div>
        <section class="content" style="padding-top: 0;">
            <div class="container-fluid">
                <div class="top-navbar-container">
                    <div class="logo-container">
                        <img src="/img/meraki-logo.png" alt="Meraki Gift Shop Logo" class="meraki-logo">
                    </div>
                    <div class="search-bar-container">
                        <input type="text" placeholder="Search...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="nav-icons-container">
                        <a href="#"><i class="far fa-user"></i></a>
                        <a href="#"><i class="far fa-heart"></i></a>
                        <a href="#"><i class="fas fa-shopping-cart"></i></a>
                    </div>
                </div>
                <nav class="main-navigation">
                    <ul>
                        <li><a href="<?= url_to('admin_dashboard') ?>">HOME</a></li>
                        <li><a href="<?= url_to('admin_products') ?>">PRODUCTS</a></li>
                        <li><a href="<?= url_to('admin_orders') ?>">ORDERS</a></li>
                        <li><a href="<?= url_to('admin_users') ?>">CUSTOMERS</a></li>
                        <li><a href="#">SALES REPORT</a></li>
                    </ul>
                </nav>
                <div class="dashboard-content-area">
                    <div class="row info-cards-row">
                        <div class="col-lg-3 col-6">
                            <div class="info-card">
                                <div class="inner">
                                    <p>TOTAL SALES</p>
                                    <h3>₱ <?= esc(number_format($total_sales ?? 0, 2)) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info-card">
                                <div class="inner">
                                    <p>WEEKLY ORDERS</p>
                                    <h3><?= esc($weekly_orders ?? 0) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info-card">
                                <div class="inner">
                                    <p>CUSTOMERS</p>
                                    <h3><?= esc($total_customers ?? 0) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info-card">
                                <div class="inner">
                                    <p>PRODUCTS</p>
                                    <h3><?= esc($total_products ?? 0) ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-display-section row">
                        <div class="col-md-6">
                            <div class="product-item">
                                <img src="/img/product1.png" alt="Product 1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-item">
                                <img src="/img/product2.png" alt="Product 2">
                            </div>
                        </div>
                    </div>
                </div>
            </div></section>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            overflow-x: hidden; /* Prevent horizontal scroll due to borders */
        }

        .content-wrapper {
            background-color: #fff;
            margin-left: 0; /* Override AdminLTE default margin */
            padding: 0; /* Remove default padding */
            min-height: 100vh;
            position: relative;
        }

        /* Custom Header and Navigation */
        .top-navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #5C3A3A; /* Dark brown from image */
            color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .logo-container .meraki-logo {
            height: 60px; /* Adjust as needed */
        }

        .search-bar-container {
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 20px;
            padding: 5px 15px;
            width: 400px; /* Adjust width as needed */
        }

        .search-bar-container input {
            border: none;
            outline: none;
            padding: 5px 10px;
            flex-grow: 1;
        }

        .search-bar-container button {
            background: none;
            border: none;
            color: #5C3A3A;
            cursor: pointer;
            font-size: 16px;
            padding-left: 10px;
        }

        .nav-icons-container a {
            color: #fff;
            margin-left: 20px;
            font-size: 20px;
        }

        .main-navigation {
            background-color: #5C3A3A; /* Dark brown from image */
            padding: 10px 20px;
            border-bottom: 2px solid #ddd; /* Separator line */
        }

        .main-navigation ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-start; /* Align to the left */
            gap: 30px; /* Space between navigation items */
        }

        .main-navigation ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 0;
            transition: color 0.3s ease;
        }

        .main-navigation ul li a:hover {
            color: #f0f0f0;
        }

        .dashboard-content-area {
            padding: 20px;
            background-color: #fff; /* White background for the main content */
        }

        /* Info Cards Styling */
        .info-cards-row {
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-card {
            background-color: #fff;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 8px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 120px; /* Ensure consistent height */
            margin-bottom: 20px; /* Spacing between cards in smaller views */
        }

        .info-card .inner h3 {
            font-size: 32px;
            margin: 5px 0;
            color: #5C3A3A; /* Dark brown for numbers */
        }

        .info-card .inner p {
            font-size: 14px;
            color: #888;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Product Display Section */
        .product-display-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Space between product items */
            justify-content: center; /* Center the product items */
            position: relative; /* For background borders */
            padding: 0 60px; /* Padding for the floral borders */
            overflow: hidden; /* Hide overflow of floral images */
        }

        .product-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 100%; /* Full width for small screens */
            max-width: 48%; /* For two columns */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .product-item img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Floral borders */
        .dashboard-content-area::before,
        .dashboard-content-area::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            width: 50px; /* Width of the floral border */
            background-repeat: repeat-y;
            background-size: contain;
            z-index: 1; /* Ensure it's above other content if needed, but below dashboard content */
        }

        .dashboard-content-area::before {
            left: 0;
            background-image: url('/img/left-flower-border.png'); /* Replace with your left floral image path */
        }

        .dashboard-content-area::after {
            right: 0;
            background-image: url('/img/right-flower-border.png'); /* Replace with your right floral image path */
        }

        /* Adjust content padding to accommodate borders */
        .dashboard-content-area {
            position: relative; /* For pseudo-elements positioning */
            padding: 20px 70px; /* Adjust padding to make space for borders */
            box-sizing: border-box; /* Include padding in element's total width and height */
        }

        /* Ensure .dashboard-content-area has a defined height or minimum height
           so the pseudo-elements have something to extend along */
        .dashboard-content-area {
            min-height: 500px; /* Example, adjust as needed */
        }


        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .col-lg-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 767.98px) {
            .top-navbar-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-bar-container {
                width: 100%;
                margin-top: 10px;
            }

            .nav-icons-container {
                margin-top: 10px;
                width: 100%;
                display: flex;
                justify-content: space-around;
            }

            .main-navigation ul {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .product-item {
                max-width: 100%; /* Full width on small screens */
            }

            .dashboard-content-area::before,
            .dashboard-content-area::after {
                width: 30px; /* Smaller borders on small screens */
            }

            .dashboard-content-area {
                padding: 20px 40px; /* Adjust padding for smaller borders */
            }
        }

        @media (max-width: 575.98px) {
            .col-lg-3, .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
<?= $this->endSection() ?>