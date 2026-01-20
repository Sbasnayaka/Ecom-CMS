<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($title) ? $title : 'Ecom Shop' ?>
    </title>
    <!-- Use the new Customer CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/customer.css?v=<?= time() ?>">
    <!-- Font Awesome for Icons (Optional, or use images) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Dynamic Global Styles -->
    <style>
        :root {
            /* Core Colors */
            <?php if (!empty($settings['primary_color'])): ?>
                --primary-color:
                    <?= $settings['primary_color'] ?>
                ;
            <?php endif; ?>

            <?php if (!empty($settings['secondary_color'])): ?>
                --secondary-color:
                    <?= $settings['secondary_color'] ?>
                ;
            <?php endif; ?>

            <?php if (!empty($settings['bg_color'])): ?>
                --bg-white:
                    <?= $settings['bg_color'] ?>
                ;
            <?php endif; ?>

            /* Typography */
            <?php if (!empty($settings['font_family'])): ?>
                --font-family: '<?= $settings['font_family'] ?>', sans-serif;
            <?php endif; ?>

            <?php if (!empty($settings['body_color'])): ?>
                --text-dark:
                    <?= $settings['body_color'] ?>
                ;
            <?php endif; ?>

            /* UI Elements */
            <?php if (!empty($settings['global_img_radius'])): ?>
                --border-radius:
                    <?= $settings['global_img_radius'] ?>
                    px;
            <?php endif; ?>
        }

        body {
            <?php if (!empty($settings['font_family'])): ?>
                font-family: var(--font-family);
            <?php endif; ?>
            <?php if (!empty($settings['body_size'])): ?>
                font-size:
                    <?= $settings['body_size'] ?>
                    px;
            <?php endif; ?>
            <?php if (!empty($settings['body_line_height'])): ?>
                line-height:
                    <?= $settings['body_line_height'] ?>
                ;
            <?php endif; ?>
        }

        h1,
        h2,
        h3,
        .section-title,
        .pd-title {
            <?php if (!empty($settings['h1_color'])): ?>
                color:
                    <?= $settings['h1_color'] ?>
                    !important;
            <?php endif; ?>
        }

        <?php if (!empty($settings['h1_size'])): ?>
            h1,
            .pd-title {
                font-size:
                    <?= $settings['h1_size'] ?>
                    px !important;
            }

        <?php endif; ?>

        /* Button Overrides */
        <?php if (!empty($settings['btn_bg_color'])): ?>
            .btn-cart,
            .btn-action,
            .add-btn-blue,
            .btn-red {
                background-color:
                    <?= $settings['btn_bg_color'] ?>
                    !important;
            }

        <?php endif; ?>

        <?php if (!empty($settings['btn_text_color'])): ?>
            .btn-cart,
            .btn-action,
            .add-btn-blue,
            .btn-red {
                color:
                    <?= $settings['btn_text_color'] ?>
                    !important;
            }

        <?php endif; ?>

        <?php if (!empty($settings['btn_radius'])): ?>
            .btn-cart,
            .btn-action,
            .add-btn-blue,
            .btn-red {
                border-radius:
                    <?= $settings['btn_radius'] ?>
                    px !important;
            }

        /* Navigation Styling Overrides */
        <?php if (!empty($settings['mobile_nav_bg'])): ?>
        .bottom-nav {
            background-color: <?= $settings['mobile_nav_bg'] ?> !important;
        }
        <?php endif; ?>
        
        <?php if (!empty($settings['mobile_nav_item_color'])): ?>
        .nav-item {
            color: <?= $settings['mobile_nav_item_color'] ?> !important;
        }
        <?php endif; ?>

        <?php if (!empty($settings['desktop_header_bg'])): ?>
        .desktop-header {
            background-color: <?= $settings['desktop_header_bg'] ?> !important;
        }
        <?php endif; ?>

        <?php if (!empty($settings['desktop_nav_link_color'])): ?>
        .desktop-nav-links a {
            color: <?= $settings['desktop_nav_link_color'] ?> !important;
        }
        .header-inner .logo-area, .header-inner h2 {
             color: <?= $settings['desktop_nav_link_color'] ?> !important;
        }
        <?php endif; ?>

    </style>
    <!-- Dynamic Google Font Loader -->
    <?php
    if (!empty($settings['font_family'])) {
        $font = $settings['font_family'];
        // Handle spaces for URL
        $fontUrl = urlencode($font);
        echo "<link href='https://fonts.googleapis.com/css2?family={$fontUrl}:wght@300;400;600;700;800&display=swap' rel='stylesheet'>";
    }
    ?>
</head>

<body>

    <!-- Mobile Header (Visible only on Mobile) -->
    <div class="mobile-header d-lg-none"> <!-- CSS handles display, adding ID for logic -->
        <div class="welcome-text">
            <h1>Welcome!</h1>
            <p>
                <?= !empty($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Dark Lavender Clothing!' ?>
            </p>
        </div>
        <div>
            <!-- Shop Avatar/Logo -->
            <?php
            $logoUrl = $settings['shop_logo'] ?? '';
            // If logo url has /Ecom-CMS/ prefix, we might need to strip it if storing relative
            // But if stored as /Ecom-CMS/assets/..., we should be careful. 
            // For now, assuming $settings['shop_logo'] saves the full web path.
            // BETTER PRACTICE: Save relative path 'assets/uploads/...' in DB.
            // FIX: If path starts with /Ecom-CMS/, replace with BASE_URL dynamic
            $logoUrl = str_replace('/Ecom-CMS/', BASE_URL, $logoUrl);

            // Construct physical path for check: Root + LogoUrl
            $physicalPath = $_SERVER['DOCUMENT_ROOT'] . $logoUrl;
            // Note: On some setups DOCUMENT_ROOT + /Ecom-CMS/ might duplicate if alias used?
            // Safer: ROOT_PATH . 'assets/...' if we can parse it.
            // Minimal Change: JUST fix the /Ecom-CMS/ part in the URL for display.
            
            $logo = (!empty($logoUrl) && file_exists($physicalPath))
                ? $logoUrl
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
                // Use same logic as mobile
                $logoUrl = $settings['shop_logo'] ?? '';
                $logoUrl = str_replace('/Ecom-CMS/', BASE_URL, $logoUrl);
                $physicalPath = $_SERVER['DOCUMENT_ROOT'] . $logoUrl;

                $logo = (!empty($logoUrl) && file_exists($physicalPath))
                    ? $logoUrl
                    : 'https://via.placeholder.com/50';
                ?>
                <div style="display:flex; align-items:center; gap:10px;">
                    <img src="<?= $logo ?>" alt="Logo"
                        style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <h2 style="margin:0; font-size: 18px;">
                            <?= !empty($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Dark Lavender Clothing!' ?>
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

        <!-- Secondary Nav Links -->
        <div class="desktop-nav-links">
            <a href="<?= BASE_URL ?>">Home Page</a>
            <a href="<?= BASE_URL ?>latest">Newly Released Products</a>
            <a href="<?= BASE_URL ?>featured">Featured Products</a>
            <a href="<?= BASE_URL ?>sale">Sale! Sale! (Discounts)</a>
        </div>
    </header>

    <div class="container main-wrapper">