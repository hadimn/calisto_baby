<?php
// proccess/logout-proccess.php

session_start();

// Destroy all session data
session_destroy();

// Redirect to the login page or any other desired page
header("Location: ../loginpage.php"); // Corrected redirect
exit();
?>