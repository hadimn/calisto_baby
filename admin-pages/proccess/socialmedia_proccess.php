<?php
include '../classes/database.php';
include '../classes/social-media.php';

$database = new Database();
$db = $database->getConnection();
$socialMedia = new SocialMedia($db);

// Update Social Media Links, Status, and Background Color
if (isset($_POST['update_social_media'])) {
    $links = $_POST['links'];
    $enabled = $_POST['enabled'];
    $colors = $_POST['colors'];

    foreach ($links as $social_id => $link) {
        $is_enabled = isset($enabled[$social_id]) ? 1 : 0;
        $bg_color = $colors[$social_id];
        $socialMedia->updateSocialMedia($social_id, $link, $is_enabled, $bg_color);
    }

    echo "<script>alert('Social media updated successfully!');</script>";
}
?>