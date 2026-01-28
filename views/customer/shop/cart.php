<?php
// Hide Default Mobile Header (We implement custom "YOUR CART" header)
$hide_mobile_welcome = true;
require_once 'views/layouts/customer_header.php';
?>

<div class="home-layout">
    <!-- Sidebar (Desktop) -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <main class="main-content" style="padding-bottom: 20px;">

        <!-- --- MOBILE HEADER (Custom) --- -->
        <div class="d-lg-none"
            style="display: flex; align-items: center; justify-content: space-between; padding: 20px 20px 10px 20px;">
            <!-- Back & Title -->
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="javascript:history.back()" style="
                    width: 35px; height: 35px; background: #000; border-radius: 50%; 
                    display: flex; align-items: center; justify-content: center; 
                    text-decoration: none; color: white;">
                    <i class="fas fa-chevron-left" style="font-size: 14px;"></i>
                </a>
                <div>
                    <h1 style="font-size: 20px; font-weight: 800; margin: 0; line-height: 1;">YOUR CART</h1>
                    <p style="font-size: 12px; color: #888; margin: 0;">Your Selections are amazing..!</p>
                </div>
            </div>
            <!-- Clear All -->
            <button onclick="clearCart()" style="
                background: none; border: none; color: #FF3B30; 
                font-weight: 600; font-size: 13px; cursor: pointer;">
                Clear All
            </button>
        </div>

        <!-- --- CART ITEMS LIST --- -->
        <div id="cartItemsContainer" style="padding: 10px 20px; min-height: 300px;">
            <!-- Items injected via JS -->
            <p style="text-align: center; color: #999; margin-top: 50px;">Your cart is empty.</p>
        </div>

        <!-- --- CART TOTAL & ORDER BUTTON --- -->
        <div id="cartFooter" style="padding: 20px; border-top: 1px solid #f9f9f9;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <span style="font-size: 16px; font-weight: 700; color: #888;">Cart Total</span>
                <span style="font-size: 20px; font-weight: 800; color: #444;" id="cartTotalDisplay">LKR 0</span>
            </div>

            <button onclick="openOrderModal()" style="
                width: 100%; 
                background: #25d366; /* WhatsApp Green */
                color: white; 
                border: none; 
                padding: 15px; 
                border-radius: 30px; 
                font-size: 15px; 
                font-weight: 600; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                gap: 10px;
                cursor: pointer;
                box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);">
                <i class="fab fa-whatsapp" style="font-size: 18px;"></i>
                Order Now via Whatsapp
            </button>
        </div>

    </main>
</div>

<!-- --- ORDER MODAL (Same as Product Page) --- -->
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
                    style="flex: 2; padding: 12px; border: none; background: #25d366; color: white; border-radius: 8px; font-weight: 600; cursor: pointer;">Send
                    via WhatsApp</button>
            </div>
        </form>
    </div>
</div>

