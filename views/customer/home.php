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

        <!-- --- MOBILE SECTIONS (Vertical Scroll) --- -->
        <div class="d-lg-none">
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

        <!-- --- DESKTOP TABS (Horizontal Grid) --- -->
        <div class="d-none d-lg-block desktop-tabs-container" style="margin-top: 40px;">

            <!-- Tab Navigation -->
            <div class="tabs-nav" style="display: flex; gap: 20px; border-bottom: 2px solid #eee; margin-bottom: 30px;">
                <button class="tab-btn active" onclick="switchTab('tab-new')"
                    style="padding: 10px 20px; background: none; border: none; font-size: 18px; font-weight: 700; cursor: pointer; border-bottom: 3px solid transparent;">
                    Newly Released products
                </button>
                <button class="tab-btn" onclick="switchTab('tab-featured')"
                    style="padding: 10px 20px; background: none; border: none; font-size: 18px; font-weight: 700; cursor: pointer; border-bottom: 3px solid transparent; color: #aaa;">
                    Featured Products
                </button>
                <button class="tab-btn" onclick="switchTab('tab-sale')"
                    style="padding: 10px 20px; background: none; border: none; font-size: 18px; font-weight: 700; cursor: pointer; border-bottom: 3px solid transparent; color: #aaa;">
                    Sale! Sale! (Discounts)
                </button>
            </div>

            <!-- Tab Content: New Arrivals -->
            <div id="tab-new" class="tab-content" style="display: block;">
                <div class="product-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <?php foreach ($latestProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tab Content: Featured -->
            <div id="tab-featured" class="tab-content" style="display: none;">
                <div class="product-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <?php foreach ($featuredProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tab Content: Sale -->
            <div id="tab-sale" class="tab-content" style="display: none;">
                <div class="product-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <?php foreach ($saleProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>