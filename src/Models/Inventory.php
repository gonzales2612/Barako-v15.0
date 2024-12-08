<?php

namespace App\Models;

use PDO;

class Inventory extends BaseModel
{
    public function getAllInventory()
    {
        $sql = "SELECT * FROM menu";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update menu item
    public function updateInventory($id, $name, $type, $price, $image, $category_id, $quantity)
    {
        $sql = "UPDATE menu 
                SET Name = :name, Type = :type, Price = :price, Image = :image, 
                    category_id = :category_id, quantity = :quantity 
                WHERE Id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':quantity', $quantity);

        return $stmt->execute();
    }
// Delete menu item
public function deleteInventory($id)
{
    $sql = "DELETE FROM menu WHERE Id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

    public function addInventory($name, $type, $price, $image, $category_id, $quantity)
{
    $sql = "INSERT INTO menu (Name, Type, Price, Image, category_id, quantity) 
            VALUES (:name, :type, :price, :image, :category_id, :quantity)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':quantity', $quantity);

    return $stmt->execute();
}
}
