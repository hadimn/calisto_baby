<?php
include "../classes/database.php";
include "../classes/product.php";

if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "You must be logged in to access this page.";
    header("Location: loginpage.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

if (isset($_GET['id'])) {
    $product->product_id = $_GET['id'];
    $productData = $product->getById();
    $sizesAndColors = $product->getSizesAndColors();

    if (!$productData) {
        $_SESSION['error'] = "Product not found.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Product ID not provided.";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Update Product</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icon-font.min.css">
    <style>
        ::placeholder {
            color: black !important;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Update Product</h1>

        <form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light"
            action="proccess/update_product_proccess.php?id=<?= $product->product_id ?>">
            <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">

            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Product Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control"
                        value="<?php echo htmlspecialchars($productData['name']); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" class="form-control" rows="4"
                        required><?php echo htmlspecialchars($productData['description']); ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="price" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="number" name="price" class="form-control" step="any"
                        value="<?php echo htmlspecialchars($productData['price']); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="currency" class="col-sm-2 col-form-label">Currency</label>
                <div class="col-sm-10">
                    <select name="currency" class="form-control" required>
                        <option value="USD" <?php echo ($productData['currency'] == 'USD') ? 'selected' : ''; ?>>USD
                        </option>
                        <option value="LBP" <?php echo ($productData['currency'] == 'LBP') ? 'selected' : ''; ?>>LBP
                        </option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" name="image" class="form-control">
                    <img src="<?php echo htmlspecialchars($productData['image']); ?>" alt="Current Product Image"
                        style="max-width: 100px; margin-top: 10px;">
                </div>
            </div>

            <!-- <div class="row mb-3">
                <label for="popular" class="col-sm-2 col-form-label">Is this product popular?</label>
                <div class="col-sm-10">
                    <input type="checkbox" name="popular" class="form-check-input" <?php echo ($productData['popular'] == 1) ? 'checked' : ''; ?>>
                </div>
            </div> -->

            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="form-check border p-2 rounded">
                        <input type="checkbox" class="form-check-input" id="popular" name="popular" <?php echo ($productData['popular'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="popular">Popular</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check border p-2 rounded">
                        <input type="checkbox" class="form-check-input" id="best-deal" name="best_deal" <?php echo ($productData['best_deal'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="best-deal">Best Deal?</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check border p-2 rounded">
                        <input type="checkbox" class="form-check-input" id="on-sale" name="on_sale" <?php echo ($productData['on_sale'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="on-sale">on-sale?</label>
                    </div>
                </div>
                <!-- New Price Field (Hidden by Default) -->
                <div class="row mb-3" id="new-price-field" style="display:<?php if ($productData['on_sale'] == 0) {
                                                                                echo 'none;';
                                                                            } else {
                                                                                echo 'flex;';
                                                                            } ?>">
                    <label for="new_price" class="col-sm-2 col-form-label">New Price</label>
                    <div class="col-sm-10">
                        <input type="number" name="new_price" class="form-control" step="any" value="<?php echo htmlspecialchars($productData['new_price']); ?>">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Colors, Sizes & Stock</label>
                <div class="col-sm-10">
                    <div id="color-size-fields">
                        <?php
                        $count = 1;
                        foreach ($sizesAndColors as $item) {
                            echo '<div class="color-size-field mb-2 d-flex align-items-center">';
                            echo '<label class="fw-bold me-2">' . $count . '.</label>';
                            echo '<input type="text" name="colors[]" class="form-control d-inline-block w-25" placeholder="Color (e.g., Red, Blue)" value="' . htmlspecialchars($item['color']) . '" required>';
                            echo '<input type="text" name="sizes[]" class="form-control d-inline-block w-25" placeholder="Size (e.g., S, M, L)" value="' . htmlspecialchars($item['size']) . '" required>';
                            echo '<input type="number" name="stocks[]" class="form-control d-inline-block w-25" placeholder="Stock for this size" value="' . htmlspecialchars($item['stock']) . '" required>';
                            echo '<button type="button" class="btn btn-danger btn-sm ms-2 remove-field">X</button>';
                            echo '</div>';
                            $count++;
                        }
                        ?>
                    </div>
                    <button type="button" id="add-color-size" class="btn btn-secondary mt-2">Add Another Color &
                        Size</button>
                </div>
            </div>

            <!-- tags section -->
            <div class="row mb-3">
                <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                <div class="col-sm-10">
                    <select name="tags[]" class="form-control" multiple>
                        <?php
                        include "../classes/tag.php";
                        $tag = new Tag($db);
                        $allTags = $tag->getAll()->fetchAll(PDO::FETCH_ASSOC);

                        // Get the current tags for the product
                        $currentTags = $product->getTags();

                        foreach ($allTags as $tag) {
                            $selected = in_array($tag['tag_id'], array_column($currentTags, 'tag_id')) ? 'selected' : '';
                            echo '<option value="' . $tag['tag_id'] . '" ' . $selected . '>' . $tag['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </div>
        </form>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle New Price Field Visibility
        document.getElementById('on-sale').addEventListener('change', function() {
            var newPriceField = document.getElementById('new-price-field');
            if (this.checked) {
                newPriceField.style.display = 'flex'; // Show the new price field
            } else {
                newPriceField.style.display = 'none'; // Hide the new price field
            }
        });

        document.getElementById('add-color-size').addEventListener('click', function() {
            var colorSizeFields = document.getElementById('color-size-fields');
            var fieldCount = colorSizeFields.children.length + 1;

            var newField = document.createElement('div');
            newField.classList.add('color-size-field', 'mb-2', 'd-flex', 'align-items-center');
            newField.innerHTML = `
            <label class="fw-bold me-2">${fieldCount}.</label>
            <input type="text" name="colors[]" class="form-control d-inline-block w-25"
                placeholder="Color (e.g., Red, Blue)" required>
            <input type="text" name="sizes[]" class="form-control d-inline-block w-25"
                placeholder="Size (e.g., S, M, L)" required>
            <input type="number" name="stocks[]" class="form-control d-inline-block w-25"
                placeholder="Stock for this size" required>
            <button type="button" class="btn btn-danger btn-sm ms-2 remove-field">X</button>
        `;

            colorSizeFields.appendChild(newField);
            updateLabels();
        });

        document.getElementById('color-size-fields').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-field')) {
                event.target.parentElement.remove();
                updateLabels();
            }
        });

        function updateLabels() {
            var fields = document.querySelectorAll('.color-size-field label');
            fields.forEach((label, index) => {
                label.textContent = (index + 1) + '.';
            });
        }
    </script>
</body>

</html>