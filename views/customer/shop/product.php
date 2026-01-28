<?php
// Hide Default Mobile Header for Single Product Page (Task 3.1)
$hide_mobile_welcome = true;
require_once 'views/layouts/customer_header.php';
?>

<!-- Wrappers for Sidebar Layout -->
<div class="home-layout">

    <!-- Include Sidebar -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <main class="main-content">

        <!-- Single Product View Styles (All handled in customer.css now) -->
        <div class="product-detail-page">

            <!-- Image Gallery Section -->
            <div class="product-gallery">
                <!-- Back Button Overlay -->
                <!-- Back Button Overlay (Task 3.2 Fix) -->
                <a href="javascript:history.back()" class="back-btn-overlay" style="text-decoration: none;">
                    <img src="<?= BASE_URL ?>assets/icons/back.png" alt="Back" style="width: 24px; height: 24px; filter: invert(1);"> 
                    <!-- Inverted filter to make black icon white inside black circle if icon is black. 
                         Checking icon preview... 'back.png' might be black. 
                         If container is rgba(0,0,0,0.6), we want White icon. 
                         Assuming png is black based on previous behavior. -->
                </a>

                <div class="gallery-slider">
                    <!-- Main Image First -->
                    <?php
                    $mainImg = 'assets/uploads/' . $product['main_image'];
                    if (empty($product['main_image']) || !file_exists(ROOT_PATH . $mainImg)) {
                        $mainImg = 'https://via.placeholder.com/600x600?text=' . urlencode($product['title']);
                    } else {
                        $mainImg = BASE_URL . $mainImg;
                    }
                    ?>
                    <img src="<?= $mainImg ?>" class="gallery-img current" alt="Main Image">

                    <!-- Gallery Images -->
                    <?php if (!empty($gallery)): ?>
                        <?php foreach ($gallery as $gImg):
                            $gPath = 'assets/uploads/' . $gImg;
                            $gUrl = (file_exists(ROOT_PATH . $gPath)) ? BASE_URL . $gPath : '';
                            if ($gUrl):
                                ?>
                                <img src="<?= $gUrl ?>" class="gallery-img" alt="Gallery Image">
                            <?php endif; endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination Dots (Visual Only for now, or simple JS) -->
                <div class="gallery-dots">
                    <span class="dot active"></span>
                    <?php if (!empty($gallery)): ?>
                        <?php foreach ($gallery as $g): ?>
                            <span class="dot"></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info Section -->
            <div class="product-info-container">

                <!-- Breadcrumb / Category -->
                <div class="pd-breadcrumb">
                    <?php
                    $catName = htmlspecialchars($product['category_name'] ?? '');
                    $parentName = htmlspecialchars($product['parent_category_name'] ?? '');
                    echo (!empty($parentName) ? $parentName . ' | ' : '') . $catName;
                    ?>
                </div>

                <!-- Title -->
                <h1 class="pd-title">
                    <?= htmlspecialchars($product['title']) ?>
                </h1>

                <!-- Price & Guide Row -->
                <div class="pd-price-row">
                    <div class="pd-prices">
                        <?php
                        $currency = $settings['currency_symbol'] ?? 'LKR';
                        if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']):
                            ?>
                            <span class="pd-old-price">
                                <?= $currency ?>
                                <?= number_format($product['price'], 0) ?>
                            </span>
                            <span class="pd-sale-price">
                                <?= $currency ?>
                                <?= number_format($product['sale_price'], 0) ?>
                            </span>
                        <?php else: ?>
                            <span class="pd-sale-price">
                                <?= $currency ?>
                                <?= number_format($product['price'], 0) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php
                    $sgPath = 'assets/uploads/' . ($product['size_guide_image'] ?? '');
                    if (!empty($product['size_guide_image']) && file_exists(ROOT_PATH . $sgPath)):
                        ?>
                        <button class="btn-size-guide" onclick="openSizeGuide()">Size Guide</button>
                    <?php endif; ?>
                </div>

                <!-- Variations -->
                <?php if (!empty($variations)): ?>
                    <?php foreach ($variations as $varName => $values): ?>
                        <div class="var-section">
                            <span class="var-label">
                                <?= htmlspecialchars(ucfirst($varName)) ?>
                            </span>
                            <div class="var-pills">
                                <?php foreach ($values as $val): ?>
                                    <div class="var-pill" onclick="selectVariation(this, '<?= $varName ?>', '<?= htmlspecialchars($val['value']) ?>')">
                                        <?= htmlspecialchars($val['value']) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Description -->
                <div class="pd-description">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>


                </div>

                <!-- Bottom Actions -->
                <div class="pd-bottom-actions">
                    <!-- WhatsApp Order -->
                    <!-- Order Now Button (Triggers Modal) -->
                    <button class="btn-action btn-whatsapp" onclick="openOrderModal()">
                        <i class="fab fa-whatsapp"></i> Order Now
                    </button>

                    <!-- Add to Cart -->
                    <button class="btn-action btn-cart" onclick="addToCart(<?= $product['id'] ?>)">
                        <i class="fas fa-cart-plus"></i> Add to cart
                    </button>
                </div>

            </div>
        </div>

        <!-- You May Also Like Section -->
        <?php if (!empty($relatedProducts)): ?>
            <div style="margin-top: 50px; border-top: 1px solid #eee; padding-top: 30px;">
                <h3 style="margin-bottom: 20px;">You May Also Like...</h3>
                <div class="products-scroll" style="display:flex; overflow-x:auto; gap:15px; padding-bottom:10px;">
                    <?php foreach ($relatedProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </main>
</div>
<!-- End Wrappers -->

<!-- Size Guide Modal (Basic) -->
<?php
$sgPath = 'assets/uploads/' . ($product['size_guide_image'] ?? '');
if (!empty($product['size_guide_image']) && file_exists(ROOT_PATH . $sgPath)):
    $sgImg = BASE_URL . $sgPath;
    ?>
    <div id="sgModal" class="modal-overlay" onclick="closeSizeGuide()" style="display: none;">
        <div class="modal-content" onclick="event.stopPropagation()" style="position: relative; padding: 0;">
            <div onclick="closeSizeGuide()"
                style="position: absolute; top: 10px; right: 10px; cursor: pointer; z-index: 100; background: rgba(255,255,255,0.7); border-radius: 50%; padding: 5px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                <img src="<?= BASE_URL ?>assets/icons/delete.png" alt="Close" style="width: 15px; height: 15px;">
            </div>
            <img src="<?= $sgImg ?>" style="width:100%; border-radius:10px; display: block;">
        </div>
    </div>
    <script>     function openSizeGuide() { document.getElementById('sgModal').style.display = 'flex'; }     function closeSizeGuide() { document.getElementById('sgModal').style.display = 'none'; }
    </script>
<?php endif; ?>

<script>
    // Variation Selection Logic
    let selectedVariations = {}; // Store selected variations: { 'Color': 'Red', 'Size': 'M' }

    function selectVariation(el, name, value) {
        // Toggle active class in this group
        let siblings = el.parentElement.querySelectorAll('.var-pill');
        siblings.forEach(s => s.classList.remove('active'));
        el.classList.add('active');
        
        // Store selection
        selectedVariations[name] = value;
        console.log("Selected:", selectedVariations);
    }

    // --- Order Modal Logic (Task 4.1) ---

    function openOrderModal() {
        // Check if all variations are selected (Optional safety check, or let them order anyway)
        // For now, allow opening.
        document.getElementById('orderModal').style.display = 'flex';
    }

    function closeOrderModal() {
        document.getElementById('orderModal').style.display = 'none';
    }

    function submitOrderToWhatsApp() {
        // 1. Get Form Values
        const name = document.getElementById('ordName').value.trim();
        const address = document.getElementById('ordAddress').value.trim();
        const city = document.getElementById('ordCity').value.trim();
        const district = document.getElementById('ordDistrict').value.trim();
        const postal = document.getElementById('ordPostal').value.trim();
        const phone1 = document.getElementById('ordPhone1').value.trim();
        const phone2 = document.getElementById('ordPhone2').value.trim();
        const note = document.getElementById('ordNote').value.trim();

        // 2. Validation
        if (!name || !address || !city || !phone1) {
            alert("Please fill in all required fields (Name, Address, City, Phone 01)");
            return;
        }

        // 3. Construct Message
        let msg = "*NEW ORDER REQUEST* 🛍️\n\n";
        
        // Product Details
        msg += "*Product Details:*\n";
        msg += "Name: <?= addslashes($product['title']) ?>\n";
        msg += "Price: <?= $product['sale_price'] ? 'LKR ' . number_format($product['sale_price']) : 'LKR ' . number_format($product['price']) ?>\n";
        msg += "Link: " + window.location.href + "\n";
        
        // Add Selected Variations
        if (Object.keys(selectedVariations).length > 0) {
            msg += "Variations: ";
            for (const [key, val] of Object.entries(selectedVariations)) {
                // We stored ID or Value? The logic above passed ID in PHP loop: selectVariation(this, 'Color', '12').
                // Wait, the PHP loop passed ID? Let's check PHP above.
                // PHP: selectVariation(this, '$varName', '$val['id']') 
                // Ah, we need the TEXT value for the message, not the ID.
                // Re-checking PHP loop: $val['value'] is the text.
                // I will adjust selectVariation to take the text value instead of ID for the message construction, 
                // OR getting the text content from the element.
                msg += key + ": " + val + ", ";
            }
            msg = msg.slice(0, -2); // remove last comma
            msg += "\n";
        }
        
        msg += "\n*Customer Details:*\n";
        msg += "Name: " + name + "\n";
        msg += "Address: " + address + "\n";
        msg += "City: " + city + "\n";
        msg += "District: " + district + "\n";
        msg += "Postal: " + postal + "\n";
        msg += "Phone 01: " + phone1 + "\n";
        msg += "Phone 02: " + phone2 + "\n";
        if (note) msg += "Note: " + note + "\n";

        // 4. Redirect
        const shopPhone = "<?= str_replace(['+', ' '], '', $settings['shop_whatsapp'] ?? '') ?>";
        const url = "https://wa.me/" + shopPhone + "?text=" + encodeURIComponent(msg);
        window.open(url, '_blank');
        closeOrderModal();
    }

    // Adjust selectVariation to store text value
    // In PHP: selectVariation(this, 'Color', 'Red') -> I need to make sure PHP passes the VALUE not ID.
    // The PHP code says: selectVariation(this, '<?= $varName ?>', '<?= $val['id'] ?>')
    // I will UPDATE the PHP loop in a separate replacement chunk to pass VALUE.

    // Simple Gallery Slider (for now just manual logic or relying on CSS scroll snap if implemented)
    // We will assume CSS scroll snap for gallery-slider in css
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>