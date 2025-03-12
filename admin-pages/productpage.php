<?php
include "../classes/database.php";
include "../classes/product.php";

if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "You must be logged in to access this page.";
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$stmt = $product->getAll();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Created Products</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
        function confirmDelete(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = "proccess/delete_product_proccess.php?delete_id=" + productId;
            }
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h1>Created Products</h1>
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

        <div class="row">
            <?php foreach ($products as $productData): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($productData['image']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($productData['name']); ?>"
                            style="max-height: 200px; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($productData['name']); ?></h5>
                            <p class="card-text">
                                <?php echo htmlspecialchars(substr($productData['description'], 0, 50)); ?>...
                            </p>
                            <p class="card-text">Price:
                                <?php echo htmlspecialchars($productData['price']) . " " . htmlspecialchars($productData['currency']); ?>
                            </p>
                            <a href="index.php?file=updateproductpage.php&id=<?php echo $productData['product_id']; ?>"
                                class="btn btn-primary">Edit</a>
                            <button class="btn btn-danger"
                                onclick="confirmDelete(<?php echo $productData['product_id']; ?>)">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>