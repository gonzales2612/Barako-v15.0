<?php

namespace App\Controllers;

use App\Models\Inventory;

class InventoryController extends BaseController
{
    private $inventoryModel;

    public function __construct()
    {
        global $conn; 
        $this->inventoryModel = new Inventory($conn);
    }

    public function showInventory()
    {
        session_start();

        if (!isset($_SESSION['username'])) {
            header('Location: /login');
            exit;
        }

        $inventoryItems = $this->inventoryModel->getAllInventory();

        $data = [
            'title' => 'Inventory',
            'inventory' => $inventoryItems,
            'username' => $_SESSION['username'] ?? null,
            'firstname' => $_SESSION['firstname'] ?? null,
        ];

        echo $this->render('inventory', $data);
    }

    // Update menu item
    public function updateInventoryAjax()
{
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $type = $_POST['type'] ?? null;
    $price = $_POST['price'] ?? null;
    $image = $_POST['image'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if ($id && $name && $type && $price !== null && $quantity !== null) {
        $updateSuccess = $this->inventoryModel->updateInventory($id, $name, $type, $price, $image, $category_id, $quantity);

        // Send a proper JSON response
        echo json_encode(['status' => $updateSuccess ? 'success' : 'error']);
    } else {
        // Handle invalid input
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data received.']);
    }

    // Ensure no extra output
    exit;
}

// Delete menu item
public function deleteInventoryAjax()
{
    $id = $_POST['id'] ?? null;

    if ($id) {
        $deleteSuccess = $this->inventoryModel->deleteInventory($id);

        echo json_encode(['status' => $deleteSuccess ? 'success' : 'error']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    }
}
    public function addInventoryAjax()
{
    $name = $_POST['name'] ?? null;
    $type = $_POST['type'] ?? null;
    $price = $_POST['price'] ?? null;
    $image = $_POST['image'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if ($name && $type && $price && $quantity !== null) {
        $insertSuccess = $this->inventoryModel->addInventory($name, $type, $price, $image, $category_id, $quantity);

        if ($insertSuccess) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add menu item']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
    }
    
}
