<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

require_once '../../classes/Database.php';
require_once '../../classes/banner_messages.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    $database = new Database();
    $db = $database->getConnection();
    $banner = new BannerMessage($db);
    $success = true;

    foreach ($_POST['order'] as $item) {
        $id = (int)($item['id'] ?? 0);
        $order = (int)($item['order'] ?? 0);
        if (!$banner->updateOrder($id, $order)) {
            $success = false;
            break;
        }
    }

    echo json_encode(['success' => $success]);
    exit();
}

echo json_encode(['success' => false, 'error' => 'Invalid request']);