<script>
    // --- MOCK CART DATA FOR DEMO (If Empty) ---
    // Remove this in production or once AddToCart is fully wired
    function seedDemoCart() {
        if (!localStorage.getItem('shopCart') || JSON.parse(localStorage.getItem('shopCart')).length === 0) {
            const demoItems = [
                {
                    id: 101, title: 'Hellow Kitty Printed Denim', price: 2500, old_price: 2900,
                    img: 'https://via.placeholder.com/150', variants: 'Colour: Light Blue, Size: 28', qty: 1
                },
                {
                    id: 102, title: 'RIB Crop Top', price: 2900, old_price: 0,
                    img: 'https://via.placeholder.com/150', variants: 'Colour: Light Blue, Size: 28', qty: 1
                }
            ];
            localStorage.setItem('shopCart', JSON.stringify(demoItems));
        }
    }
    // Uncomment to test: seedDemoCart(); 
    // I will AUTO-SEED if empty for the User's Review so they see the UI.
    seedDemoCart();

    // --- RENDER CART ---
    function renderCart() {
        const cart = getCart(); // defined in header
        const container = document.getElementById('cartItemsContainer');
        const footer = document.getElementById('cartFooter');
        const totalDisplay = document.getElementById('cartTotalDisplay');

        if (cart.length === 0) {
            container.innerHTML = '<p style="text-align: center; color: #999; margin-top: 50px;">Your cart is empty.</p>';
            totalDisplay.innerText = 'LKR 0';
            // Disable button or hide footer? UI shows it present usually.
            return;
        }

        let html = '';
        let total = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            total += itemTotal;

            html += `
                <div class="cart-item" style="
                    display: flex; align-items: center; gap: 15px; 
                    background: #fff; padding: 15px; border-radius: 20px; 
                    margin-bottom: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    
                    <!-- Image -->
                    <img src="${item.img}" style="
                        width: 70px; height: 70px; border-radius: 12px; object-fit: cover; background: #f0f0f0;">
                    
                    <!-- Info -->
                    <div style="flex: 1;">
                        <h4 style="font-size: 14px; font-weight: 700; margin: 0 0 5px 0;">${item.title}</h4>
                        <div style="font-size: 13px; font-weight: 700; color: #E4405F; margin-bottom: 3px;">
                            ${item.old_price > 0 ? `<span style="text-decoration: line-through; color: #999; font-weight: 400; font-size: 11px; margin-right: 5px;">LKR ${item.old_price}</span>` : ''}
                            LKR ${item.price}
                        </div>
                        <div style="font-size: 11px; color: #666; font-weight: 500;">
                            ${item.variants}
                        </div>
                    </div>

                    <!-- Remove (Red X Circle) -->
                    <button onclick="removeFromCart(${index})" style="
                        width: 25px; height: 25px; border-radius: 50%; border: 1px solid #FF3B30; 
                        background: none; color: #FF3B30; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        <i class="fas fa-times" style="font-size: 12px;"></i>
                    </button>
                    <!-- Figma shows no Qty controls, just Remove. Keeping it simple. -->
                </div>
            `;
        });

        container.innerHTML = html;
        totalDisplay.innerText = 'LKR ' + total.toLocaleString();
    }

    // --- ACTIONS ---
    function removeFromCart(index) {
        let cart = getCart();
        cart.splice(index, 1);
        saveCart(cart);
        renderCart();
    }

    function clearCart() {
        if (confirm('Clear all items?')) {
            saveCart([]);
            renderCart();
        }
    }

    // --- ORDER FUNCTION ---
    function openOrderModal() {
        const cart = getCart();
        if (cart.length === 0) {
            alert("Your cart is empty!");
            return;
        }
        document.getElementById('orderModal').style.display = 'flex';
    }

    function closeOrderModal() {
        document.getElementById('orderModal').style.display = 'none';
    }

    function submitOrderToWhatsApp() {
        const name = document.getElementById('ordName').value.trim();
        const address = document.getElementById('ordAddress').value.trim();
        const city = document.getElementById('ordCity').value.trim();
        const district = document.getElementById('ordDistrict').value.trim();
        const postal = document.getElementById('ordPostal').value.trim();
        const phone1 = document.getElementById('ordPhone1').value.trim();
        const phone2 = document.getElementById('ordPhone2').value.trim();
        const note = document.getElementById('ordNote').value.trim();

        if (!name || !address || !city || !phone1) {
            alert("Please fill in required fields.");
            return;
        }

        const cart = getCart();
        let total = 0;
        let msg = "*NEW CART ORDER* 🛒\n\n";

        // Cart Items
        msg += "*Items:*\n";
        cart.forEach((item, i) => {
            msg += `${i + 1}. ${item.title}\n`;
            msg += `   ${item.variants}\n`;
            msg += `   Price: LKR ${item.price}\n`;
            msg += `   Qty: ${item.qty || 1}\n\n`;
            total += (item.price * (item.qty || 1));
        });

        msg += `*Total Amount: LKR ${total.toLocaleString()}*\n`;
        msg += `----------------------------\n`;

        // Customer Details
        msg += "*Customer Details:*\n";
        msg += "Name: " + name + "\n";
        msg += "Address: " + address + "\n";
        msg += "City: " + city + "\n";
        msg += "District: " + district + "\n";
        msg += "Postal: " + postal + "\n";
        msg += "Phone 01: " + phone1 + "\n";
        msg += "Phone 02: " + phone2 + "\n";
        if (note) msg += "Note: " + note + "\n";

        const shopPhone = "<?= str_replace(['+', ' '], '', $settings['shop_whatsapp'] ?? '') ?>";
        const url = "https://wa.me/" + shopPhone + "?text=" + encodeURIComponent(msg);
        window.open(url, '_blank');
        closeOrderModal();

        // Optional: Clear cart after order?
        // saveCart([]); // Let user clear it manually or keep clear
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', renderCart);
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>