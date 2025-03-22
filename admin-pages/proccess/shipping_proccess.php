<?php
@include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fee'])) {
    $fee = floatval($_POST['fee']);
    $database = new Database();
    $db = $database->getConnection();

    try {
        // Check if a fee already exists
        $query = "SELECT COUNT(*) AS count FROM shipping_fees";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row['count'] > 0) {
            // Update existing fee
            $query = "UPDATE shipping_fees SET fee = :fee";
        } else {
            // Insert new fee
            $query = "INSERT INTO shipping_fees (fee) VALUES (:fee)";
        }

        $stmt = $db->prepare($query);
        $stmt->bindParam(':fee', $fee, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success floating-alert' id='alert'>Delivery fee updated successfully!</div>";
            echo "<script>setTimeout(function() { document.getElementById('alert').style.display = 'none'; }, 2000);</script>";
        } else {
            echo "<div class='alert alert-danger' id='alert'>Failed to update Delivery fee.</div>";
            echo "<script>setTimeout(function() { document.getElementById('alert').style.display = 'none'; }, 2000);</script>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' id='alert'>Error: " . $e->getMessage() . "</div>";
        echo "<script>setTimeout(function() { document.getElementById('alert').style.display = 'none'; }, 2000);</script>";
    }
}
?>
