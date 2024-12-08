<?php

namespace App\Models;

use PDO;

class Category extends BaseModel
{
    public function getAllCategories()
    {
        $sql = "SELECT id, name FROM categories";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get the top-rated menu items
    public function getTopRatedMenu()
{
    $stmt = $this->db->prepare("SELECT * FROM menu ORDER BY avg_rating DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
