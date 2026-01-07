<?php
/**
 * User Model
 * 
 * This class handles all database interactions related to Users (Developers & Shop Owners).
 * It extends BaseModel to get access to the database connection ($this->conn).
 */
require_once 'models/BaseModel.php';

class User extends BaseModel
{

    /**
     * Login Function
     * 
     * Checks if a user exists and if the password is correct.
     * 
     * @param string $username The username entered.
     * @param string $password The plain text password entered.
     * @return array|false Returns the user data array if successful, or false if failed.
     */
    public function login($username, $password)
    {
        // 1. Prepare the SQL query
        // We use :username as a placeholder to prevent SQL Injection (Security).
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        // 2. Bind the value and execute
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // 3. Fetch the user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 4. Verify Password
        // If user exists, we check the password hash.
        if ($user) {
            // password_verify() checks if the plain text password matches the hash in DB.
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct! Return the user info (minus the password for safety).
                unset($user['password_hash']);
                return $user;
            }
        }

        // If user not found OR password wrong, return false.
        return false;
    }
}
?>