<?php

namespace App\Models;

use PDO;

class Order extends BaseModel
{
    public function getAllOrdersWithMenuNames()
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
            GROUP BY o.Id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOrder($customerName, $totalAmount, $orderDate)
    {
        $sql = "INSERT INTO orders (CustomerName, TotalAmount, OrderDate, status) VALUES (:customerName, :totalAmount, :orderDate, 'Pending')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customerName', $customerName);
        $stmt->bindParam(':totalAmount', $totalAmount);
        $stmt->bindParam(':orderDate', $orderDate);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function addMenuItemToOrder($orderId, $menuItemId, $quantity, $subtotal)
    {
        $sql = "INSERT INTO order_items (OrderId, MenuItemId, Quantity, Subtotal) VALUES (:orderId, :menuItemId, :quantity, :subtotal)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':menuItemId', $menuItemId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();
    }

    public function deleteOrderById($orderId)
{
    // Check if the order exists
    $sql = "SELECT COUNT(*) FROM orders WHERE Id = :orderId";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // Delete related order items
        $sql = "DELETE FROM order_items WHERE OrderId = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the order
        $sql = "DELETE FROM orders WHERE Id = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
    public function getOrdersByMonth()
    {
        $sql = "
            SELECT 
                DATE_FORMAT(OrderDate, '%Y-%m') AS Month, 
                COUNT(*) AS OrderCount
            FROM orders
            GROUP BY Month
            ORDER BY Month ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateOrderStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE Id = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
    }

    public function getTotalSalesByMonth()
    {
        $sql = "
            SELECT 
                DATE_FORMAT(OrderDate, '%Y-%m') AS month, 
                SUM(TotalAmount) AS total_sales
            FROM orders
            WHERE status = 'Completed'
            GROUP BY month
            ORDER BY month ASC;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

public function getAvailableMonthsAndYears()
{
    $sql = "
        SELECT 
            DATE_FORMAT(OrderDate, '%Y-%m') AS MonthYear
        FROM orders
        GROUP BY MonthYear
        ORDER BY MonthYear DESC
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTotalOrders()
{
    $sql = "SELECT COUNT(*) AS total_orders FROM orders";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];
}

public function getTotalSales()
{
    $sql = "SELECT SUM(TotalAmount) AS total_sales FROM orders WHERE status = 'Completed'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'];
}

public function getPendingOrders()
{
    $sql = "SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'Pending'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['pending_orders'];
}


public function getOrderById($orderId)
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
        WHERE o.Id = :orderId
        GROUP BY o.Id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getOrderItemsByOrderId($orderId)
{
    $sql = "SELECT MenuItemId, Quantity FROM order_items WHERE OrderId = :orderId";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}

