<?php
class BillingAddress
{
    private $conn;
    private $table_name = "billing_addresses";

    public $address_id;
    public $customer_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $address;
    public $country;
    public $city;
    public $additional_info;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get billing address by customer ID
    public function getByCustomer()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE customer_id = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create or update billing address
    public function save()
    {
        // Check if address exists
        $existing = $this->getByCustomer();

        if ($existing) {
            // Update existing address
            $query = "UPDATE " . $this->table_name . " SET 
                    first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    phone_number = :phone_number,
                    address = :address,
                    country = :country,
                    city = :city,
                    additional_info = :additional_info
                    WHERE customer_id = :customer_id";
        } else {
            // Create new address
            $query = "INSERT INTO " . $this->table_name . " 
                    (customer_id, first_name, last_name, email, phone_number, address, country, city, additional_info)
                    VALUES 
                    (:customer_id, :first_name, :last_name, :email, :phone_number, :address, :country, :city, :additional_info)";
        }

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":additional_info", $this->additional_info);

        return $stmt->execute();
    }
}
