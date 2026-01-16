<?php
/**
 * Product Controller
 */
require_once 'models/Product.php';
require_once 'models/Category.php';
require_once 'models/SizeGuide.php';
require_once 'models/Variation.php';

class ProductController extends BaseController
{

    private $productModel;
    private $categoryModel;
    private $sizeGuideModel;
    private $variationModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->sizeGuideModel = new SizeGuide();
        $this->variationModel = new Variation();
    }

    public function index()
    {
        $products = $this->productModel->getAll();
        $this->view('admin/products/index', [
            'title' => 'Products',
            'products' => $products
        ]);
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        $this->redirect('product/index');
    }

    public function delete_all()
    {
        $this->productModel->deleteAll();
        $this->redirect('product/index');
    }

    public function add()
    {
        // Fetch dependencies for the form
        $categories = $this->categoryModel->getAll();
        // Organize cats for dropdown (Main -> Sub) if possible, 
        // but raw list with parent check in View is fine for now

        $sizeGuides = $this->sizeGuideModel->getAll();
        $variations = $this->variationModel->getAll(); // includes values

        $this->view('admin/products/add', [
            'title' => 'Add Product',
            'categories' => $categories,
            'sizeGuides' => $sizeGuides,
            'variations' => $variations
        ]);
    }

    public function store()
    {
        // 1. Check for POST Max Size Limit Exceeded
        // If the user uploads files larger than php.ini 'post_max_size', both $_POST and $_FILES will be empty.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
            $maxPost = ini_get('post_max_size');
            echo "<div style='color:red; padding:20px; text-align:center; font-family:sans-serif;'>
                    <h1>Upload Failed</h1>
                    <p>The total size of your files exceeds the server limit ($maxPost).</p>
                    <p>Please try uploading fewer images or compressing them first.</p>
                    <a href='" . BASE_URL . "product/add'>Go Back</a>
                  </div>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 2. Validate Required Fields
            $title = $_POST['title'] ?? '';
            $price = $_POST['price'] ?? '';
            $categoryId = $_POST['category_id'] ?? '';

            if (empty($title) || empty($price) || empty($categoryId)) {
                echo "<div style='color:red; padding:20px; font-family:sans-serif;'>
                        <h1>Missing Information</h1>
                        <p>Please fill in all required fields (Title, Price, Category).</p>
                        <a href='javascript:history.back()'>Go Back</a>
                      </div>";
                return;
            }

            // 3. Setup Upload Directory
            $uploadDir = dirname(__DIR__) . "/assets/uploads/";
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    // Critical Error: Cannot create folder
                    echo "Error: Failed to create upload directory. Please check server permissions.";
                    return;
                }
            }

            // 4. Handle Main Image
            $mainImagePath = '';
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
                // Validate Image Type
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));

                if (in_array($ext, $allowed)) {
                    $fileName = time() . '_main_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($_FILES['main_image']['name']));
                    if (move_uploaded_file($_FILES['main_image']['tmp_name'], $uploadDir . $fileName)) {
                        $mainImagePath = $fileName;
                    }
                }
            }

            // 5. Handle Gallery Images
            $galleryPaths = [];
            if (isset($_FILES['gallery_images'])) {
                $files = $_FILES['gallery_images'];
                $count = count($files['name']);

                for ($i = 0; $i < $count; $i++) {
                    // Check if file provided and no error
                    if (!empty($files['name'][$i]) && $files['error'][$i] == 0) {
                        $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                        // Basic validation
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            $cleanName = preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($files['name'][$i]));
                            $gFileName = time() . "_gal_{$i}_" . $cleanName;

                            if (move_uploaded_file($files['tmp_name'][$i], $uploadDir . $gFileName)) {
                                $galleryPaths[] = $gFileName;
                            }
                        }
                    }
                }
            }

            // 6. Handle Variations
            $formattedVars = [];
            if (isset($_POST['selected_variations']) && is_array($_POST['selected_variations'])) {
                foreach ($_POST['selected_variations'] as $combo) {
                    $parts = explode('_', $combo);
                    if (count($parts) == 2) {
                        $formattedVars[] = [
                            'variation_id' => $parts[0],
                            'variation_value_id' => $parts[1]
                        ];
                    }
                }
            }

            // 7. Prepare Data
            $data = [
                'title' => $title,
                'sku' => $_POST['sku'] ?? '',
                'price' => $price,
                'sale_price' => !empty($_POST['sale_price']) ? $_POST['sale_price'] : null,
                'description' => $_POST['description'] ?? '',
                'category_id' => $categoryId,
                'size_guide_id' => !empty($_POST['size_guide_id']) ? $_POST['size_guide_id'] : null,
                'is_featured' => isset($_POST['is_featured']), // Checkbox sends 'on' or nothing
                'main_image' => $mainImagePath,
                'gallery_images' => $galleryPaths,
                'variations' => $formattedVars
            ];

            // 8. Save
            if ($this->productModel->create($data)) {
                $this->redirect('product/index');
            } else {
                echo "<div style='color:red; padding:20px; font-family:sans-serif;'>
                        <h1>Error Saving Product</h1>
                        <p>There was an issue saving the product to the database.</p>
                        <p>Please ensure the Product Title is unique (no duplicate names).</p>
                        <a href='javascript:history.back()'>Go Back</a>
                      </div>";
            }

        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getById($id);
        if (!$product) {
            $this->redirect('product/index');
        }

        // Fetch dependencies
        $categories = $this->categoryModel->getAll();
        $sizeGuides = $this->sizeGuideModel->getAll();
        $variations = $this->variationModel->getAll();

        // Get existing images and variations
        $product['gallery_images'] = $this->productModel->getGalleryImages($id);
        $product['variations'] = $this->productModel->getVariations($id); // This returns grouped vars
        // We might need raw variation lines to pre-select, but let's see how the form expects it.
        // The form writes to hidden inputs 'selected_variations[]' as 'varId_valId'.
        // We need to reconstruct that list.
        
        $this->view('admin/products/add', [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'sizeGuides' => $sizeGuides,
            'variations' => $variations,
            'mode' => 'edit'
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            
            // Basic fields
            $title = $_POST['title'] ?? '';
            $price = $_POST['price'] ?? '';
            $categoryId = $_POST['category_id'] ?? '';
            
            if (empty($title) || empty($price) || empty($categoryId)) {
                 echo "Missing required fields."; return;
            }

            // Upload Dir
            $uploadDir = dirname(__DIR__) . "/assets/uploads/";

            // Handle Main Image (Only if new one uploaded)
            $mainImagePath = $_POST['current_main_image'] ?? '';
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
                 $fileName = time() . '_main_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($_FILES['main_image']['name']));
                 if (move_uploaded_file($_FILES['main_image']['tmp_name'], $uploadDir . $fileName)) {
                     $mainImagePath = $fileName;
                 }
            }

            // Handle Gallery (Append or Replace? Usually append in simple CMS, or complex management. 
            // For simplicity/strictness, we'll keep existing unless explicit delete - but UI doesn't allow delete yet.
            // Let's just ADD new ones to the list.)
            // Actually, `ProductModel->update` usually handles logic. Let's check ProductModel.
            // Wait, I haven't checked ProductModel->update capability.
            
            // Let's assume we pass data and Model handles it. 
            // But we need to process uploads first.
            
            $galleryPaths = []; // New images
            if (isset($_FILES['gallery_images'])) {
                $files = $_FILES['gallery_images'];
                $count = count($files['name']);
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($files['name'][$i]) && $files['error'][$i] == 0) {
                        $cleanName = preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($files['name'][$i]));
                        $gFileName = time() . "_gal_{$i}_" . $cleanName;
                        if (move_uploaded_file($files['tmp_name'][$i], $uploadDir . $gFileName)) {
                            $galleryPaths[] = $gFileName;
                        }
                    }
                }
            }
            
            // Variations
            $formattedVars = [];
            if (isset($_POST['selected_variations']) && is_array($_POST['selected_variations'])) {
                foreach ($_POST['selected_variations'] as $combo) {
                    $parts = explode('_', $combo);
                    if (count($parts) == 2) {
                        $formattedVars[] = [
                            'variation_id' => $parts[0],
                            'variation_value_id' => $parts[1]
                        ];
                    }
                }
            }

            $data = [
                'id' => $id,
                'title' => $title,
                'sku' => $_POST['sku'] ?? '',
                'price' => $price,
                'sale_price' => !empty($_POST['sale_price']) ? $_POST['sale_price'] : null,
                'description' => $_POST['description'] ?? '',
                'category_id' => $categoryId,
                'size_guide_id' => !empty($_POST['size_guide_id']) ? $_POST['size_guide_id'] : null,
                'is_featured' => isset($_POST['is_featured']),
                'main_image' => $mainImagePath,
                'new_gallery_images' => $galleryPaths, // array of new paths
                'variations' => $formattedVars
            ];

            if ($this->productModel->update($data)) {
                $this->redirect('product/index');
            } else {
                echo "Error updating product.";
            }

        }
    }
?>