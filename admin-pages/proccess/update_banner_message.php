<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

require_once '../../classes/Database.php';
require_once '../../classes/banner_messages.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['message'])) {
    $database = new Database();
    $db = $database->getConnection();
    $banner = new BannerMessage($db);

    $id = (int)$_POST['id'];
    $message = trim($_POST['message']);
    if ($message !== '') {
        $stmt = $db->prepare("UPDATE banner_messages SET message = :message WHERE id = :id");
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            exit();
        }
    }
}
echo json_encode(['success' => false]);
