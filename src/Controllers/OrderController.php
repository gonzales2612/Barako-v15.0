<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Menu;
use PDO;

class OrderController extends BaseController
{
    private $orderModel;
    private $menuModel;

    public function __construct($conn = null)
    {
        $this->db = $conn ?: new PDO('mysql:host=localhost;dbname=barako', 'root', '');
        $this->orderModel = new Order($this->db);
        $this->menuModel = new Menu($this->db);
    }

    public function showOrders()
{
    // Get filter parameters from the URL query string
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;
    $minAmount = isset($_GET['min_amount']) ? $_GET['min_amount'] : null;
    $maxAmount = isset($_GET['max_amount']) ? $_GET['max_amount'] : null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;

    // Get orders with filters applied
    $orders = $this->orderModel->getFilteredOrders($startDate, $endDate, $minAmount, $maxAmount, $status);
    $monthlyOrders = $this->orderModel->getOrdersByMonth();

    foreach ($orders as &$order) {
        $order['isPending'] = $order['status'] === 'Pending';
        $order['isCompleted'] = $order['status'] === 'Completed';
    }

    // Pass JSON-encoded data for the chart
    echo $this->render('orders', [
        'title' => 'Orders',
        'orders' => $orders,
        'monthlyOrders' => json_encode($monthlyOrders), // Ensure this encodes as JSON
    ]);
}

    public function createOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerName = $_POST['customerName'];
            $orderDate = $_POST['orderDate'];
            $menuItemIds = $_POST['menuItemIds'];
            $quantities = $_POST['quantities'];
            $totalAmount = 0;

            foreach ($menuItemIds as $menuItemId) {
                $menuItem = $this->menuModel->getMenuById($menuItemId);

                if (!$menuItem) {
                    throw new Exception("Menu item with ID $menuItemId does not exist.");
                }

                $quantity = isset($quantities[$menuItemId]) ? intval($quantities[$menuItemId]) : 1;
                $totalAmount += $menuItem['Price'] * $quantity;
            }

            $orderId = $this->orderModel->createOrder($customerName, $totalAmount, $orderDate);

            foreach ($menuItemIds as $menuItemId) {
                $quantity = isset($quantities[$menuItemId]) ? intval($quantities[$menuItemId]) : 1;
                $subtotal = $menuItem['Price'] * $quantity;
                $this->orderModel->addMenuItemToOrder($orderId, $menuItemId, $quantity, $subtotal);
            }

            header('Location: /orders');
            exit();
        }
    }

    public function updateOrderStatus($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];

        if (!in_array($status, ['Pending', 'Completed'])) {
            throw new \Exception("Invalid status value.");
        }

        // Update the order status in the database
        $this->orderModel->updateOrderStatus($id, $status);

        // If the status is "Completed", update the menu quantities
        if ($status === 'Completed') {
            $orderItems = $this->orderModel->getOrderItemsByOrderId($id);

            foreach ($orderItems as $item) {
                $menuItemId = $item['MenuItemId'];
                $quantity = $item['Quantity'];

                // Subtract the quantity from the menu table
                $this->menuModel->updateMenuQuantity($menuItemId, $quantity);
            }
        }

        header('Location: /orders');
        exit();
    }
}

    public function removeOrder($id)
    {
        $this->orderModel->deleteOrderById($id);
        header('Location: /orders');
        exit();
    }

public function getFilteredOrders($startDate = null, $endDate = null, $minAmount = null, $maxAmount = null, $status = null)
{
    $sql = "
        SELECT 
            o.Id AS OrderId,
            o.CustomerName,
            o.OrderDate,
            o.TotalAmount,
            o.status,
            GROUP_CONCAT(CONCAT(m.Name, ' (', oi.Quantity, ')') ORDER BY oi.MenuItemId SEPARATOR ', ') AS MenuItemDetails
        FROM orders o
        JOIN order_items oi ON o.Id = oi.OrderId
        JOIN menu m ON oi.MenuItemId = m.Id
    ";

    $conditions = [];
    $params = [];

    if ($startDate) {
        $conditions[] = "o.OrderDate >= :startDate";
        $params[':startDate'] = $startDate;
    }
    if ($endDate) {
        $conditions[] = "o.OrderDate <= :endDate";
        $params[':endDate'] = $endDate;
    }
    if ($minAmount) {
        $conditions[] = "o.TotalAmount >= :minAmount";
        $params[':minAmount'] = $minAmount;
    }
    if ($maxAmount) {
        $conditions[] = "o.TotalAmount <= :maxAmount";
        $params[':maxAmount'] = $maxAmount;
    }
    if ($status) {
        $conditions[] = "o.status = :status";
        $params[':status'] = $status;
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $sql .= " GROUP BY o.Id";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function generateReceipt($id)
    {
        $order = $this->orderModel->getOrderById($id);

        if (!$order) {
            throw new \Exception("Order not found");
        }

        // Create a new FPDF instance
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Add receipt header
        $pdf->Cell(190, 10, "Order Receipt", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);

        // Add order details
        $pdf->Ln(10);
        $pdf->Cell(50, 10, "Order ID:", 0, 0);
        $pdf->Cell(100, 10, $order['OrderId'], 0, 1);

        $pdf->Cell(50, 10, "Customer Name:", 0, 0);
        $pdf->Cell(100, 10, $order['CustomerName'], 0, 1);

        $pdf->Cell(50, 10, "Order Date:", 0, 0);
        $pdf->Cell(100, 10, $order['OrderDate'], 0, 1);

        $pdf->Ln(5);
        $pdf->Cell(190, 10, "Menu Items", 0, 1, 'C');
        $pdf->Ln(5);

        // Add menu item details
        $menuItems = explode(', ', $order['MenuItemDetails']);
        foreach ($menuItems as $menuItem) {
            $pdf->Cell(190, 10, $menuItem, 0, 1);
        }

        $pdf->Ln(5);
        $pdf->Cell(50, 10, "Total Amount:", 0, 0);
        $pdf->Cell(100, 10, $order['TotalAmount'], 0, 1);

        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(190, 10, "Thank you for your order!", 0, 1, 'C');

        // Output the PDF
        $pdf->Output();
        exit();
    }

    public function showUpdateForm($id)
{
    // Fetch order details
    $order = $this->orderModel->getOrderById($id);

    if (!$order) {
        throw new \Exception("Order not found");
    }

    // Add status flags for the template
    $order['isPending'] = $order['status'] === 'Pending';
    $order['isCompleted'] = $order['status'] === 'Completed';

    // Render the update form
    echo $this->render('update-order', [
        'title' => 'Update Order Status',
        'OrderId' => $order['OrderId'],
        'isPending' => $order['isPending'],
        'isCompleted' => $order['isCompleted']
    ]);
}


}

