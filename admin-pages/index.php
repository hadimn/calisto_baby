<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
  header("Location: loginpage.php");
  exit();
}

// Store the last loaded file in session
if (isset($_GET['file'])) {
  $_SESSION['last_loaded_file'] = $_GET['file'];
}

// Get the last loaded file from session or default to homepage
$last_loaded_file = isset($_SESSION['last_loaded_file']) ? $_SESSION['last_loaded_file'] : 'dashboard.php';

if (!isset($_GET['file'])) {
  header("Location: index.php?file=$last_loaded_file");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Admin page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/icon-font.min.css">
  <link rel="stylesheet" href="css/style.css">


  <style>
    .floating-alert {
      position: fixed;
      /* Ensure it is positioned relative to the viewport */
      top: 20px;
      /* Adjust the distance from the top */
      right: 20px;
      /* Position it on the right side of the page */
      z-index: 1050;
      /* Ensure it is above other elements */
      max-width: 300px;
      /* Optional: Limit the width */
      width: auto;
    }


    .logout-button {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 1000;
    }
  </style>
</head>

<body>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <h1><a href="" class="logo">administration</a></h1>
      <ul class="list-unstyled components mb-5">
        <li <?php if ($last_loaded_file == 'dashboard.php')
              echo 'class="active"'; ?>><a class="text-decoration-none" href="?file=dashboard.php"
            data-file="dashboard.php"><span class="fa fa-home mr-3"></span> Dashboard</a></li>
        <li <?php if ($last_loaded_file == 'createproductpage.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=createproductpage.php" data-file="createproductpage.php"><span
              class="fa fa-cart-plus mr-3"></span>Create Products</a></li>
        <li <?php if ($last_loaded_file == 'productpage.php')
              echo 'class="active"'; ?>><a class="text-decoration-none" href="?file=productpage.php"
            data-file="productpage.php"><span class="fa fa-shopping-cart mr-3"></span>Products</a></li>
        <li <?php if ($last_loaded_file == 'createtagspage.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=createtagspage.php" data-file="productpage.php"><span
              class="fa fa-user-plus mr-3"></span>create tag</a></li>
        <li <?php if ($last_loaded_file == 'tagspage.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=tagspage.php" data-file="tagspage.php"><span
              class="fa fa-tag mr-3"></span>tags</a></li>
        <li <?php if ($last_loaded_file == 'socialMediaPage.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=socialMediaPage.php" data-file="socialMediaPage.php"><span
              class="fa fa-file-image-o mr-3"></span>Social Media</a></li>
        <li <?php if ($last_loaded_file == 'createsocialmedia.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=createsocialmedia.php" data-file="createsocialmedia.php"><span
              class="fa fa-file-image-o mr-3"></span>+ Social Media</a></li>
        <li <?php if ($last_loaded_file == 'shippingfeepage.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=shippingfeepage.php" data-file="shippingfeepage.php"><span
              class="fa fa-truck mr-3"></span>Delivery Fee</a></li>
        <li <?php if ($last_loaded_file == 'orderspage.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=orderspage.php&status=all" data-file="orderspage.php"><span
              class="fa fa-shopping-bag mr-3"></span>Orders</a></li>
        <li <?php if ($last_loaded_file == 'createbannermessages.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=createbannermessages.php&status=all" data-file="createbannermessages.php"><span
              class="fa fa-commenting mr-3"></span>Create B-Message</a></li>
        <li <?php if ($last_loaded_file == 'bannermessages.php')
              echo 'class="active"'; ?>><a class="text-decoration-none"
            href="?file=bannermessages.php&status=all" data-file="bannermessages.php"><span
              class="fa fa-comment mr-3"></span>Banner Message</a></li>
      </ul>
    </nav>

    <!-- error & success messages -->
    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger floating-alert" id="floatingAlert">
        <?php echo $_SESSION['error'];
        unset($_SESSION['error']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php elseif (isset($_SESSION['success'])): ?>
      <div class="alert alert-success floating-alert" id="floatingAlert">
        <?php echo $_SESSION['success'];
        unset($_SESSION['success']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>


    <a href="proccess/admin-logout.php" class="logout-button btn btn-danger btn-sm">
      <span class="fa fa-sign-out mr-1"></span> Logout
    </a>

    <div id="content" class="p-4 p-md-5 pt-5">
      <!-- error & success messages -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger floating-alert" id="floatingAlert">
          <?php echo $_SESSION['error'];
          unset($_SESSION['error']); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success floating-alert" id="floatingAlert">
          <?php echo $_SESSION['success'];
          unset($_SESSION['success']); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <!-- // Load the content of the last loaded file -->
      <?php
      if (file_exists($last_loaded_file)) {
        include($last_loaded_file);
      } else {
        echo "<p>Error: File not found.</p>";
      }
      ?>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

  <script>
    $(document).ready(function() {
      // Auto-dismiss floating alerts after 15 seconds
      setTimeout(function() {
        $("#floatingAlert").fadeOut('slow', function() {
          $(this).remove();
        });
      }, 15000);

      // Handle click event on sidebar links
      $(".list-unstyled a").click(function() {
        $(".list-unstyled li").removeClass("active");
        $(this).parent().addClass("active");
      });
    });
  </script>
</body>

</html>