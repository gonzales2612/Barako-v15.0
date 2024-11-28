<?php

namespace App\Models;

use PDO;

class Menu extends BaseModel
{
    public function getAllMenu()
{
    $sql = "
        SELECT menu.Id, menu.Name, menu.Price, menu.Image, categories.name AS CategoryName
        FROM menu 
        JOIN categories ON menu.category_id = categories.Id
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    // Fetch all rows as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
