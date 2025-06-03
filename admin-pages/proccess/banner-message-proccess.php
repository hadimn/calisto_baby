<?php
@include('../classes/Database.php');
@include('../classes/banner_messages.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $banner = new BannerMessage($db);

    $message = trim($_POST['message']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $display_order = intval($_POST['display_order']);

    if ($banner->create($message, $is_active, $display_order)) {
        echo "<script>alert('Banner message created successfully.');</script>";
    } else {
        echo "<script>alert('Error creating banner message.');</script>";
    }
}
