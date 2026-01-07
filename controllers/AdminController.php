<?php
/**
 * Admin Controller
 * 
 * Handles the Developer/Shop Owner Dashboard.
 */
class AdminController extends BaseController
{

    /**
     * Dashboard Page
     */
    public function dashboard()
    {
        // Security Check: Must be logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        // Connect to DB to get stats
        $db = (new Database())->getConnection();

        // 1. Get Counts
        $stats = [
            'products' => $db->query("SELECT COUNT(*) FROM products")->fetchColumn(),
            'categories' => $db->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
            'feedbacks' => $db->query("SELECT COUNT(*) FROM reviews")->fetchColumn(),
            'size_guides' => 0 // Placeholder until we have this table
        ];

        // 2. Get Recent Products (Limit 5)
        // LEFT JOIN to get category name
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC LIMIT 5";
        $products = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        // Load the view
        $this->view('admin/dashboard', [
            'title' => 'Dashboard - EcomCMS',
            'stats' => $stats,
            'latest_products' => $products
        ]);
    }
}
?>