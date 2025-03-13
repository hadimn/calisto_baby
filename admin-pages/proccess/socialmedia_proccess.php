<?php
include '../classes/database.php';
include '../classes/social-media.php';

$database = new Database();
$db = $database->getConnection();
$socialMedia = new SocialMedia($db);

// Update Social Media Links and Status
if (isset($_POST['update_social_media'])) {
    $links = $_POST['links'];
    $enabled = $_POST['enabled'];

    foreach ($links as $social_id => $link) {
        $is_enabled = isset($enabled[$social_id]) ? 1 : 0; // Check if the platform is enabled
        $socialMedia->updateSocialMedia($social_id, $link, $is_enabled);
    }

    echo "<script>alert('Social media updated successfully!');</script>";
}
?>