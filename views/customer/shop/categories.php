<?php require_once 'views/layouts/customer_header.php'; ?>

<div class="home-layout">

    <!-- SIDEBAR (Optional, but keeping consistent layout) -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <main class="main-content">

        <!-- Page Header -->
        <div class="section-header" style="margin-top: 20px;">
            <div>
                <div style="font-size: 11px; color: #888; margin-bottom: 5px;">Home > Categories</div>
                <h1 style="font-size: 24px; font-weight: 800;">Categories</h1>
                <p style="font-size: 13px; color: #666;">Our Product Range</p>
            </div>
            <!-- Search Icon or other actions could go here if needed -->
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