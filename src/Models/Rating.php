<?php

namespace App\Models;

use PDO;

class Rating extends BaseModel
{
    public function addRating($menuItemId, $rating)
    {
        $sql = "INSERT INTO ratings (menu_item_id, rating) VALUES (:menu_item_id, :rating)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':menu_item_id', $menuItemId, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getRatingForMenuItem($menuItemId)
    {
        // Query to get the average rating for a menu item
        $sql = "SELECT AVG(rating) AS average_rating FROM ratings WHERE menu_item_id = :menu_item_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':menu_item_id', $menuItemId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? round($result['average_rating'], 1) : 0;  // Return the average rating (rounded to 1 decimal place)
    }
}