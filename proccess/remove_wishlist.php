<?php
include '../classes/database.php';
include '../classes/wishlist.php';

session_start();

if ($_GET['product_id'] && $_SESSION['customer_id']) {
    $database = new Database();
    $db = $database->getConnection();
    $wishlist = new Wishlist($db);
    $wishlist->product_id = $_GET['product_id'];
    $wishlist->customer_id = $_SESSION['customer_id'];
    $wishlist->removeFromWishlist();

    header("Location: ../wishlist.php");
    exit();
}

session_abort();