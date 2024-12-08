<?php

namespace App\Models;

use PDO;

class ContactMessage extends BaseModel
{
    public function saveMessage($name, $email, $message)
    {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        // Execute the query
        $stmt->execute();
    }
}
