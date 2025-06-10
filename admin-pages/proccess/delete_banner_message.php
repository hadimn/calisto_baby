<?php
require_once '../../classes/Database.php';
require_once '../../classes/banner_messages.php';

header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing ID']);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$banner = new BannerMessage($db);

$id = intval($_POST['id']);
$success = $banner->delete($id);

echo json_encode(['success' => $success]);
