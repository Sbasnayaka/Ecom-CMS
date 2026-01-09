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
        .page-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }

        .style-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .control-group {
            margin-bottom: 15px;
        }

        .control-label {
            font-size: 13px;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .select-input,
        .text-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .color-picker-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .color-input {
            width: 40px;
            height: 40px;
            padding: 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .color-text {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #f9f9f9;
            color: #666;
            font-size: 13px;
        }

        .range-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .range-slider {
            flex: 1;
        }

        .range-val {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            font-size: 12px;
        }

        .btn-save {
            background: #007aff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 50px;
        }
    </style>
</head>

<body>

    <form action="/Ecom-CMS/settings/updateStyles" method="POST">
        <div class="container">

            <div class="page-header">
                <a href="/Ecom-CMS/settings/edit" style="text-decoration:none; color:black; font-size:24px;">❮</a>
                <div class="header-title">Global Styles</div>
            </div>

            <!-- Typography & Colors Row -->
            <div style="display:flex; flex-wrap:wrap; gap:20px;">
                <!-- Typography -->
                <div class="style-card" style="flex:1; min-width:280px;">
                    <div class="card-header">Typography</div>
                    <div class="control-group">
                        <label class="control-label">Font Family</label>
                        <select name="font_family" class="select-input">
                            <option value="Roboto" <?= ($styles['font_family'] ?? '') == 'Roboto' ? 'selected' : '' ?>>
                                Roboto</option>
                            <option value="Open Sans" <?= ($styles['font_family'] ?? '') == 'Open Sans' ? 'selected' : '' ?>>Open Sans</option>
                            <option value="Montserrat" <?= ($styles['font_family'] ?? '') == 'Montserrat' ? 'selected' : '' ?>>Montserrat</option>
                            <option value="Inter" <?= ($styles['font_family'] ?? '') == 'Inter' ? 'selected' : '' ?>>Inter
                            </option>
                        </select>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Heading Color</label>
                        <div class="color-picker-row">
                            <input type="color" name="h1_color" class="color-input"
                                value="<?= $styles['h1_color'] ?? '#000000' ?>">
                            <input type="text" class="color-text" value="<?= $styles['h1_color'] ?? '#000000' ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Body Text Size (px)</label>
                        <div class="range-row">
                            <input type="range" min="10" max="24" class="range-slider"
                                value="<?= $styles['body_size'] ?? 14 ?>"
                                oninput="this.nextElementSibling.value = this.value">
                            <input type="text" name="body_size" class="range-val"
                                value="<?= $styles['body_size'] ?? 14 ?>">
                        </div>
                    </div>
                </div>

                <!-- Colors -->
                <div class="style-card" style="flex:1; min-width:280px;">
                    <div class="card-header">Theme Colors</div>
                    <div class="control-group">
                        <label class="control-label">Primary Color</label>
                        <div class="color-picker-row">
                            <input type="color" name="primary_color" class="color-input"
                                value="<?= $styles['primary_color'] ?? '#007aff' ?>">
                            <input type="text" class="color-text" value="<?= $styles['primary_color'] ?? '#007aff' ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Secondary Color</label>
                        <div class="color-picker-row">
                            <input type="color" name="secondary_color" class="color-input"
                                value="<?= $styles['secondary_color'] ?? '#5ac8fa' ?>">
                            <input type="text" class="color-text" value="<?= $styles['secondary_color'] ?? '#5ac8fa' ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Background Color</label>
                        <div class="color-picker-row">
                            <input type="color" name="bg_color" class="color-input"
                                value="<?= $styles['bg_color'] ?? '#ffffff' ?>">
                            <input type="text" class="color-text" value="<?= $styles['bg_color'] ?? '#ffffff' ?>"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Layout & Grid -->
            <div class="style-card">
                <div class="card-header">Layout & Grid System</div>
                <div style="display:flex; flex-wrap:wrap; gap:20px;">
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Mobile Breakpoint (px)</label>
                            <input type="number" name="bp_mobile" class="text-input"
                                value="<?= $styles['bp_mobile'] ?? 480 ?>">
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tablet Breakpoint (px)</label>
                            <input type="number" name="bp_tablet" class="text-input"
                                value="<?= $styles['bp_tablet'] ?? 768 ?>">
                        </div>
                    </div>
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Desktop Breakpoint (px)</label>
                            <input type="number" name="bp_desktop" class="text-input"
                                value="<?= $styles['bp_desktop'] ?? 1024 ?>">
                        </div>
                        <div class="control-group">
                            <label class="control-label">Wide Breakpoint (px)</label>
                            <input type="number" name="bp_wide" class="text-input"
                                value="<?= $styles['bp_wide'] ?? 1280 ?>">
                        </div>
                    </div>
                </div>
                <hr style="border:0; border-top:1px solid #eee; margin:15px 0;">
                <div style="display:flex; flex-wrap:wrap; gap:20px;">
                    <div style="flex:1;">
                        <label class="control-label">Grid Columns</label>
                        <select name="grid_cols" class="select-input">
                            <option value="12" <?= ($styles['grid_cols'] ?? '') == '12' ? 'selected' : '' ?>>12 Columns
                            </option>
                            <option value="16" <?= ($styles['grid_cols'] ?? '') == '16' ? 'selected' : '' ?>>16 Columns
                            </option>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label class="control-label">Gutter Spacing (px)</label>
                        <input type="number" name="grid_gutter" class="text-input"
                            value="<?= $styles['grid_gutter'] ?? 20 ?>">
                    </div>
                </div>
            </div>

            <!-- Media & Images -->
            <div class="style-card">
                <div class="card-header">Media & Images</div>
                <div style="display:flex; flex-wrap:wrap; gap:20px;">
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Product Aspect Ratio</label>
                            <select name="aspect_product" class="select-input">
                                <option value="1:1" <?= ($styles['aspect_product'] ?? '') == '1:1' ? 'selected' : '' ?>>1:1
                                    (Square)</option>
                                <option value="4:5" <?= ($styles['aspect_product'] ?? '') == '4:5' ? 'selected' : '' ?>>4:5
                                    (Portrait)</option>
                                <option value="16:9" <?= ($styles['aspect_product'] ?? '') == '16:9' ? 'selected' : '' ?>>
                                    16:9 (Landscape)</option>
                            </select>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Global Image Radius (px)</label>
                            <div class="range-row">
                                <input type="range" min="0" max="50" class="range-slider"
                                    value="<?= $styles['global_img_radius'] ?? 8 ?>"
                                    oninput="this.nextElementSibling.value = this.value">
                                <input type="text" name="global_img_radius" class="range-val"
                                    value="<?= $styles['global_img_radius'] ?? 8 ?>">
                            </div>
                        </div>
                    </div>
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Banner Aspect Ratio</label>
                            <select name="aspect_banner" class="select-input">
                                <option value="16:9" <?= ($styles['aspect_banner'] ?? '') == '16:9' ? 'selected' : '' ?>>
                                    16:9</option>
                                <option value="21:9" <?= ($styles['aspect_banner'] ?? '') == '21:9' ? 'selected' : '' ?>>
                                    21:9 (Ultrawide)</option>
                                <option value="3:1" <?= ($styles['aspect_banner'] ?? '') == '3:1' ? 'selected' : '' ?>>3:1
                                    (Slim)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Behavior & Interactions -->
            <div class="style-card">
                <div class="card-header">Behavior & Interactions</div>
                <div style="display:flex; flex-wrap:wrap; gap:20px;">
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Sticky Elements</label>
                            <div style="display:flex; gap:15px; margin-top:5px;">
                                <label><input type="checkbox" name="sticky_header" value="1"
                                        <?= !empty($styles['sticky_header']) ? 'checked' : '' ?>> Header</label>
                                <label><input type="checkbox" name="sticky_filters" value="1"
                                        <?= !empty($styles['sticky_filters']) ? 'checked' : '' ?>> Filters</label>
                                <label><input type="checkbox" name="sticky_cart" value="1"
                                        <?= !empty($styles['sticky_cart']) ? 'checked' : '' ?>> Cart Bar</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Scroll Behavior</label>
                            <select name="scroll_smooth" class="select-input">
                                <option value="1" <?= ($styles['scroll_smooth'] ?? '') == '1' ? 'selected' : '' ?>>Smooth
                                </option>
                                <option value="0" <?= ($styles['scroll_smooth'] ?? '') == '0' ? 'selected' : '' ?>>Instant
                                </option>
                            </select>
                        </div>
                    </div>
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Hover vs Tap</label>
                            <select name="hover_interaction" class="select-input">
                                <option value="standard" <?= ($styles['hover_interaction'] ?? '') == 'standard' ? 'selected' : '' ?>>Standard (Hover on Desktop)</option>
                                <option value="touch_first" <?= ($styles['hover_interaction'] ?? '') == 'touch_first' ? 'selected' : '' ?>>Touch Optimized (Click only)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System (Buttons & Loading) -->
            <div class="style-card">
                <div class="card-header">Buttons & System</div>
                <div style="display:flex; flex-wrap:wrap; gap:20px;">
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Btn Corner Radius</label>
                            <div class="range-row">
                                <input type="range" min="0" max="30" class="range-slider"
                                    value="<?= $styles['btn_radius'] ?? 8 ?>"
                                    oninput="this.nextElementSibling.value = this.value">
                                <input type="text" name="btn_radius" class="range-val"
                                    value="<?= $styles['btn_radius'] ?? 8 ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Skeleton Loader</label>
                            <select name="skeleton_type" class="select-input">
                                <option value="pulse" <?= ($styles['skeleton_type'] ?? '') == 'pulse' ? 'selected' : '' ?>>
                                    Pulse Animation</option>
                                <option value="shimmer" <?= ($styles['skeleton_type'] ?? '') == 'shimmer' ? 'selected' : '' ?>>Shimmer Wave</option>
                                <option value="static" <?= ($styles['skeleton_type'] ?? '') == 'static' ? 'selected' : '' ?>>Static Gray</option>
                            </select>
                        </div>
                    </div>
                    <div style="flex:1;">
                        <div class="control-group">
                            <label class="control-label">Button Background</label>
                            <div class="color-picker-row">
                                <input type="color" name="btn_bg_color" class="color-input"
                                    value="<?= $styles['btn_bg_color'] ?? '#007aff' ?>">
                                <input type="text" class="color-text"
                                    value="<?= $styles['btn_bg_color'] ?? '#007aff' ?>" readonly>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Button Text</label>
                            <div class="color-picker-row">
                                <input type="color" name="btn_text_color" class="color-input"
                                    value="<?= $styles['btn_text_color'] ?? '#ffffff' ?>">
                                <input type="text" class="color-text"
                                    value="<?= $styles['btn_text_color'] ?? '#ffffff' ?>" readonly>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Z-Index Header</label>
                            <input type="number" name="z_header" class="text-input"
                                value="<?= $styles['z_header'] ?? 1000 ?>">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-save">Save Styles</button>

        </div>
    </form>

    <script>
        // Simple helper to update text inputs when color picker changes
        document.querySelectorAll('input[type="color"]').forEach(input => {
            input.addEventListener('input', (e) => {
                e.target.nextElementSibling.value = e.target.value;
            });
        });
    </script>

</body>

</html>