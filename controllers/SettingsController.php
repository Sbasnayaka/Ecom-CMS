<?php
/**
 * Settings Controller
 * Handles Gatekeeper, Developer Auth, Shop Configuration, and Global Styles.
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
        require_once 'models/User.php';
        $this->userModel = new User();
    }

    // 1. Gatekeeper / Main Entry
    public function index()
    {
        // If already authenticated
        if (isset($_SESSION['dev_access_granted']) && $_SESSION['dev_access_granted'] === true) {
            $this->redirect('settings/edit');
            return;
        }
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

            // Hardcoded Developer Password as requested
            // In production, this should be hashed, but for this specific requirement:
            if ($password === 'Asseminate@01') {
                $_SESSION['dev_access_granted'] = true;
                $this->redirect('settings/edit');
            } else {
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
        $this->checkAuth();

        // Get all settings
        $keys = [
            'shop_name',
            'shop_url',
            'shop_logo',
            'shop_qr',
            'shop_about',
            'currency_symbol',
            'shop_whatsapp'
        ];
        $settings = $this->settingModel->getMultiple($keys);

        // Get Shop Owner credentials
        $owner = $this->userModel->getByRole('owner');

        $this->view('admin/settings/form', [
            'title' => 'Shop Settings',
            'settings' => $settings,
            'owner' => $owner
        ]);
    }

    // 5. Update Settings (General & Owner)
    public function update()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Ecom-CMS/assets/uploads/";
            if (!is_dir($uploadDir))
                mkdir($uploadDir, 0777, true);

            // Handle Logo
            if (isset($_FILES['shop_logo']) && $_FILES['shop_logo']['error'] == 0) {
                $fileName = time() . '_logo_' . basename($_FILES['shop_logo']['name']);
                if (move_uploaded_file($_FILES['shop_logo']['tmp_name'], $uploadDir . $fileName)) {
                    $this->settingModel->set('shop_logo', "/Ecom-CMS/assets/uploads/" . $fileName);
                }
            }

            // Handle QR
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
                $this->userModel->updateOwnerProfile($ownerId, $newUsername, $newPass);
            }

            $this->redirect('settings/edit');
        }
    }

    // 6. Global Styles Page
    public function styles()
    {
        $this->checkAuth();

        // Fetch existing style settings or defaults
        $styleKeys = [
            'font_family',
            'h1_size',
            'h1_color',
            'body_size',
            'body_color',
            'primary_color',
            'secondary_color',
            'bg_color',
            'btn_radius',
            'btn_text_color',
            'btn_bg_color'
        ];
        $styles = $this->settingModel->getMultiple($styleKeys);

        $this->view('admin/settings/styles', [
            'title' => 'Global Styles',
            'styles' => $styles
        ]);
    }

    // 7. Save Styles
    public function updateStyles()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $val) {
                $this->settingModel->set($key, $val);
            }
            $this->redirect('settings/styles');
        }
    }

    private function checkAuth()
    {
        if (!isset($_SESSION['dev_access_granted']) || $_SESSION['dev_access_granted'] !== true) {
            $this->redirect('settings/index');
            exit;
        }
    }
}
?>