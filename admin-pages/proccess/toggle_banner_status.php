<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing ID']);
    exit();
}

require_once '../../classes/Database.php';
require_once '../../classes/banner_messages.php';

$database = new Database();
$db = $database->getConnection();
$banner = new BannerMessage($db);

if ($banner->toggleStatus($_POST['id'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'DB update failed']);
}
