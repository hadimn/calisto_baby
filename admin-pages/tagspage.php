<?php
include_once '../classes/database.php';
include_once '../classes/tag.php';


// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "You must be logged in to view the tags.";
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$tag = new Tag($db);

// Fetch tags from the database
$tags = $tag->getAll(); // Assuming the `getAll` method fetches all the tags from the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags List</title>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Tags List</h2>
    
    <?php
    // Display any success or error messages
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>

<div class="list-group">
    <?php foreach ($tags as $tag_item): ?>
        <div class="list-group-item d-flex align-items-center border-bottom">
            <div class="me-3 mr-4" style="width: 80px; height: 80px;">
                <img src="<?php echo $tag_item['image']; ?>" class="img-fluid" alt="Tag Image" style="object-fit: cover; width: 100%; height: 100%; border-radius: 8px;">
            </div>
            <div class="d-flex flex-column flex-grow-1">
                <h5 class="mb-1"><?php echo htmlspecialchars($tag_item['name']); ?></h5>
                <p class="mb-2"><?php echo htmlspecialchars($tag_item['description']); ?></p>
                <small class="text-muted">Created on: <?php echo date("F j, Y", strtotime($tag_item['created_at'])); ?></small>
            </div>
            <div>
                <a href="index.php?file=edittagspage.php&id=<?php echo $tag_item['tag_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="proccess/delete_tag.php?id=<?php echo $tag_item['tag_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


</div>

</body>
</html>
