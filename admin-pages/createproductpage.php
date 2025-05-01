<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}
@include('proccess/product_proccess.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Product Page</title>


    <style>
        ::placeholder {
            color: black !important;
            opacity: 1;
            /* Ensures the color is fully applied */
        }

        .color-size-field .row {
            align-items: center;
            /* Align items vertically in the middle */
        }

        .remove-field {
            padding: 0.25rem 0.5rem;
            /* Smaller padding */
            font-size: 0.875rem;
            /* Smaller font size */
            line-height: 1;
            /* Adjust line height */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Create a New Product</h1>

        <form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
            <!-- Product Name -->
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Product Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>

            <!-- Description -->
            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>
            </div>

            <!-- Price -->
            <div class="row mb-3">
                <label for="price" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="number" name="price" class="form-control" step="any" required>
                </div>
            </div>

            <!-- Currency Dropdown -->
            <div class="row mb-3">
                <label for="currency" class="col-sm-2 col-form-label">Currency</label>
                <div class="col-sm-10">
                    <select name="currency" class="form-control" required>
                        <option value="USD">USD</option>
                        <option value="LBP">LBP</option>
                    </select>
                </div>
            </div>

            <!-- Image -->
            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" name="image" class="form-control" required>
                </div>
            </div>

            <!-- Checkboxes for Popular, Best Deal, and On Sale -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="form-check border p-2 rounded">
                        <input type="checkbox" class="form-check-input" id="popular" name="popular">
                        <label class="form-check-label" for="popular">Popular</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check border p-2 rounded">
                        <input type="checkbox" class="form-check-input" id="best-deal" name="best_deal">
                        <label class="form-check-label" for="best-deal">Best Deal?</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check border p-2 rounded">
                        <input type="checkbox" class="form-check-input" id="on-sale" name="on_sale">
                        <label class="form-check-label" for="on-sale">On Sale?</label>
                    </div>
                </div>
            </div>

            <!-- New Price Field (Hidden by Default) -->
            <div class="row mb-3" id="new-price-field" style="display: none;">
                <label for="new_price" class="col-sm-2 col-form-label">New Price</label>
                <div class="col-sm-10">
                    <input type="number" name="new_price" class="form-control" step="any">
                </div>
            </div>

            <!-- Dynamic Color, Size, Stock & Image Fields -->
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Colors, Sizes, Stock & Images</label>
                <div class="col-sm-10">
                    <div id="color-size-fields">
                        <div class="color-size-field mb-2">
                            <div class="row g-2">
                                <div class="col-12 col-md-3">
                                    <input type="text" name="colors[]" class="form-control" placeholder="Color (e.g., Red, Blue)" required>
                                </div>
                                <div class="col-12 col-md-3">
                                    <input type="text" name="sizes[]" class="form-control" placeholder="Size (e.g., S, M, L)" required>
                                </div>
                                <div class="col-12 col-md-3">
                                    <input type="number" name="stocks[]" class="form-control" placeholder="Stock for this size" required>
                                </div>
                                <div class="col-12 col-md-3">
                                    <input type="file" name="color_images[]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-color-size" class="btn btn-secondary mt-2">Add Another Color & Size</button>
                </div>
            </div>

            <!-- Tags -->
            <div class="row mb-3">
                <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                <div class="col-sm-10">
                    <select name="tags[]" class="form-control" multiple>
                        <?php
                        $database = new Database();
                        $db = $database->getConnection();
                        $tag = new Tag($db);
                        $stmt = $tag->getAll();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['tag_id'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Create Product</button>
                </div>
            </div>
        </form>
    </div>

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

        // Add Color, Size, Stock & Image Fields
        // Add Color, Size, Stock & Image Fields
        document.getElementById('add-color-size').addEventListener('click', function() {
            var colorSizeFields = document.getElementById('color-size-fields');
            var fieldCount = colorSizeFields.children.length + 1;

            var newField = document.createElement('div');
            newField.classList.add('color-size-field', 'mb-2');
            newField.innerHTML = `
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-3">
                            <input type="text" name="colors[]" class="form-control" placeholder="Color (e.g., Red, Blue)" required>
                        </div>
                        <div class="col-12 col-md-3">
                            <input type="text" name="sizes[]" class="form-control" placeholder="Size (e.g., S, M, L)" required>
                        </div>
                        <div class="col-12 col-md-3">
                            <input type="number" name="stocks[]" class="form-control" placeholder="Stock for this size" required>
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="file" name="color_images[]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-field">X</button>
                        </div>
                    </div>
                `;
            colorSizeFields.appendChild(newField);
        });

        // Remove Color, Size, Stock & Image Fields
        document.getElementById('color-size-fields').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-field')) {
                event.target.closest('.color-size-field').remove();
            }
        });
    </script>
</body>

</html>