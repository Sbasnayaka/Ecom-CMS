<?php
/**
 * Product Model
 */
require_once 'models/BaseModel.php';

class Product extends BaseModel
{

    public function create($data)
    {
        try {
            $this->conn->beginTransaction();

            // 1. Insert Core Product
            $sql = "INSERT INTO products (
                title, slug, sku, price, sale_price, description, 
                main_image, is_featured, category_id, size_guide_id
            ) VALUES (
                :title, :slug, :sku, :price, :sale_price, :description, 
                :main_image, :is_featured, :category_id, :size_guide_id
            )";

            $stmt = $this->conn->prepare($sql);

            $slug = $this->createSlug($data['title']);
            // Avoid duplicate slug collision by appending timestamp if needed, 
            // but for now simple slug.

            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':price', $data['price']);

            // Handle optional fields
            $salePrice = !empty($data['sale_price']) ? $data['sale_price'] : null;
            $stmt->bindParam(':sale_price', $salePrice);

            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':main_image', $data['main_image']);

            $isFeatured = isset($data['is_featured']) ? 1 : 0;
            $stmt->bindParam(':is_featured', $isFeatured);

            $stmt->bindParam(':category_id', $data['category_id']);

            $sizeGuideId = !empty($data['size_guide_id']) ? $data['size_guide_id'] : null;
            $stmt->bindParam(':size_guide_id', $sizeGuideId);

            $stmt->execute();
            $productId = $this->conn->lastInsertId();

            // 2. Insert Gallery Images
            if (!empty($data['gallery_images'])) {
                $sqlImg = "INSERT INTO product_images (product_id, image_path) VALUES (:pid, :path)";
                $stmtImg = $this->conn->prepare($sqlImg);

                foreach ($data['gallery_images'] as $path) {
                    $stmtImg->bindParam(':pid', $productId);
                    $stmtImg->bindParam(':path', $path);
                    $stmtImg->execute();
                }
            }

            // 3. Insert Variation Links
            // Expecting data['variations'] to be array of [variation_id, variation_value_id]
            if (!empty($data['variations'])) {
                $sqlVar = "INSERT INTO product_variations (product_id, variation_id, variation_value_id) VALUES (:pid, :vid, :vvid)";
                $stmtVar = $this->conn->prepare($sqlVar);

                foreach ($data['variations'] as $var) {
                    $stmtVar->bindParam(':pid', $productId);
                    $stmtVar->bindParam(':vid', $var['variation_id']);
                    $stmtVar->bindParam(':vvid', $var['variation_value_id']);
                    $stmtVar->execute();
                }
            }

            $this->conn->commit();
            return $productId;

        } catch (Exception $e) {
            $this->conn->rollBack();
            // Log error in production
            return false;
        }
    }

    private function createSlug($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
}
?>