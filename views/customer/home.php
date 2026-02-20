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
            const wrapper = slider.parentElement;
            const btnLeft = wrapper.querySelector('.scroll-btn.left');
            const btnRight = wrapper.querySelector('.scroll-btn.right');

            // --- 1. Smart Buttons Visibility (Desktop Only) ---
            const updateButtons = () => {
                // Determine if we are on Desktop (approx > 1024px)
                // We rely on 'd-lg-flex' CSS for base visibility, but we override here
                if (window.innerWidth < 1024) return;

                // Threshold to hide
                const tolerance = 5;

                // Left Button
                if (slider.scrollLeft <= tolerance) {
                    btnLeft.style.setProperty('display', 'none', 'important');
                } else {
                    btnLeft.style.removeProperty('display'); // Revert to CSS (d-lg-flex)
                }

                // Right Button
                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - tolerance) {
                    btnRight.style.setProperty('display', 'none', 'important');
                } else {
                    btnRight.style.removeProperty('display');
                }
            };

            // Init & Listen
            updateButtons();
            slider.addEventListener('scroll', updateButtons);
            window.addEventListener('resize', updateButtons);


            // --- 2. Mouse Wheel Horizontal Scroll ---
            slider.addEventListener('wheel', (evt) => {
                // Only hijack vertical scroll if it's primary intended interaction?
                // Standard for horizontal lists is shift+wheel, but user asked for "Mouse Wheel"
                if (window.innerWidth >= 1024) {
                    evt.preventDefault();
                    slider.scrollLeft += evt.deltaY;
                }
            });


            // --- 3. Drag to Scroll (Mouse Grab) ---
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                if (window.innerWidth < 1024) return;
                isDown = true;
                slider.style.cursor = 'grabbing';
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.style.cursor = 'grab';
            });

            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.style.cursor = 'grab';
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // Scroll-fast
                slider.scrollLeft = scrollLeft - walk;
            });

            // Set initial cursor
            if (window.innerWidth >= 1024) {
                slider.style.cursor = 'grab';
            }
        });
    });

    // Button Click Helper
    function scrollSection(btn, direction) {
        var container = btn.parentElement.querySelector('.categories-scroll, .products-scroll');
        if (container) {
            container.scrollBy({
                left: direction * 300,
                behavior: 'smooth'
            });
        }
    }
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>