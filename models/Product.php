<?php
/**
 * Product Model
 */
require_once 'models/BaseModel.php';

class Product extends BaseModel
{

    public function getAll()
    {
        // specific query to join categories
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteAll()
    {
        $sql = "DELETE FROM products";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }

    private function createSlug($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    /**
     * Get Featured Products
     */
    public function getFeatured($limit = 6)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_featured = 1 AND p.is_active = 1
                ORDER BY p.created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get Latest Products
     */
    public function getLatest($limit = 6)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_active = 1
                ORDER BY p.created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get On Sale Products
     */
    public function getOnSale($limit = 6)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.sale_price IS NOT NULL AND p.sale_price < p.price AND p.is_active = 1
                ORDER BY p.created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>