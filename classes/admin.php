<?php
// namespace Classes;
class Admin {
    private $conn;
    private $table_name = "admin";

    public $admin_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new admin account
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_DEFAULT)); // Hash password

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get all admins
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // get admin by email
    public function getAdminByEmail($email){
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>