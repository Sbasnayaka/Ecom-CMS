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

    <!-- Dynamic Global Styles -->
    <style>
        :root {
            /* Fallback to CSS file defaults if DB is empty, otherwise override */
            <?php if (!empty($settings['primary_color'])): ?>
                --primary-color:
                    <?= $settings['primary_color'] ?>
                ;
            <?php endif; ?>

            <?php if (!empty($settings['bg_color'])): ?>
                /* --bg-white: <?= $settings['bg_color'] ?>
                ;
                */
                /* Note: User screenshot shows white card bg, but maybe body is lavender? 
                                       Safe to keep body white for now as per "UI design" request unless user sets it explicitly.
                                       Let's trust the CSS default for "clean white" look matching screenshot. */
            <?php endif; ?>

            <?php if (!empty($settings['font_family'])): ?>
                --font-family: '<?= $settings['font_family'] ?>', sans-serif;
            <?php endif; ?>
        }

        body {
            <?php if (!empty($settings['font_family'])): ?>
                font-family: var(--font-family);
            <?php endif; ?>
        }
    </style>
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
            // Settings store full web path (e.g. /Ecom-CMS/assets/uploads/logo.png)
            $logoUrl = $settings['shop_logo'] ?? '';

            // Construct physical path for check: Root + LogoUrl
            $physicalPath = $_SERVER['DOCUMENT_ROOT'] . $logoUrl;

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
    </header>

    <div class="container main-wrapper">