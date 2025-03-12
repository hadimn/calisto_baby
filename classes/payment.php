<?php
namespace Classes;
class Payment {
    private $conn;
    private $table_name = "payments";

    public $payment_id;
    public $order_id;
    public $amount;
    public $payment_method;
    public $status;
    public $payment_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new payment
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (order_id, amount, payment_method, status, payment_date) VALUES (:order_id, :amount, :payment_method, :status, :payment_date)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":payment_method", $this->payment_method);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":payment_date", $this->payment_date);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
