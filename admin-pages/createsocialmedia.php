<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}

require_once '../classes/database.php';
require_once '../classes/social-media.php';

$database = new Database();
$db = $database->getConnection();
$socialMedia = new SocialMedia($db);

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $platform = $_POST['platform'];
    $link = $_POST['link'];
    $icon_class = $_POST['icon_class'];
    $bg_color = $_POST['bg_color'];

    if ($socialMedia->addSocialMedia($platform, $link, $icon_class)) {
        $message = "Social media platform added successfully.";
    } else {
        $message = "Failed to add social media platform.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Social Media Platform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        ::placeholder {
            color: black !important;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Create Social Media Platform</h1>

        <?php if ($message): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <div class="row mb-3">
                <label for="platform" class="col-sm-2 col-form-label">Platform</label>
                <div class="col-sm-10">
                    <input type="text" name="platform" class="form-control" placeholder="e.g. Facebook, Instagram" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="link" class="col-sm-2 col-form-label">Link</label>
                <div class="col-sm-10">
                    <input type="url" name="link" class="form-control" placeholder="https://..." required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="icon_class" class="col-sm-2 col-form-label">Icon Class</label>
                <div class="col-sm-10">
                    <input type="text" name="icon_class" class="form-control" placeholder="e.g. fa fa-facebook" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="bg_color" class="col-sm-2 col-form-label">Background Color</label>
                <div class="col-sm-10">
                    <input type="color" name="bg_color" class="form-control form-control-color" value="#ffffff" title="Choose background color">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Add Platform</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
