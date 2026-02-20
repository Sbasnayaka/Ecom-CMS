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
        const sliders = document.querySelectorAll('.categories-scroll, .products-scroll');

        sliders.forEach(slider => {
            // --- 1. Smart Buttons Logic ---
            const parent = slider.parentElement;
            const btnLeft = parent.querySelector('.scroll-btn.left');
            const btnRight = parent.querySelector('.scroll-btn.right');

            const updateButtons = () => {
                if (!btnLeft || !btnRight) return;

                // Show/Hide Left Button
                if (slider.scrollLeft <= 0) {
                    btnLeft.style.display = 'none';
                } else {
                    btnLeft.style.display = 'flex';
                }

                // Show/Hide Right Button
                // tolerance of 1px for high-res screens
                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 1) {
                    btnRight.style.display = 'none';
                } else {
                    btnRight.style.display = 'flex';
                }
            };

            // Init & Listen
            slider.addEventListener('scroll', updateButtons);
            // Initial check (give browser a moment to render layout)
            setTimeout(updateButtons, 100);
            updateButtons();

            // --- 2. Mouse Wheel Horizontal Scroll Logic ---
            slider.addEventListener('wheel', (e) => {
                // Determine if the element can actually scroll horizontally
                // (scrollWidth > clientWidth)
                if (slider.scrollWidth > slider.clientWidth) {
                    // Prevent default vertical scroll
                    e.preventDefault();

                    // Specific "Wheel" scrolling logic
                    slider.scrollLeft += e.deltaY;
                }
            }, { passive: false });

            // Remove Drag Styles
            slider.style.cursor = 'default';
        });
    });

    // Button Click Helper
    function scrollSection(btn, direction) {
        var container = btn.parentElement.querySelector('.categories-scroll, .products-scroll');
        if (container) {
            const scrollAmount = 300;
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    }
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>