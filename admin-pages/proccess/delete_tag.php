<?php
session_start();
include_once '../../classes/database.php';
include_once '../../classes/tag.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "You must be logged in to delete a tag.";
    header("Location: ../loginpage.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$tag = new Tag($db);

// Check if the tag ID is provided and valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $tag_id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Validate tag_id as an integer

    if ($tag_id === false) {
        $_SESSION['error'] = "Invalid tag ID.";
        header("Location: ../index.php?file=tagspage.php");
        exit();
    }

    $tag->tag_id = $tag_id; // Set the tag_id for the Tag object

    // Attempt to delete the tag
    try {
        if ($tag->delete()) {
            $_SESSION['success'] = "Tag deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete tag. It may still be associated with products.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "No tag ID provided.";
}

// Redirect back to the tags page
header("Location: ../index.php?file=tagspage.php");
exit();
?>