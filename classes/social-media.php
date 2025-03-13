<?php
require_once 'Database.php'; // Ensure you have a database connection file

class SocialMedia {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add a new social media record
    public function addSocialMedia($platform, $link, $icon_class) {
        $sql = "INSERT INTO social_media (platform, link, icon_class, enabled) VALUES (?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([$platform, $link, $icon_class])) {
            return true;
        }
        return false;
    }

    // Update social media links and status
    public function updateSocialMedia($social_id, $link, $enabled) {
        $sql = "UPDATE social_media SET link = ?, enabled = ? WHERE social_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([$link, $enabled, $social_id])) {
            return true;
        }
        return false;
    }

    // Get all social media records
    public function getAllSocialMedia() {
        $sql = "SELECT * FROM social_media";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single social media record by ID
    public function getSocialMediaById($social_id) {
        $sql = "SELECT * FROM social_media WHERE social_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$social_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>