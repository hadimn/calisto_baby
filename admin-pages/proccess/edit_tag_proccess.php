<?php
include_once '../classes/database.php';
include_once '../classes/tag.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "You must be logged in to edit a tag.";
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$tag = new Tag($db);

// Check if the tag ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $tag->tag_id = $_GET['id']; // Set the tag_id for the Tag object

    // Retrieve existing tag data
    $existing_tag = $tag->getById();
    if ($existing_tag) {
        // Tag found, set the form values with existing data
        $tag->name = $existing_tag['name'];
        $tag->description = $existing_tag['description'];
        $tag->image = $existing_tag['image']; // Keep the current image
    } else {
        $_SESSION['error'] = "Tag not found.";
        header("Location: index.php?file=tagspage.php");
        exit();
    }
} else {
    $_SESSION['error'] = "No tag ID provided.";
    header("Location: index.php?file=tagspage.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize the form input
    $tag->name = htmlspecialchars(trim($_POST['name']));
    $tag->description = htmlspecialchars(trim($_POST['description']));

    // Handle image upload (if a new image is uploaded)
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/tags/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_file_type, $allowed_types)) {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            header("Location: edit_tag.php?id=" . $tag->tag_id);
            exit();
        }

        // Validate image size (Max 5MB)
        if ($_FILES['image']['size'] > 5000000) {
            $_SESSION['error'] = "File size is too large. Maximum size is 5MB.";
            header("Location: edit_tag.php?id=" . $tag->tag_id);
            exit();
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $tag->image = $target_file; // Update image path with the new image
        } else {
            $_SESSION['error'] = "Failed to upload image.";
            header("Location: edit_tag.php?id=" . $tag->tag_id);
            exit();
        }
    } else {
        // If no new image is uploaded, retain the existing image
        $tag->image = $existing_tag['image'];
    }

    // Attempt to update the tag
    try {
        if ($tag->update()) {
            $_SESSION['success'] = "Tag updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update tag.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    }

    // Redirect back to the tags page
    header("Location: index.php?file=tagspage.php");
    exit();
}
?>