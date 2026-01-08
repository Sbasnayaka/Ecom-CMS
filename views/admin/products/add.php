<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="/Ecom-CMS/assets/css/admin.css">
    <style>
        .header-bar {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .back-circle {
            background: #000;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

        .section-label {
            font-weight: bold;
            color: #555;
            margin-top: 20px;
            margin-bottom: 5px;
            display: block;
        }

        .sub-label {
            font-size: 11px;
            color: #999;
            margin-bottom: 10px;
            display: block;
        }

        /* Image Upload Blocks */
        .images-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .main-img-box {
            flex: 1;
            background-color: #ffeaea;
            /* Pinkish */
            border-radius: 12px;
            text-align: center;
            padding: 20px;
            cursor: pointer;
            position: relative;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .gallery-box {
            flex: 1;
            background-color: #f0f0f0;
            /* Gray */
            border-radius: 12px;
            text-align: center;
            padding: 20px;
            cursor: pointer;
            position: relative;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            position: absolute;
            top: 0;
            left: 0;
            display: none;
        }

        .input-box {
            background: #f0f0f0;
            border: none;
            border-radius: 8px;
            padding: 12px 15px;
            width: 100%;
            font-size: 14px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .price-row {
            display: flex;
            gap: 15px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .btn-yellow {
            background-color: #d4ac0d;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 48%;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-blue {
            background-color: #007aff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 48%;
            font-weight: bold;
            cursor: pointer;
            float: right;
        }

        /* Modal for Variation Selection */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            border-radius: 15px;
        }

        .var-group {
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .var-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .var-opt {
            display: inline-block;
            padding: 5px 10px;
            background: #eee;
            border-radius: 5px;
            margin: 3px;
            cursor: pointer;
            user-select: none;
        }

        .var-opt.selected {
            background: #007aff;
            color: white;
        }

        /* Loading */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 2000;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007aff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <!-- Loading Overlay -->
    <div class="loading-screen" id="loadingScreen">
        <div class="spinner"></div>
        <p style="margin-top:10px; color:#555; font-weight:bold;">Publishing Product...</p>
    </div>

    <!-- Form -->
    <form action="/Ecom-CMS/product/store" method="POST" enctype="multipart/form-data" id="productForm">
        <div class="container" style="padding-bottom: 80px;">

            <div class="header-bar">
                <a href="/Ecom-CMS/product/index" class="back-circle">❮</a>
                <div>
                    <h2 style="margin:0;">Add Product</h2>
                    <p style="margin:0; font-size:11px; color:#888;">List New Items in One Minute...</p>
                </div>
            </div>

            <!-- Images -->
            <span class="section-label">Product Images</span>
            <span class="sub-label">Maximum Size of each photo to upload: 800Kb</span>

            <div class="images-container">
                <!-- Main Image -->
                <div class="main-img-box" onclick="document.getElementById('mainImgInput').click()">
                    <img id="mainPreview" class="preview-img">
                    <div id="mainPlaceholder">
                        <div style="font-size:24px;">📷</div>
                        <p style="font-size:10px; color:#555;">Tap here to<br>upload a photo</p>
                    </div>
                    <input type="file" name="main_image" id="mainImgInput" style="display:none;" accept="image/*"
                        required>
                </div>

                <!-- Gallery -->
                <div class="gallery-box" onclick="document.getElementById('galImgInput').click()">
                    <!-- Show count if selected -->
                    <div id="galPlaceholder">
                        <div style="font-size:24px;">📷 📷 📷</div>
                        <p style="font-size:10px; color:#555;">Tap here to upload photos<br>Max: 10 Photos</p>
                    </div>
                    <p id="galCount" style="display:none; font-weight:bold; color:#007aff;">0 Selected</p>
                    <input type="file" name="gallery_images[]" id="galImgInput" style="display:none;" accept="image/*"
                        multiple>
                </div>
            </div>

            <!-- Category -->
            <span class="section-label">Select Categories <span style="color:red">*</span></span>
            <select name="category_id" class="input-box" required>
                <option value="">+ Click here to select Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <!-- Simple logic: if parent_id is null, it's a main cat -->
                    <?php if (!$cat['parent_id']): ?>
                        <optgroup label="<?= htmlspecialchars($cat['name']) ?>">
                            <!-- Find children -->
                            <?php foreach ($categories as $sub): ?>
                                <?php if ($sub['parent_id'] == $cat['id']): ?>
                                    <option value="<?= $sub['id'] ?>">
                                        <?= htmlspecialchars($sub['name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <!-- Info -->
            <span class="section-label">Product Title <span style="color:red">*</span></span>
            <input type="text" name="title" class="input-box" placeholder="Enter product name here..." required>

            <span class="section-label">Price</span>
            <div class="price-row">
                <input type="number" name="price" class="input-box" placeholder="Normal Price" step="0.01" required>
                <input type="number" name="sale_price" class="input-box" placeholder="Discounted Price" step="0.01"
                    style="background:#ffeaea;">
            </div>

            <span class="section-label">Product Description</span>
            <textarea name="description" class="input-box" rows="4"
                placeholder="You can use external links, emojis... 🌸"></textarea>

            <!-- Size Guide -->
            <span class="section-label">Size Guide</span>
            <select name="size_guide_id" class="input-box">
                <option value="">+ Click here to select Size Guides</option>
                <?php foreach ($sizeGuides as $sg): ?>
                    <option value="<?= $sg['id'] ?>">
                        <?= htmlspecialchars($sg['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- SKU -->
            <span class="section-label">Product Code (SKU)</span>
            <input type="text" name="sku" class="input-box" placeholder="Enter product name here...">

            <!-- Featured -->
            <span class="section-label">Featured Product</span>
            <label class="toggle-switch">
                <input type="checkbox" name="is_featured">
                <span class="slider"></span>
            </label>

            <div style="margin-top: 30px;">
                <button type="button" class="btn-yellow" onclick="openVarModal()">Add Variations</button>
                <button type="submit" class="btn-blue">Publish</button>
            </div>

        </div>

        <!-- Variations Hidden Inputs container -->
        <div id="hiddenVars"></div>

        <!-- Variations Modal -->
        <div class="modal-overlay" id="varModal">
            <div class="modal-content">
                <h3>Select Variations</h3>
                <p style="color:#666; font-size:12px;">Tap to select available options</p>

                <div style="max-height: 300px; overflow-y: auto;">
                    <?php foreach ($variations as $var): ?>
                        <div class="var-group">
                            <div class="var-title">
                                <?= htmlspecialchars($var['name']) ?>
                            </div>
                            <div>
                                <?php foreach ($var['values'] as $val): ?>
                                    <div class="var-opt" data-id="<?= $var['id'] ?>_<?= $val['id'] ?>"
                                        onclick="toggleVar(this)">
                                        <?= htmlspecialchars($val['value']) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top:20px; text-align:right;">
                    <button type="button" class="btn-blue" style="width:100%;" onclick="closeVarModal()">Done</button>
                </div>
            </div>
        </div>

    </form>

    <script>
        // Image Preview Logic
        document.getElementById('mainImgInput').addEventListener('change', function (e) {
            if (e.target.files && e.target.files[0]) {
                let reader = new FileReader();
                reader.onload = function (evt) {
                    const img = document.getElementById('mainPreview');
                    img.src = evt.target.result;
                    img.style.display = 'block';
                    document.getElementById('mainPlaceholder').style.display = 'none';
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        document.getElementById('galImgInput').addEventListener('change', function (e) {
            const count = e.target.files.length;
            if (count > 0) {
                document.getElementById('galPlaceholder').style.display = 'none';
                const txt = document.getElementById('galCount');
                txt.style.display = 'block';
                txt.innerText = count + " Photos Selected";
            }
        });

        // Modal Logic
        function openVarModal() { document.getElementById('varModal').style.display = 'flex'; }
        function closeVarModal() {
            document.getElementById('varModal').style.display = 'none';
            populateHiddenVars();
        }

        function toggleVar(el) {
            el.classList.toggle('selected');
        }

        // Convert selections to hidden inputs for form submission
        function populateHiddenVars() {
            const container = document.getElementById('hiddenVars');
            container.innerHTML = '';
            const selected = document.querySelectorAll('.var-opt.selected');

            selected.forEach(el => {
                const val = el.getAttribute('data-id'); // varId_valId
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_variations[]';
                input.value = val;
                container.appendChild(input);
            });

            // Update button text to show count
            const btn = document.querySelector('.btn-yellow');
            if (selected.length > 0) {
                btn.innerText = "Variations (" + selected.length + ")";
            } else {
                btn.innerText = "Add Variations";
            }
        }

        // Form Submit Loading
        document.getElementById('productForm').addEventListener('submit', function () {
            document.getElementById('loadingScreen').style.display = 'flex';
        });
    </script>

</body>

</html>