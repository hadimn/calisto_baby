<?php
@include('../classes/database.php');
@include('proccess/shipping_proccess.php');

// Fetch the current shipping fee from the database
$database = new Database();
$db = $database->getConnection();
$query = "SELECT fee FROM shipping_fees LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$current_fee = $row ? $row['fee'] : '0.00';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Shipping Fee</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Update delivery Fee</h1>

        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <div class="row mb-3">
                <label for="fee" class="col-sm-2 col-form-label">Delivery Fee</label>
                <div class="col-sm-10">
                    <input type="number" name="fee" class="form-control" step="any" value="<?php echo htmlspecialchars($current_fee); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Update Fee</button>
                </div>
            </div>
        </form>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
