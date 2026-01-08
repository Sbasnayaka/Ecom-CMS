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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Handle Main Image
            $mainImagePath = '';
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Ecom-CMS/assets/uploads/";
            if (!is_dir($uploadDir))
                mkdir($uploadDir, 0777, true);

            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
                $fileName = time() . '_main_' . basename($_FILES['main_image']['name']);
                if (move_uploaded_file($_FILES['main_image']['tmp_name'], $uploadDir . $fileName)) {
                    $mainImagePath = $fileName;
                }
            }

            // 2. Handle Gallery Images
            $galleryPaths = [];
            if (isset($_FILES['gallery_images'])) {
                $files = $_FILES['gallery_images'];
                // Re-organize $_FILES array for iteration
                $count = count($files['name']);
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] == 0) {
                        $gFileName = time() . "_gal_{$i}_" . basename($files['name'][$i]);
                        if (move_uploaded_file($files['tmp_name'][$i], $uploadDir . $gFileName)) {
                            $galleryPaths[] = $gFileName;
                        }
                    }
                }
            }

            // 3. Handle Variations
            // Expecting POST['variations'] as array of strings "varId_valId" (e.g. "5_12")
            // Or however we set it up in the View JS.
            $formattedVars = [];
            if (isset($_POST['selected_variations'])) {
                // e.g. ["1_3", "1_4"] -> (Color_Red, Color_Blue)
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

            // 4. Create Data Array
            $data = [
                'title' => $_POST['title'],
                'sku' => $_POST['sku'],
                'price' => $_POST['price'],
                'sale_price' => $_POST['sale_price'] ?? null,
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id'],
                'size_guide_id' => $_POST['size_guide_id'] ?? null,
                'is_featured' => isset($_POST['is_featured']),
                'main_image' => $mainImagePath,
                'gallery_images' => $galleryPaths,
                'variations' => $formattedVars
            ];

            // 5. Save
            if ($this->productModel->create($data)) {
                // Return Success or Redirect
                // User wants loading screen, so we might return JSON and let JS redirect
                // But simplified MVC: Redirect
                $this->redirect('product/index');
            } else {
                echo "Error saving product.";
            }

        }
    }
}
?>