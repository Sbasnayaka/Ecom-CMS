<?php require_once 'views/layouts/customer_header.php'; ?>

<!-- Mobile Welcome Block (Moved here or kept in header, keeping here ensures it is part of flow) -->
<!-- Actually handled in Header for global presence, but specific to Home? 
     Design shows it at top. Header has it. Good. -->

<div class="home-layout">

    <?php
    // Organize Categories into Tree
    $categoryTree = [];
    // First pass: Main categories
    foreach ($categories as $cat) {
        if (empty($cat['parent_id'])) {
            $categoryTree[$cat['id']] = $cat;
            $categoryTree[$cat['id']]['children'] = [];
        }
    }
    // Second pass: Subcategories
    foreach ($categories as $cat) {
        if (!empty($cat['parent_id']) && isset($categoryTree[$cat['parent_id']])) {
            $categoryTree[$cat['parent_id']]['children'][] = $cat;
        }
    }
    ?>

    <!-- DESKTOP SIDEBAR (Visible only on Desktop) -->
    <aside class="sidebar display-desktop-only">
        <div class="filter-group">
            <span class="filter-title">Filter by Price,</span>
            <div style="display: flex; gap: 10px;">
                <input type="text" placeholder="Min"
                    style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <input type="text" placeholder="Max"
                    style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <div class="filter-group">
            <span class="filter-title">Filter by Category</span>
            <?php foreach ($categoryTree as $mainCat): ?>
                <label class="checkbox-label">
                    <input type="checkbox">
                    <strong><?= htmlspecialchars($mainCat['name']) ?></strong>
                </label>
                <?php if (!empty($mainCat['children'])): ?>
                    <div style="margin-left: 10px; display: flex; flex-direction: column;">
                        <?php foreach ($mainCat['children'] as $childCat): ?>
                            <label class="checkbox-label" style="font-size: 12px; color: #777;">
                                <input type="checkbox">
                                -- <?= htmlspecialchars($childCat['name']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Shop Info Box -->
        <div class="shop-info-box">
            <div class="shop-info-title">
                <?= !empty($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Dark Lavender Clothing' ?>
            </div>
            <div class="shop-desc">
                Tailored to your tastes...<br><br>
                No: 213/7, Ghanawimala Mw,<br>
                Hewagama, Kaduwela.<br><br>
                076 260 00 00 / 077 255 55 55<br>
                info@darklavender.com
            </div>

            <button class="btn-review">Give us a Review!</button>

            <div class="social-icons">
                <img src="/Ecom-CMS/assets/icons/facebook.png" alt="FB" class="social-icon-img">
                <img src="/Ecom-CMS/assets/icons/tiktok.png" alt="TikTok" class="social-icon-img">
                <img src="/Ecom-CMS/assets/icons/instagram.png" alt="IG" class="social-icon-img">
                <img src="/Ecom-CMS/assets/icons/youtube.png" alt="YT" class="social-icon-img">
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">

        <!-- Top Categories (Mobile Horizontal Scroll / Desktop Grid?) -->
        <div class="section-header">
            <h2 class="section-title">Top Categories</h2>
            <a href="/Ecom-CMS/shop" class="view-all">View All</a>
        </div>

        <div class="categories-scroll">
            <?php foreach ($categories as $cat): ?>
                <div class="cat-item">
                    <?php
                    $catPath = 'assets/uploads/' . ($cat['image'] ?? '');
                    $img = (!empty($cat['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/Ecom-CMS/' . $catPath))
                        ? '/Ecom-CMS/' . $catPath
                        : 'https://via.placeholder.com/80?text=' . urlencode($cat['name']);
                    ?>
                    <img src="<?= $img ?>" class="cat-img" alt="<?= htmlspecialchars($cat['name']) ?>">
                    <div class="cat-name">
                        <?= htmlspecialchars($cat['name']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Featured Products -->
        <?php if (!empty($featuredProducts)): ?>
            <div class="section-header">
                <h2 class="section-title">Featured Products <span class="tag special">SPECIAL</span></h2>
            </div>
            <div class="products-scroll">
                <?php foreach ($featuredProducts as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Latest Products -->
        <div class="section-header">
            <h2 class="section-title">Latest Products <span class="tag new">NEW</span></h2>
        </div>
        <div class="products-scroll">
            <?php foreach ($latestProducts as $prod): ?>
                <?php include 'views/customer/partials/product_card.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- Sale Products -->
        <?php if (!empty($saleProducts)): ?>
            <div class="section-header">
                <h2 class="section-title">Sale Products <span class="tag sale">Sale..!</span></h2>
            </div>
            <div class="products-scroll">
                <?php foreach ($saleProducts as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>