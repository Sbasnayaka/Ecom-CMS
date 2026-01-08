<?php
/**
 * Settings Controller
 * Handles Gatekeeper, Developer Auth, and Shop Configuration.
 */
require_once 'models/Setting.php';
require_once 'models/User.php';

class SettingsController extends BaseController
{

    private $settingModel;
    private $userModel;

    public function __construct()
    {
        $this->settingModel = new Setting();
        // We'll lazy load User model if needed or assuming separate auth check
        // Ideally we should have a User model, if not I'll query directly or create it.
        // Assuming User.php exists based on search result.
        require_once 'models/User.php';
        $this->userModel = new User();
    }

    // 1. Gatekeeper / Main Entry
    public function index()
    {
        // If already authenticated as developer for this session scope (flag set)
        if (isset($_SESSION['dev_access_granted']) && $_SESSION['dev_access_granted'] === true) {
            $this->redirect('settings/edit');
            return;
        }

        // Otherwise show Gatekeeper
        $this->view('admin/settings/gatekeeper', ['title' => 'Settings - Authenticate']);
    }

    // 2. Show Login Form
    public function login()
    {
        $this->view('admin/settings/login', ['title' => 'Settings - Login']);
    }

    // 3. Process Login
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';

            // Verify against 'admin' user in DB (role='developer')
            // Using User model's verification if available, or manual check for 'admin'

            // For this specific flow, let's look up the user with role 'developer'
            $devUser = $this->userModel->getByUsername('admin');
            // Or get by role. Assuming 'admin' is the dev username from SQL dump.

            if ($devUser && password_verify($password, $devUser['password_hash'])) {
                // Success
                $_SESSION['dev_access_granted'] = true;
                $this->redirect('settings/edit');
            } else {
                // Fail
                $this->view('admin/settings/login', [
                    'title' => 'Settings - Login',
                    'error' => 'Incorrect Password. Please try again.'
                ]);
            }
        }
    }

    // 4. Show The Form (Restricted)
    public function edit()
    {
        if (!isset($_SESSION['dev_access_granted']) || $_SESSION['dev_access_granted'] !== true) {
            $this->redirect('settings/index'); // Back to gatekeeper
            return;
        }

        // Get all settings
        $keys = [
            'shop_name',
            'shop_url',
            'shop_logo',
            'shop_qr',
            'shop_about',
            'currency_symbol',
            'shop_whatsapp',
            'social_fb',
            'social_tiktok',
            'social_insta',
            'social_youtube',
            'social_whatsapp'
        ];
        $settings = $this->settingModel->getMultiple($keys);

        // Get Shop Owner credentials to show (for editing)
        // Assuming we have one main 'owner' account.
        // We can fetch by role='owner' LIMIT 1
        $owner = $this->userModel->getByRole('owner'); // Helper method I'll add or use raw sql if needed

        $this->view('admin/settings/form', [
            'title' => 'Shop Settings',
            'settings' => $settings,
            'owner' => $owner
        ]);
    }

    // 5. Update Settings
    public function update()
    {
        if (!isset($_SESSION['dev_access_granted'])) {
            $this->redirect('settings/index');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Handle Images
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Ecom-CMS/assets/uploads/";
            if (!is_dir($uploadDir))
                mkdir($uploadDir, 0777, true);

            // Logo
            if (isset($_FILES['shop_logo']) && $_FILES['shop_logo']['error'] == 0) {
                $fileName = time() . '_logo_' . basename($_FILES['shop_logo']['name']);
                if (move_uploaded_file($_FILES['shop_logo']['tmp_name'], $uploadDir . $fileName)) {
                    $this->settingModel->set('shop_logo', "/Ecom-CMS/assets/uploads/" . $fileName);
                }
            }

            // QR
            if (isset($_FILES['shop_qr']) && $_FILES['shop_qr']['error'] == 0) {
                $fileName = time() . '_qr_' . basename($_FILES['shop_qr']['name']);
                if (move_uploaded_file($_FILES['shop_qr']['tmp_name'], $uploadDir . $fileName)) {
                    $this->settingModel->set('shop_qr', "/Ecom-CMS/assets/uploads/" . $fileName);
                }
            }

            // Text Fields
            $textFields = ['shop_name', 'shop_url', 'shop_about', 'currency_symbol', 'shop_whatsapp'];
            foreach ($textFields as $field) {
                if (isset($_POST[$field])) {
                    $this->settingModel->set($field, $_POST[$field]);
                }
            }

            // Owner Credentials Update
            $ownerId = $_POST['owner_id'] ?? null;
            $newUsername = $_POST['owner_username'] ?? '';
            $newPass = $_POST['owner_password'] ?? '';

            if ($ownerId && !empty($newUsername)) {
                // Update username
                // Logic to update username in DB...
                // Only if password provided, hash and update it too
                $this->userModel->updateOwnerProfile($ownerId, $newUsername, $newPass);
            }

            $this->redirect('settings/edit');
        }
    }
}
?>