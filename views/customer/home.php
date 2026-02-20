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

        <div style="position: relative;">
            <button class="scroll-btn left d-lg-flex" onclick="scrollSection(this, -1)" style="display: none; position: absolute; top: 50%; left: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                <i class="fas fa-chevron-left" style="color: black; font-size: 14px;"></i>
            </button>
            <div class="categories-scroll">
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= BASE_URL ?>shop/category/<?= $cat['id'] ?>" class="cat-item"
                        style="text-decoration: none; color: inherit; display: block;">
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
                    </a>
                <?php endforeach; ?>
            </div>
            <button class="scroll-btn right d-lg-flex" onclick="scrollSection(this, 1)" style="display: none; position: absolute; top: 50%; right: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                <i class="fas fa-chevron-right" style="color: black; font-size: 14px;"></i>
            </button>
        </div>

        <!-- Featured Products -->
        <?php if (!empty($featuredProducts)): ?>
            <div class="section-header">
                <h2 class="section-title">Featured Products <span class="tag special">SPECIAL</span></h2>
            </div>
            <div style="position: relative;">
                <button class="scroll-btn left d-lg-flex" onclick="scrollSection(this, -1)" style="display: none; position: absolute; top: 50%; left: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                    <i class="fas fa-chevron-left" style="color: black; font-size: 14px;"></i>
                </button>
                <div class="products-scroll">
                    <?php foreach ($featuredProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
                <button class="scroll-btn right d-lg-flex" onclick="scrollSection(this, 1)" style="display: none; position: absolute; top: 50%; right: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                    <i class="fas fa-chevron-right" style="color: black; font-size: 14px;"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Latest Products -->
        <div class="section-header">
            <h2 class="section-title">Latest Products <span class="tag new">NEW</span></h2>
        </div>
        <div style="position: relative;">
            <button class="scroll-btn left d-lg-flex" onclick="scrollSection(this, -1)" style="display: none; position: absolute; top: 50%; left: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                <i class="fas fa-chevron-left" style="color: black; font-size: 14px;"></i>
            </button>
            <div class="products-scroll">
                <?php foreach ($latestProducts as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
            <button class="scroll-btn right d-lg-flex" onclick="scrollSection(this, 1)" style="display: none; position: absolute; top: 50%; right: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                <i class="fas fa-chevron-right" style="color: black; font-size: 14px;"></i>
            </button>
        </div>

        <!-- Sale Products -->
        <?php if (!empty($saleProducts)): ?>
            <div class="section-header">
                <h2 class="section-title">Sale Products <span class="tag sale">Sale..!</span></h2>
            </div>
            <div style="position: relative;">
                <button class="scroll-btn left d-lg-flex" onclick="scrollSection(this, -1)" style="display: none; position: absolute; top: 50%; left: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                    <i class="fas fa-chevron-left" style="color: black; font-size: 14px;"></i>
                </button>
                <div class="products-scroll">
                    <?php foreach ($saleProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
                <button class="scroll-btn right d-lg-flex" onclick="scrollSection(this, 1)" style="display: none; position: absolute; top: 50%; right: -15px; transform: translateY(-50%); z-index: 10; 
                       width: 35px; height: 35px; border-radius: 50%; background: white; 
                       box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; 
                       cursor: pointer; align-items: center; justify-content: center;">
                    <i class="fas fa-chevron-right" style="color: black; font-size: 14px;"></i>
                </button>
            </div>
        <?php endif; ?>

    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const containers = document.querySelectorAll('.categories-scroll, .products-scroll, .gallery-slider');

        containers.forEach(container => {
            // 1. Mouse Wheel Horizontal Scroll
            container.addEventListener('wheel', (e) => {
                if (window.innerWidth >= 1024) { // Desktop Only
                    e.preventDefault();
                    container.scrollLeft += e.deltaY;
                }
            });

            // 2. Smart Button Visibility (Initialize)
            updateButtons(container);

            // 3. Update Buttons on Scroll
            container.addEventListener('scroll', () => {
                updateButtons(container);
            });
        });
    });

    function scrollSection(btn, direction) {
        // Find sibling container
        const container = btn.parentElement.querySelector('.categories-scroll, .products-scroll, .gallery-slider');
        if (container) {
            container.scrollBy({
                left: direction * 300,
                behavior: 'smooth'
            });
            // Buttons will auto-update via scroll listener
        }
    }

    function updateButtons(container) {
        if (!container) return;

        const parent = container.parentElement;
        const leftBtn = parent.querySelector('.scroll-btn.left');
        const rightBtn = parent.querySelector('.scroll-btn.right');

        if (!leftBtn || !rightBtn) return;

        // Logic: 
        // Start (0) -> Hide Left
        // End (Max) -> Hide Right
        // Else -> Show Both

        const tolerance = 5; // Pixel tolerance
        const maxScroll = container.scrollWidth - container.clientWidth;

        if (container.scrollLeft <= tolerance) {
            leftBtn.style.display = 'none';
        } else {
            leftBtn.style.display = 'flex'; // Restore inline-flex/flex from class, but valid here since we control style
        }

        if (container.scrollLeft >= maxScroll - tolerance) {
            rightBtn.style.display = 'none';
        } else {
            rightBtn.style.display = 'flex';
        }
    }
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>