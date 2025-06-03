<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}
@include('proccess/banner-message-proccess.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Banner Message</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        ::placeholder {
            color: black !important;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Create Banner Message</h1>

        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <!-- Message Text -->
            <div class="row mb-3">
                <label for="message" class="col-sm-2 col-form-label">Message</label>
                <div class="col-sm-10">
                    <textarea name="message" class="form-control" rows="3" required></textarea>
                </div>
            </div>

            <!-- Active Toggle -->
            <div class="row mb-3">
                <label for="is_active" class="col-sm-2 col-form-label">Active?</label>
                <div class="col-sm-10">
                    <input type="checkbox" name="is_active" value="1" checked>
                </div>
            </div>

            <!-- Display Order -->
            <div class="row mb-3">
                <label for="display_order" class="col-sm-2 col-form-label">Display Order</label>
                <div class="col-sm-10">
                    <input type="number" name="display_order" class="form-control" value="0" min="0">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Save Message</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
