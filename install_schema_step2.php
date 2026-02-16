<?php
// Load Database Configuration
require_once 'config/db.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // SQL to create the pivot table (Corrected: No markdown artifacts)
    $sql = "CREATE TABLE IF NOT EXISTS `product_categories` (
        `product_id` int(11) NOT NULL,
        `category_id` int(11) NOT NULL,
        PRIMARY KEY (`product_id`, `category_id`),
        KEY `category_id` (`category_id`),
        CONSTRAINT `fk_pc_product` FOREIGN KEY (`product_id`) REFERENCES `products` ([id](cci:2://file:///C:/Users/sandu/OneDrive/Desktop/Ecom-CMS/models/SizeGuide.php:6:0-42:1)) ON DELETE CASCADE,
        CONSTRAINT `fk_pc_category` FOREIGN KEY (`category_id`) REFERENCES `categories` ([id](cci:2://file:///C:/Users/sandu/OneDrive/Desktop/Ecom-CMS/models/SizeGuide.php:6:0-42:1)) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $db->exec($sql);
    echo "<h1>Success!</h1><p>Table 'product_categories' created successfully.</p>";
    echo "<p>You can now delete this file.</p>";

} catch (Exception $e) {
    echo "<h1>Error</h1><p>" . $e->getMessage() . "</p>";
}
?>
