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

        // Load the dashboard view
        // We will style this once we receive the Screenshot from the user.
        $this->view('admin/dashboard', ['title' => 'Dashboard - EcomCMS']);
    }
}
?>