<?php
include('proccess/create_tag_proccess.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tag</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Create a New Tag</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"> <?php echo $message; ?> </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Create Tag</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>