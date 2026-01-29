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
                    <img src="<?= BASE_URL ?>assets/icons/back.png" alt="Back"
                        style="width: 24px; height: 24px; filter: invert(1);">
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
                <h1 class="pd-title" style="text-align: left;">
                    <?= htmlspecialchars($product['title']) ?>
                </h1>

                <!-- Price & Guide Row -->
                <div class="pd-price-row" style="justify-content: flex-start; gap: 20px;">
                    <div class="pd-prices" style="font-weight: 700;">
                        <?php
                        $currency = $settings['currency_symbol'] ?? 'LKR';
                        if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']):
                            ?>
                            <span class="pd-old-price" style="font-weight: 400;">
                                <?= $currency ?>
                                <?= number_format($product['price'], 0) ?>
                            </span>
                            <span class="pd-sale-price" style="font-weight: 800; color: #000;">
                                <?= $currency ?>
                                <?= number_format($product['sale_price'], 0) ?>
                            </span>
                        <?php else: ?>
                            <span class="pd-sale-price" style="font-weight: 800; color: #000;">
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
                                    <div class="var-pill"
                                        onclick="selectVariation(this, '<?= $varName ?>', '<?= htmlspecialchars($val['value']) ?>')">
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

                <!-- Quantity Selector -->
                <div class="pd-quantity"
                    style="margin-top: 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 20px;">
                    <span style="font-weight: 600; font-size: 15px; color: #000;">Quantity :</span>
                    <div
                        style="display: flex; align-items: center; border: 1px solid #000; border-radius: 5px; background: #fff; height: 35px;">
                        <button type="button" onclick="updateQty(-1)"
                            style="border:none; border-right: 1px solid #000; background:transparent; width: 35px; height: 100%; font-size: 16px; cursor: pointer; color: #000; display: flex; align-items: center; justify-content: center;">-</button>
                        <input type="number" id="qtyInput" value="1" min="1" readonly
                            style="width: 40px; height: 100%; text-align: center; border: none; font-weight: 700; font-size: 14px; outline: none; color: #000; padding: 0;">
                        <button type="button" onclick="updateQty(1)"
                            style="border:none; border-left: 1px solid #000; background:transparent; width: 35px; height: 100%; font-size: 16px; cursor: pointer; color: #000; display: flex; align-items: center; justify-content: center;">+</button>
                    </div>
                </div>

                <!-- Bottom Actions -->
                <div class="pd-bottom-actions">
                    <!-- WhatsApp Order -->
                    <!-- Order Now Button (Triggers Modal) -->
                    <button class="btn-action btn-whatsapp" onclick="openOrderModal()">
                        <i class="fab fa-whatsapp"></i> Order Now
                    </button>

                    <!-- Add to Cart -->
                    <!-- Add to Cart (Real Logic) -->
                    <button class="btn-action btn-cart" onclick="addToCartFromProductPage()">
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
    <script>     function openSizeGuide() { document.getElementById('sgModal').style.display = 'flex'; } function closeSizeGuide() { document.getElementById('sgModal').style.display = 'none'; }
    </script>
<?php endif; ?>

