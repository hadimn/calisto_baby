<?php
// include_once '../classes/database.php';
// include_once '../classes/tag.php';

// $database = new Database();
// $db = $database->getConnection();

// $tag = new Tag($db);

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $tag->name = $_POST['name'];
//     $tag->description = $_POST['description'];
    
//     if (!empty($_FILES['image']['name'])) {
//         $target_dir = "uploads/tags/";
//         $target_file = $target_dir . basename($_FILES['image']['name']);
//         move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
//         $tag->image = $target_file;
//     }

//     if ($tag->create()) {
//         $message = "Tag created successfully.";
//     } else {
//         $message = "Unable to create tag.";
//     }
// }

include_once '../classes/database.php';
include_once '../classes/tag.php';


// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "You must be logged in to update a product.";
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$tag = new Tag($db);

$admin_id = $_SESSION['admin_id'];

// Function to sanitize inputs
function sanitize_input($data)
{
    return htmlspecialchars(trim($data));
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tag->name = sanitize_input($_POST['name']);
    $tag->description = sanitize_input($_POST['description']);
    
    // Validate required fields
    if (empty($tag->name) || empty($tag->description)) {
        $_SESSION['error'] = "Please fill in all the required fields.";
        header("Location: index.php");
        exit();
    }

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/tags/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_file_type, $allowed_types)) {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed for the image.";
            header("Location: index.php?file=createtagspage.php");
            exit();
        }

        // Validate image size
        if ($_FILES['image']['size'] > 5000000) {
            $_SESSION['error'] = "Sorry, your image file is too large. Maximum size is 5MB.";
            header("Location: index.php?file=createtagspage.php");
            exit();
        }

        // Move uploaded file
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $_SESSION['error'] = "Failed to upload image.";
            header("Location: index.php?file=createtagspage.php");
            exit();
        }

        $tag->image = $target_file;
    }

    try {
        // Create tag in database
        if ($tag->create()) {
            $_SESSION['success'] = "Tag created successfully.";
        } else {
            $_SESSION["error"] = "Unable to create tag.";
            throw new Exception("Unable to create tag.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        print($e->getMessage());
    }

    // Redirect to index page
    header("Location: index.php?file=createtagspage.php");
    exit();
}
?>