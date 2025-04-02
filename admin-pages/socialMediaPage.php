<?php
@include('proccess/socialmedia_proccess.php'); // Include the processing file for handling form submissions
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Social Media Page</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css"> <!-- Include Font Awesome -->

    <style>
        ::placeholder {
            color: black !important;
            opacity: 1; /* Ensures the color is fully applied */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Manage Social Media Platforms</h1>

        <!-- Form for Updating Social Media Links and Status -->
        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <?php
            $database = new Database();
            $db = $database->getConnection();
            $socialMedia = new SocialMedia($db);
            $platforms = $socialMedia->getAllSocialMedia();

            if ($platforms) {
                foreach ($platforms as $platform) {
                    echo '
                    <div class="row mb-3 align-items-center">
                        <div class="col-sm-2">
                            <i class="' . htmlspecialchars($platform['icon_class']) . ' fa-2x mr-3"></i>
                            <span class="fw-bold ms-2">' . htmlspecialchars($platform['platform']) . '</span>
                        </div>
                        <div class="col-sm-6">
                            <input type="url" name="links[' . $platform['social_id'] . ']" class="form-control" placeholder="Enter link" value="' . htmlspecialchars($platform['link']) . '">
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check">
                                <input type="checkbox" name="enabled[' . $platform['social_id'] . ']" class="form-check-input" id="enabled-' . $platform['social_id'] . '" ' . ($platform['enabled'] ? 'checked' : '') . '>
                                <label class="form-check-label" for="enabled-' . $platform['social_id'] . '">Enabled</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" name="update_social_media" class="btn btn-primary">Update</button>
                        </div>
                    </div>';
                }
            } else {
                echo '<p class="text-center">No social media platforms found.</p>';
            }
            ?>
        </form>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>