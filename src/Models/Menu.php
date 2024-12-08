<?php

namespace App\Models;

use PDO;

class Menu extends BaseModel
{
    public function getAllMenu()
    {
        // Updated query to include the category name
        $sql = "
            SELECT 
                menu.Id, 
                menu.Name, 
                menu.Type, 
                menu.Price, 
                menu.Image, 
                menu.category_id, 
                categories.name AS CategoryName
            FROM menu
            LEFT JOIN categories ON menu.category_id = categories.id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMenuByCategoryId($categoryId)
    {
        // Updated query to include the category name
        $sql = "
            SELECT 
                menu.Id, 
                menu.Name, 
                menu.Type, 
                menu.Price, 
                menu.Image, 
                menu.category_id,  
                categories.name AS CategoryName
            FROM menu
            LEFT JOIN categories ON menu.category_id = categories.id
            WHERE menu.category_id = :category_id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMenuById($id)
    {
        // Updated query to include the category name
        $sql = "
            SELECT 
                menu.Id, 
                menu.Name, 
                menu.Type, 
                menu.Price, 
                menu.Image, 
                menu.category_id, 
                categories.name AS CategoryName
            FROM menu
            LEFT JOIN categories ON menu.category_id = categories.id
            WHERE menu.Id = :id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTopRatedMenu() {
        $sql = "  SELECT m.*, AVG(r.rating) as average_rating 
                  FROM menu m 
                  LEFT JOIN ratings r ON m.Id = r.menu_item_id 
                  GROUP BY m.Id 
                  HAVING average_rating IS NOT NULL 
                  ORDER BY average_rating DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getMostOrderedMenu()
{
    $sql = "
        SELECT 
            menu.Id, 
            menu.Name, 
            menu.Price, 
            menu.Image, 
            menu.category_id, 
            categories.name AS CategoryName, 
            SUM(order_items.quantity) AS TotalOrdered
        FROM 
            menu
        LEFT JOIN 
            order_items ON menu.id = order_items.MenuitemId
        LEFT JOIN 
            categories ON menu.category_id = categories.id
        GROUP BY 
            menu.id
        ORDER BY 
            TotalOrdered DESC
        LIMIT 3
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateMenuQuantity($menuItemId, $quantity)
{
    $sql = "UPDATE menu SET quantity = quantity - :quantity WHERE Id = :menuItemId AND quantity >= :quantity";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':menuItemId', $menuItemId, PDO::PARAM_INT);
    $stmt->execute();
}

}
