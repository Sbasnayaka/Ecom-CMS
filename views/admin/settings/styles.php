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

            <!-- Typography -->
            <div class="style-card">
                <div class="card-header">Typography</div>

                <div class="control-group">
                    <label class="control-label">Font Family</label>
                    <select name="font_family" class="select-input">
                        <option value="Roboto" <?= ($styles['font_family'] ?? '') == 'Roboto' ? 'selected' : '' ?>>Roboto
                        </option>
                        <option value="Open Sans" <?= ($styles['font_family'] ?? '') == 'Open Sans' ? 'selected' : '' ?>
                            >Open Sans</option>
                        <option value="Montserrat" <?= ($styles['font_family'] ?? '') == 'Montserrat' ? 'selected' : '' ?>
                            >Montserrat</option>
                        <option value="Inter" <?= ($styles['font_family'] ?? '') == 'Inter' ? 'selected' : '' ?>>Inter
                        </option>
                    </select>
                </div>

                <div class="control-group">
                    <label class="control-label">Heading Color (H1-H6)</label>
                    <div class="color-picker-row">
                        <input type="color" name="h1_color" class="color-input"
                            value="<?= $styles['h1_color'] ?? '#000000' ?>">
                        <input type="text" class="color-text" value="<?= $styles['h1_color'] ?? '#000000' ?>" readonly>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Body Text Size (px)</label>
                    <div class="range-row">
                        <input type="range" min="10" max="24" class="range-slider"
                            value="<?= $styles['body_size'] ?? 14 ?>"
                            oninput="document.getElementById('bodySizeVal').value = this.value">
                        <input type="text" name="body_size" id="bodySizeVal" class="range-val"
                            value="<?= $styles['body_size'] ?? 14 ?>">
                    </div>
                </div>
            </div>

            <!-- Colors -->
            <div class="style-card">
                <div class="card-header">Colors</div>

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
                        <input type="text" class="color-text" value="<?= $styles['bg_color'] ?? '#ffffff' ?>" readonly>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="style-card">
                <div class="card-header">Buttons</div>

                <div class="control-group">
                    <label class="control-label">Corner Radius (px)</label>
                    <div class="range-row">
                        <input type="range" min="0" max="30" class="range-slider"
                            value="<?= $styles['btn_radius'] ?? 8 ?>"
                            oninput="document.getElementById('btnRadiusVal').value = this.value">
                        <input type="text" name="btn_radius" id="btnRadiusVal" class="range-val"
                            value="<?= $styles['btn_radius'] ?? 8 ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Button Background</label>
                    <div class="color-picker-row">
                        <input type="color" name="btn_bg_color" class="color-input"
                            value="<?= $styles['btn_bg_color'] ?? '#007aff' ?>">
                        <input type="text" class="color-text" value="<?= $styles['btn_bg_color'] ?? '#007aff' ?>"
                            readonly>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Button Text Color</label>
                    <div class="color-picker-row">
                        <input type="color" name="btn_text_color" class="color-input"
                            value="<?= $styles['btn_text_color'] ?? '#ffffff' ?>">
                        <input type="text" class="color-text" value="<?= $styles['btn_text_color'] ?? '#ffffff' ?>"
                            readonly>
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