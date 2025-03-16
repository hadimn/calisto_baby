<?php
class Customer
{
    private $conn;
    private $table_name = "customers_accounts";

    public $customer_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $address;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new customer
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, email, phone_number, address, password) VALUES (:first_name, :last_name, :email, :phone_number, :address, :password)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Find a customer by email
    public function findByEmail()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":email", $this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->customer_id = $row['customer_id'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->phone_number = $row['phone_number'];
            $this->address = $row['address'];
            $this->password = $row['password'];
            return true;
        }

        return false;
    }

    public function findById()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE customer_id = :customer_id LIMIT 1";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":customer_id", $this->customer_id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->email = $row['email'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->phone_number = $row['phone_number'];
            $this->address = $row['address'];
            $this->password = $row['password'];
            return true;
        }

        return false;
    }

    // Validate password
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    // Update customer details
    public function update($new_password = null, $current_password = null)
    {
        // Validate current password before updating
        if ($new_password && $current_password) {
            if (!password_verify($current_password, $this->password)) {
                return "incorrect_password"; // Current password is incorrect
            }
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        } else {
            $hashed_password = $this->password; // Keep old password if not updating
        }

        $query = "UPDATE " . $this->table_name . " 
              SET first_name = :first_name, 
                  last_name = :last_name, 
                  phone_number = :phone_number, 
                  address = :address, 
                  email = :email, 
                  password = :password
              WHERE customer_id = :customer_id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":customer_id", $this->customer_id);

        return $stmt->execute() ? "success" : "error";
    }
}
