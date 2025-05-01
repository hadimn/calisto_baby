<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}
include 'proccess/edit_tag_proccess.php';

// Check if the tag ID exists in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $tag->tag_id = $_GET['id'];
    $existing_tag = $tag->getById(); // Retrieve existing tag details
    if (!$existing_tag) {
        $_SESSION['error'] = "Tag not found.";
        header("Location: ../index.php?file=tagspage.php");
        exit();
    }
} else {
    $_SESSION['error'] = "No tag ID provided.";
    header("Location: ../index.php?file=tagspage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tag</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Edit Tag</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?> </div>
        <?php elseif (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($existing_tag['name']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($existing_tag['description']); ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="image" name="image">
                    <?php if (!empty($existing_tag['image'])): ?>
                        <small class="form-text text-muted">Current image: <img src="<?php echo $existing_tag['image']; ?>" alt="Current Image" style="max-width: 100px; height: auto;"></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Update Tag</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
