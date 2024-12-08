<?php

namespace App\Controllers;
use App\Models\Order;
use PDO;

class AdminController extends BaseController
{
    private $orderModel;

    public function __construct($conn = null)
    {
        $this->db = $conn ?: new PDO('mysql:host=localhost;dbname=barako', 'root', '');
        $this->orderModel = new Order($this->db);
    }

    public function __checkSession()
    {
        session_start();

        // Check if superuser is logged in
        if (!isset($_SESSION['superuser']) || $_SESSION['superuser'] !== true) {
            // Redirect to login page if not logged in
            header('Location: /login');
            exit;
        }
    }

    public function showAdminPage()
    {
        $this->__checkSession();

        // Render the admin page (add your actual view file)
        require_once 'views/admin-dashboard.mustache';
    }

    public function index()
    {
        $this->__checkSession(); // Ensure the user is logged in

        $orders = $this->orderModel->getAllOrdersWithMenuNames();
        $monthlyOrders = $this->orderModel->getOrdersByMonth();
        $totalSalesByMonth = $this->orderModel->getTotalSalesByMonth();

        // Get stats for sidebar
        $totalOrders = $this->orderModel->getTotalOrders();
        $totalSales = $this->orderModel->getTotalSales();
        $pendingOrders = $this->orderModel->getPendingOrders();

        // Handle logout
        if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
            session_unset();
            session_destroy();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }
            header('Location: /login');
            exit;
        }

        // Get the username from session if logged in
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

        // Pass data to the view
        echo $this->render('admin-dashboard', [
            'username' => $username,  // Pass the username to the view
            'title' => 'Admin Dashboard',
            'orders' => $orders,
            'monthlyOrders' => json_encode($monthlyOrders),
            'totalSalesByMonth' => json_encode($totalSalesByMonth),
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}
