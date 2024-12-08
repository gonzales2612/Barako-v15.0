<?php

namespace App\Models;

use App\Models\BaseModel;

class Superuser extends BaseModel
{
    // Method to validate superuser credentials
    public function validateSuperuser($username, $password)
    {
        // Prepare the SQL query to fetch the superuser by username
        $stmt = $this->db->prepare("SELECT * FROM superusers WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch the superuser record
        $superuser = $stmt->fetch();

        // Verify if the user exists and check the password
        if ($superuser) {
            // No need for password hashing, just compare plain text
            if ($superuser['password'] === $password) {
                return true;  // Credentials are valid
            }
        }

        return false;  // Credentials are invalid
    }

    // Method to retrieve a superuser by their username
    public function getSuperuserByUsername($username)
    {
        // Prepare the SQL query to fetch the superuser by username
        $stmt = $this->db->prepare("SELECT * FROM superusers WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch and return the superuser record
        return $stmt->fetch();
    }
}
