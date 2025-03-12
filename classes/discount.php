<?php
namespace Classes;
class Discount {
    private $conn;
    private $table_name = "discounts";

    public $discount_id;
    public $discount_code;
    public $amount;
    public $start_date;
    public $end_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Apply discount
    public function apply() {
        $query = "INSERT INTO " . $this->table_name . " (discount_code, amount, start_date, end_date) VALUES (:discount_code, :amount, :start_date, :end_date)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":discount_code", $this->discount_code);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Check if discount is valid
    public function isValid() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE discount_code = :discount_code AND start_date <= NOW() AND end_date >= NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":discount_code", $this->discount_code);
        $stmt->execute();

        return $stmt;
    }
}
?>
