</div> <!-- End Main Wrapper -->

<!-- Mobile Bottom Navigation -->
<nav class="bottom-nav">
    <a href="<?= BASE_URL ?>" class="nav-item <?= ($current_page ?? '') == 'home' ? 'active' : '' ?>">
        <img src="<?= BASE_URL ?>assets/icons/home.png" class="nav-icon-img" alt="Home">
        <span>Home</span>
    </a>
    <a href="<?= BASE_URL ?>discounts" class="nav-item">
        <img src="<?= BASE_URL ?>assets/icons/discount.png" class="nav-icon-img" alt="Discounts">
        <span>Discounts</span>
    </a>
    <a href="<?= BASE_URL ?>shop/categories"
        class="nav-item <?= ($current_page ?? '') == 'categories' ? 'active' : '' ?>">
        <img src="<?= BASE_URL ?>assets/icons/category.png" class="nav-icon-img" alt="Categories">
        <span>Categories</span>
    </a>
    <a href="<?= BASE_URL ?>cart" class="nav-item">
        <img src="<?= BASE_URL ?>assets/icons/cart.png" class="nav-icon-img" alt="My Cart">
        <span>My Cart</span>
    </a>
    <a href="<?= BASE_URL ?>reviews" class="nav-item">
        <img src="<?= BASE_URL ?>assets/icons/reviews.png" class="nav-icon-img" alt="Reviews">
        <span>Reviews</span>
    </a>
</nav>

<!-- Desktop Footer -->
<footer class="main-footer display-desktop-only">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 40px;">
            <div>
                <h3>
                    <?= isset($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Shop Name' ?>
                </h3>
                <p>Tailored to your tastes...</p>
                <p style="font-size: 14px; color: #666;">
                    No: 213/7, Ghanaimula Mw,<br>
                    Hewagama, Kaduwela.<br>
                    <?= isset($settings['shop_whatsapp']) ? $settings['shop_whatsapp'] : '076 000 0000' ?><br>
                    info@darklavender.com
                </p>
                <button class="btn-success"
                    style="padding: 10px 20px; border:none; border-radius: 5px; cursor: pointer; color: white; background: #25d366;">Give
                    us a Review!</button>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <i class="fab fa-facebook" style="font-size: 24px; color: #1877F2;"></i>
                    <i class="fab fa-tiktok" style="font-size: 24px; color: black;"></i>
                    <i class="fab fa-instagram" style="font-size: 24px; color: #E4405F;"></i>
                    <i class="fab fa-youtube" style="font-size: 24px; color: #FF0000;"></i>
                </div>
            </div>
            <div>
                <!-- Links can go here -->
            </div>
            <div>
                <!-- Newsletter or other info -->
            </div>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp -->
<?php if (!empty($settings['shop_whatsapp'])): ?>
    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['shop_whatsapp']) ?>"
        class="floating-whatsapp display-desktop-only" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
<?php endif; ?>

<!-- Floating Cart Bubble (Mobile Only) -->
<?php
$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;
// Show only if items exist and NOT on Cart Page
if ($cartCount > 0 && ($current_page ?? '') !== 'cart'):
    ?>
    <a href="<?= BASE_URL ?>cart" class="floating-cart d-lg-none">
        <i class="fas fa-shopping-cart"></i>
        <span class="floating-cart-count"><?= $cartCount ?></span>
    </a>
<?php endif; ?>

<!-- Cart Toast Overlay -->
<div id="cartToast">
    <div class="ct-content">
        <div class="ct-emoji">😍</div>
        <div class="ct-message-pill">
            Great Choice!<br>
            The Product added to the Cart!
        </div>
        <div class="ct-view-cart" onclick="window.location.href='<?= BASE_URL ?>cart'">View Cart</div>
        <div class="ct-close" onclick="hideCartToast()">
            <i class="fas fa-times"></i>
        </div>
    </div>
</div>

<script>
    let toastTimeout;

    function showCartToast() {
        const toast = document.getElementById('cartToast');
        toast.style.display = 'flex';

        // Auto Hide after 3.5 seconds
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            hideCartToast();
        }, 3500);

        // Also update Floating Cart Count if it exists (for immediate feedback)
        // Note: Real count update requires AJAX response or reload, 
        // but we can increment purely visually for UX?
        // Let's rely on the PHP reload or AJAX success logic calling this.
    }

    function hideCartToast() {
        document.getElementById('cartToast').style.display = 'none';
        clearTimeout(toastTimeout);
    }
</script>

<!-- Responsive Display Helpers (Inlined for simplicity, or move to CSS) -->
</body>

</html>