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
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">

        <!-- Top Categories (Mobile Horizontal Scroll / Desktop Grid?) -->
        <div class="section-header">
            <h2 class="section-title">Top Categories</h2>
            <a href="<?= BASE_URL ?>shop/categories" class="view-all">View All</a>
        </div>

        <div class="categories-scroll">
            <?php foreach ($categories as $cat): ?>
                <div class="cat-item">
                    <?php
                    $catPath = 'assets/uploads/' . $cat['image'];
                    $img = (!empty($cat['image']) && file_exists(ROOT_PATH . $catPath))
                        ? BASE_URL . $catPath
                        : 'https://via.placeholder.com/60?text=' . urlencode($cat['name']);
                    ?>
                    <img src="<?= $img ?>" class="cat-img" alt="<?= htmlspecialchars($cat['name']) ?>">
                    <div class="cat-name">
                        <?= htmlspecialchars($cat['name']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Mobile Layout: Vertical Scroll (Hidden on Desktop) -->
        <div class="display-mobile-only d-lg-none">
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
        </div>

        <!-- Desktop Layout: Tabs (Visible only on Desktop) -->
        <div class="display-desktop-only d-none d-lg-block desktop-tabs-container" style="margin-top: 30px;">

            <!-- Tab Navigation -->
            <div class="desktop-tabs-nav"
                style="display: flex; gap: 20px; border-bottom: 2px solid #eee; margin-bottom: 20px;">
                <button class="tab-btn active" onclick="switchDesktopTab(event, 'tab-new')"
                    style="padding: 10px 20px; border: none; background: none; font-size: 16px; font-weight: 700; cursor: pointer; border-bottom: 3px solid transparent;">Newly
                    Released</button>
                <button class="tab-btn" onclick="switchDesktopTab(event, 'tab-featured')"
                    style="padding: 10px 20px; border: none; background: none; font-size: 16px; font-weight: 700; cursor: pointer; border-bottom: 3px solid transparent;">Featured</button>
                <button class="tab-btn" onclick="switchDesktopTab(event, 'tab-sale')"
                    style="padding: 10px 20px; border: none; background: none; font-size: 16px; font-weight: 700; cursor: pointer; border-bottom: 3px solid transparent;">Sale
                    / Discounts</button>
            </div>

            <!-- Tab Content: New Arrivals -->
            <div id="tab-new" class="tab-content active"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                <?php foreach ($latestProducts as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>

            <!-- Tab Content: Featured -->
            <div id="tab-featured" class="tab-content"
                style="display: none; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No featured products found.</p>
                <?php endif; ?>
            </div>

            <!-- Tab Content: Sale -->
            <div id="tab-sale" class="tab-content"
                style="display: none; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                <?php if (!empty($saleProducts)): ?>
                    <?php foreach ($saleProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No sale products found.</p>
                <?php endif; ?>
            </div>

        </div>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>