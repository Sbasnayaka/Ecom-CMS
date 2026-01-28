<?php
$hide_mobile_header = true; // Hides the global 'Welcome' header
require_once 'views/layouts/customer_header.php';
?>

<div class="home-layout">

    <!-- SIDEBAR -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <main class="main-content">

        <!-- Figma Header: Back | Categories | Search+Avatar -->
        <div class="mobile-header d-lg-none"
            style="display: flex; align-items: center; justify-content: space-between; padding: 20px 0; margin-bottom: 10px;">

            <!-- Left: Back Button & Title Group -->
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="<?= BASE_URL ?>" class="back-btn"
                    style="width: 35px; height: 35px; background: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-chevron-left" style="font-size: 14px;"></i>
                </a>
                <div>
                    <h1 style="font-size: 24px; font-weight: 800; line-height: 1.2; margin: 0;">Categories</h1>
                    <p style="font-size: 13px; color: #666; margin: 0;">Our Product Range</p>
                </div>
            </div>

            <!-- Right: Search & Avatar -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <!-- Search Button (Light Purple Square) -->
                <a href="<?= BASE_URL ?>shop/index"
                    style="width: 40px; height: 40px; background: #ede7f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #5e35b1;">
                    <i class="fas fa-search" style="font-size: 18px;"></i>
                </a>

                <!-- Shop Avatar -->
                <?php
                // Reusing logo logic from header
                $logoUrl = $settings['shop_logo'] ?? '';
                $logoUrl = str_replace('/Ecom-CMS/', BASE_URL, $logoUrl);
                $logo = (!empty($logoUrl)) ? $logoUrl : 'https://via.placeholder.com/40';
                ?>
                <img src="<?= $logo ?>" alt="Logo"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            </div>

        </div>

        <!-- Categories Grid -->
        <div class="product-grid"
            style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; padding: 0 0 40px 0;">
            <?php foreach ($categories as $cat): ?>
                <a href="<?= BASE_URL ?>shop/category/<?= $cat['id'] ?>" class="cat-grid-item"
                    style="display: block; text-align: center;">
                    <?php
                    $catPath = 'assets/uploads/' . $cat['image'];
                    $img = (!empty($cat['image']) && file_exists(ROOT_PATH . $catPath))
                        ? BASE_URL . $catPath
                        : 'https://via.placeholder.com/150?text=' . urlencode($cat['name']);
                    ?>
                    <div
                        style="border-radius: 20px; overflow: hidden; aspect-ratio: 1/1; margin-bottom: 10px; background: #f0f0f0;">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($cat['name']) ?>"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="font-weight: 700; font-size: 14px; text-align: left; color: #000;">
                        <?= htmlspecialchars($cat['name']) ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>