<!-- Order Form Modal (Task 4.1) -->
<div id="orderModal" class="modal-overlay" style="display: none;">
    <div class="modal-content"
        style="max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; padding: 25px; border-radius: 15px;">
        <h3 style="margin-top: 0; font-size: 20px; font-weight: 800; text-align: center; margin-bottom: 20px;">Complete
            Your Order</h3>

        <form onsubmit="event.preventDefault(); submitOrderToWhatsApp();">
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Full Name <span
                        style="color:red">*</span></label>
                <input type="text" id="ordName" class="form-control" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Address <span
                        style="color:red">*</span></label>
                <textarea id="ordAddress" class="form-control" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; height: 60px;"></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="margin-bottom: 15px; flex: 1;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">City <span
                            style="color:red">*</span></label>
                    <input type="text" id="ordCity" class="form-control" required
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div class="form-group" style="margin-bottom: 15px; flex: 1;">
                    <label
                        style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">District</label>
                    <input type="text" id="ordDistrict" class="form-control"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Postal
                    Code</label>
                <input type="text" id="ordPostal" class="form-control"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Phone Number 01
                    <span style="color:red">*</span></label>
                <input type="tel" id="ordPhone1" class="form-control" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Phone Number
                    02</label>
                <input type="tel" id="ordPhone2" class="form-control"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Special
                    Note</label>
                <textarea id="ordNote" class="form-control"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; height: 60px;"></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeOrderModal()"
                    style="flex: 1; padding: 12px; border: 1px solid #ddd; background: #f5f5f5; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
                <button type="submit"
                    style="flex: 2; padding: 12px; border: none; background: #6AD07F; color: white; border-radius: 8px; font-weight: 600; cursor: pointer;">Send
                    via WhatsApp</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Quantity Logic
    function updateQty(change) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value);
        val += change;
        if (val < 1) val = 1;
        input.value = val;
    }

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
        const qty = parseInt(document.getElementById('qtyInput').value) || 1;
        const unitPrice = <?= $product['sale_price'] ?: $product['price'] ?>;
        const total = unitPrice * qty;

        msg += "*Product Details:*\n";
        msg += "Name: <?= addslashes($product['title']) ?>\n";
        msg += "Price: LKR " + unitPrice.toLocaleString('en-US') + "\n";
        msg += "Quantity: " + qty + "\n";
        msg += "Total: LKR " + total.toLocaleString('en-US') + "\n";
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

    // --- Add to Cart Logic (AJAX) ---
    function addToCartFromProductPage() {
        // 1. Gather Details
        const id = <?= $product['id'] ?>;
        const title = "<?= addslashes($product['title']) ?>";
        const price = <?= $product['sale_price'] ?: $product['price'] ?>;
        const qty = parseInt(document.getElementById('qtyInput').value) || 1;

        <?php
        // Get Image URL safely
        $img = 'assets/uploads/' . $product['main_image'];
        if (empty($product['main_image']) || !file_exists(ROOT_PATH . $img)) {
            $imgUrl = 'https://via.placeholder.com/150';
        } else {
            $imgUrl = BASE_URL . $img;
        }
        ?>
        const img = "<?= $imgUrl ?>";

        // Format Variations String
        let variantStr = "";
        if (Object.keys(selectedVariations).length > 0) {
            for (const [key, val] of Object.entries(selectedVariations)) {
                variantStr += key + ": " + val + ", ";
            }
            variantStr = variantStr.slice(0, -2);
        }

        // 2. Prepare Data
        const payload = {
            id: id,
            title: title,
            price: price,
            quantity: qty,
            img: img,
            variants: variantStr
        };

        // 3. Send AJAX Request
        fetch('<?= BASE_URL ?>cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show Toast instead of Redirect
                    if (typeof showCartToast === 'function') {
                        showCartToast();
                    }
                    // Optionally update global cart count badge if generic logic exists?
                    // We can reload or just let the user navigate.
                    // Ideally we should update the floating bubble count visually.
                    const bubbleCount = document.querySelector('.floating-cart-count');
                    const headerCount = document.querySelector('.cart-badge-count');

                    if (data.count) {
                        if (bubbleCount) bubbleCount.innerText = data.count;
                        if (headerCount) {
                            headerCount.innerText = data.count;
                            headerCount.style.display = 'inline-block';
                        }
                        // Also ensure floating cart is visible if it was hidden
                        const floatingCart = document.querySelector('.floating-cart');
                        if (floatingCart) floatingCart.style.display = 'flex';
                    }

                    // window.location.href = '<?= BASE_URL ?>cart'; // Removed
                } else {
                    alert('Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            });
    }

    // Adjust selectVariation to store text value
    // In PHP: selectVariation(this, 'Color', 'Red') -> I need to make sure PHP passes the VALUE not ID.
    // The PHP code says: selectVariation(this, '<?= $varName ?>', '<?= $val['id'] ?>')
    // I will UPDATE the PHP loop in a separate replacement chunk to pass VALUE.

    // Simple Gallery Slider (for now just manual logic or relying on CSS scroll snap if implemented)
    // We will assume CSS scroll snap for gallery-slider in css
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>