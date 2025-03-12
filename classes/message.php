<?php
namespace Classes;
class Message {
    private $conn;
    private $table_name = "messages";

    public $message_id;
    public $sender_id;
    public $receiver_id;
    public $message_content;
    public $timestamp;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Send a message
    public function send() {
        $query = "INSERT INTO " . $this->table_name . " (sender_id, receiver_id, message_content, timestamp) VALUES (:sender_id, :receiver_id, :message_content, :timestamp)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":sender_id", $this->sender_id);
        $stmt->bindParam(":receiver_id", $this->receiver_id);
        $stmt->bindParam(":message_content", $this->message_content);
        $stmt->bindParam(":timestamp", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
