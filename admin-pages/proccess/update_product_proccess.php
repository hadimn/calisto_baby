<?php
session_start();
include "../../classes/database.php";
include "../../classes/product.php";
include "../../classes/tag.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "You must be logged in to update a product.";
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$admin_id = $_SESSION['admin_id'];

function sanitize_input($data)
{
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product->product_id = sanitize_input($_POST['product_id']);
    $product->name = sanitize_input($_POST['name']);
    $product->description = sanitize_input($_POST['description']);
    $product->price = sanitize_input($_POST['price']);
    $product->new_price = sanitize_input($_POST['new_price']);
    $product->currency = sanitize_input($_POST['currency']);
    $product->popular = isset($_POST['popular']) ? 1 : 0;
    $product->best_deal = isset($_POST['best_deal']) ? 1 : 0;
    $product->on_sale = isset($_POST['on_sale']) ? 1 : 0;
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

    if (empty($product->name) || empty($product->description) || empty($product->price) || empty($product->currency)) {
        $_SESSION['error'] = "Please fill in all the required fields.";
        header("Location: ../index.php?file=updateproductpage.php&id=" . $product->product_id);
        exit();
    }

    if ($product->on_sale == 1 && empty($product->new_price)) {
        $_SESSION['error'] = "You Must add new price for on_sale products.";
        header("Location: ../index.php?file=productpage.php");
        exit();
    }

    if ($product->new_price > $product->price) {
        $_SESSION['error'] = "new price must be less than old price";
        header("Location: ../index.php?file=productpage.php");
        exit();
    }

    // Handle image upload if a new image is provided
    if (!empty($_FILES['image']['name'])) {
        $target_dir = 'uploads/';
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_file_type, $allowed_types)) {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            header("Location: ../index.php?file=updateproductpage.php&id=" . $product->product_id);
            exit();
        }

        if ($_FILES['image']['size'] > 5000000) {
            $_SESSION['error'] = "Sorry, your file is too large. Maximum size is 5MB.";
            header("Location: ../index.php?file=updateproductpage.php&id=" . $product->product_id);
            exit();
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $_SESSION['error'] = "Failed to upload image.";
            header("Location: ../index.php?file=updateproductpage.php&id=" . $product->product_id);
            exit();
        }

        $product->image = $target_file;
    } else {
        // If no new image uploaded, keep the old one.
        $old_product = $product->getById();
        $product->image = $old_product['image'];
    }

    // Correctly structure the sizes array
    $colors = $_POST['colors'];
    $sizes = $_POST['sizes'];
    $stocks = $_POST['stocks'];

    $product->sizes = [];
    for ($i = 0; $i < count($sizes); $i++) {
        $product->sizes[$sizes[$i]][$colors[$i]] = $stocks[$i];
    }

    try {
        if ($product->update($admin_id)) {
            // Handle tags
            if (!empty($tags)) {
                // Delete existing tags for the product
                $deleteTagsQuery = "DELETE FROM product_tags WHERE product_id = :product_id";
                $deleteTagsStmt = $db->prepare($deleteTagsQuery);
                $deleteTagsStmt->bindParam(":product_id", $product->product_id);
                $deleteTagsStmt->execute();

                // Insert new tags
                foreach ($tags as $tag_id) {
                    $insertTagQuery = "INSERT INTO product_tags (product_id, tag_id) VALUES (:product_id, :tag_id)";
                    $insertTagStmt = $db->prepare($insertTagQuery);
                    $insertTagStmt->bindParam(":product_id", $product->product_id);
                    $insertTagStmt->bindParam(":tag_id", $tag_id);
                    $insertTagStmt->execute();
                }
            }

            $_SESSION['success'] = "Product updated successfully.";
        } else {
            $_SESSION["error"] = "Unable to update product.";
            throw new Exception("Unable to update product.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        print($e->getMessage());
    }

    header("Location: ../index.php?file=productpage.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../index.php?file=updateproductpage.php&id=" . $product->product_id);
    exit();
}
