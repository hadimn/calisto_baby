<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}
?>

<h2>Dashboard</h2>
<p>Here is your dashboard overview.</p>