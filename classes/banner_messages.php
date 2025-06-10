<?php
class BannerMessage
{
    private $conn;
    private $table = "banner_messages";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($message, $is_active = 1, $display_order = 0)
    {
        $query = "INSERT INTO {$this->table} (message, is_active, display_order) VALUES (:message, :is_active, :display_order)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":message", $message);
        $stmt->bindParam(":is_active", $is_active, PDO::PARAM_INT);
        $stmt->bindParam(":display_order", $display_order, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY display_order ASC, created_at DESC";
        return $this->conn->query($query);
    }

    public function getAllActive()
    {
        $query = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC";
        return $this->conn->query($query);
    }


    public function toggleStatus($id)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET is_active = 1 - is_active WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateOrder($id, $order)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET display_order = ? WHERE id = ?");
        return $stmt->execute([$order, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
