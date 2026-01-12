<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($title) ? $title : 'Ecom Shop' ?>
    </title>
    <!-- Use the new Customer CSS -->
    <link rel="stylesheet" href="/Ecom-CMS/assets/css/customer.css">
    <!-- Font Awesome for Icons (Optional, or use images) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <!-- Mobile Header (Visible only on Mobile) -->
    <div class="mobile-header d-lg-none" style="display: none;"> <!-- CSS handles display, adding ID for logic -->
        <div class="welcome-text">
            <h1>Welcome!</h1>
            <p>
                <?= isset($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Our Shop' ?>
            </p>
        </div>
        <div>
            <!-- Shop Avatar/Logo -->
            <?php
            $logo = isset($settings['shop_logo']) && !empty($settings['shop_logo'])
                ? '/Ecom-CMS/assets/uploads/' . $settings['shop_logo']
                : 'https://via.placeholder.com/40';
            ?>
            <img src="<?= $logo ?>" class="shop-avatar" alt="Shop Logo">
        </div>
    </div>

    <!-- Desktop Header (Visible only on Desktop) -->
    <header class="desktop-header display-desktop-only">
        <div class="header-inner">
            <div class="logo-area">
                <?php
                $logo = isset($settings['shop_logo']) && !empty($settings['shop_logo'])
                    ? '/Ecom-CMS/assets/uploads/' . $settings['shop_logo']
                    : 'https://via.placeholder.com/50';
                ?>
                <div style="display:flex; align-items:center; gap:10px;">
                    <img src="<?= $logo ?>" alt="Logo"
                        style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <h2 style="margin:0; font-size: 18px;">
                            <?= isset($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Shop Name' ?>
                        </h2>
                    </div>
                </div>
            </div>

            <div class="search-bar">
                <input type="text" placeholder="Search..." class="search-input">
                <i class="fas fa-search" style="position: absolute; right: 15px; top: 12px; color: #aaa;"></i>
            </div>

            <div class="header-actions">
                <button class="cat-btn"><i class="fas fa-bars"></i> Categories</button>
                <div style="position: relative; cursor: pointer;">
                    <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                    <span
                        style="position: absolute; top: -5px; right: -10px; background: red; color: white; border-radius: 50%; padding: 2px 5px; font-size: 10px;">3</span>
                    <span style="font-size: 14px; margin-left: 5px;">Cart</span>
                </div>
                <button class="btn-red">Sale Items</button>
            </div>
        </div>
    </header>

    <div class="container main-wrapper">