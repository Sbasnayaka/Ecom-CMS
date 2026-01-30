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

        <!-- --- MOBILE VIEW (Vertical Scroll) --- -->
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

        <!-- --- DESKTOP VIEW (Tabs Format) --- -->
        <div class="d-none d-lg-block" style="margin-top: 30px;">
            
            <!-- Tabs Navigation -->
            <div class="desktop-tabs" style="
                display: flex; 
                gap: 30px; 
                border-bottom: 2px solid #eee; 
                margin-bottom: 30px;
                padding-left: 10px;
            ">
                <div class="tab-btn active" onclick="switchTab('new', this)" style="
                    padding-bottom: 15px; cursor: pointer; font-weight: 700; color: #000; border-bottom: 3px solid #000;
                    font-size: 18px;
                ">Newly Released</div>
                
                <div class="tab-btn" onclick="switchTab('featured', this)" style="
                    padding-bottom: 15px; cursor: pointer; font-weight: 600; color: #888; border-bottom: 3px solid transparent;
                    font-size: 18px;
                ">Featured Products</div>
                
                <div class="tab-btn" onclick="switchTab('sale', this)" style="
                    padding-bottom: 15px; cursor: pointer; font-weight: 600; color: #888; border-bottom: 3px solid transparent;
                    font-size: 18px;
                ">Sale Items</div>
            </div>

            <!-- Tab Content Grid -->
            <div id="desktopTabContent" class="shop-grid" style="
                display: grid; 
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
                gap: 25px;
                min-height: 300px;
            ">
                <!-- Initial Load (New Products - Preloaded from PHP to avoid flicker) -->
                <?php 
                    // Preload first 8 from Latest to prevent empty box
                    // Ideally we fetch more via JS immediately or just show these 8
                    foreach ($latestProducts as $prod) {
                        include 'views/customer/partials/product_card.php';
                    }
                ?>
            </div>

            <!-- View All Link (Dynamic) -->
            <div style="text-align: center; margin-top: 40px;">
                <a id="viewAllBtn" href="<?= BASE_URL ?>shop/new" class="btn-action" style="padding: 10px 30px; text-decoration: none;">View All</a>
            </div>

        </div>

        <script>
            function switchTab(type, btn) {
                // 1. UI Update
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active');
                    b.style.color = '#888';
                    b.style.fontWeight = '600';
                    b.style.borderBottomColor = 'transparent';
                });
                btn.classList.add('active');
                btn.style.color = '#000';
                btn.style.fontWeight = '700';
                btn.style.borderBottomColor = '#000';

                // 2. Fetch Data
                const container = document.getElementById('desktopTabContent');
                container.style.opacity = '0.5';
                
                fetch('<?= BASE_URL ?>shop/tab_content?type=' + type)
                    .then(r => r.text())
                    .then(html => {
                        container.innerHTML = html;
                        container.style.opacity = '1';
                    });

                // 3. Update 'View All' Link
                const link = document.getElementById('viewAllBtn');
                if(type === 'new') link.href = '<?= BASE_URL ?>shop/new_arrivals';
                if(type === 'featured') link.href = '<?= BASE_URL ?>shop/featured';
                if(type === 'sale') link.href = '<?= BASE_URL ?>shop/sales';
            }
        </script>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>