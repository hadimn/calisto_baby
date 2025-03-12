<?php
namespace Classes;
class PromoCode {
    private $conn;
    private $table_name = "promo_codes";

    public $promo_code;
    public $discount_percentage;
    public $valid_until;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Apply promo code
    public function apply() {
        $query = "INSERT INTO " . $this->table_name . " (promo_code, discount_percentage, valid_until) VALUES (:promo_code, :discount_percentage, :valid_until)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":promo_code", $this->promo_code);
        $stmt->bindParam(":discount_percentage", $this->discount_percentage);
        $stmt->bindParam(":valid_until", $this->valid_until);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Check if promo code is valid
    public function isValid() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE promo_code = :promo_code AND valid_until >= NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":promo_code", $this->promo_code);
        $stmt->execute();
        return $stmt;
    }
}
?>
