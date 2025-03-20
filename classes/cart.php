<?php
class Cart
{
    private $conn;
    private $table_name = "cart";

    public $cart_id;
    public $customer_id;
    public $product_id;
    public $quantity;
    public $color;
    public $size;
    public $added_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Add product to cart
    public function add()
    {
        try {
            // Check if the product with the same size and color already exists in the cart
            $query = "SELECT cart_id, quantity FROM " . $this->table_name . " 
                  WHERE customer_id = :customer_id 
                  AND product_id = :product_id 
                  AND size = :size 
                  AND color = :color";
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(":customer_id", $this->customer_id);
            $stmt->bindParam(":product_id", $this->product_id);
            $stmt->bindParam(":size", $this->size);
            $stmt->bindParam(":color", $this->color);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // If the item already exists, update the quantity
                $newQuantity = $row['quantity'] + $this->quantity;

                // Debugging: Log the current and new quantity
                error_log("Current quantity: " . $row['quantity']);
                error_log("Adding quantity: " . $this->quantity);
                error_log("New quantity: " . $newQuantity);

                // Check stock availability before updating
                $product = new Product($this->conn);
                $product->product_id = $this->product_id;
                $stock = $product->getStockForSizeAndColor($this->size, $this->color);

                if ($newQuantity > $stock) {
                    throw new Exception("Requested quantity exceeds available stock.");
                }

                // Update the quantity
                $updateQuery = "UPDATE " . $this->table_name . " 
                            SET quantity = :quantity 
                            WHERE cart_id = :cart_id";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(":quantity", $newQuantity);
                $updateStmt->bindParam(":cart_id", $row['cart_id']);

                if ($updateStmt->execute()) {
                    error_log("Quantity updated successfully.");
                    return true;
                } else {
                    throw new Exception("Failed to update quantity in the database.");
                }
            } else {
                // If the item does not exist, insert a new row
                $insertQuery = "INSERT INTO " . $this->table_name . " 
                            (customer_id, product_id, quantity, color, size, added_at) 
                            VALUES (:customer_id, :product_id, :quantity, :color, :size, NOW())";
                $insertStmt = $this->conn->prepare($insertQuery);

                // Bind parameters
                $insertStmt->bindParam(":customer_id", $this->customer_id);
                $insertStmt->bindParam(":product_id", $this->product_id);
                $insertStmt->bindParam(":quantity", $this->quantity);
                $insertStmt->bindParam(":color", $this->color);
                $insertStmt->bindParam(":size", $this->size);

                if ($insertStmt->execute()) {
                    error_log("New item added to cart successfully.");
                    return true;
                } else {
                    throw new Exception("Failed to insert new item into the cart.");
                }
            }
        } catch (Exception $e) {
            error_log("Error in add method: " . $e->getMessage());
            return false;
        }
    }

    // Remove a single cart item
    public function removeItem($cart_id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);

        // Bind the cart_id parameter
        $stmt->bindParam(":cart_id", $cart_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Clear the entire cart for a customer
    public function clearCart($customer_id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE customer_id = :customer_id";
        $stmt = $this->conn->prepare($query);

        // Bind the customer_id parameter
        $stmt->bindParam(":customer_id", $customer_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get items in cart with product details
    public function getItems()
    {
        $query = "
            SELECT 
                c.cart_id, 
                c.customer_id, 
                c.product_id, 
                c.quantity, 
                c.color, 
                c.size, 
                c.added_at, 
                p.name AS product_name, 
                p.price, 
                p.new_price, 
                p.image AS product_image 
            FROM 
                " . $this->table_name . " c 
            INNER JOIN 
                products p 
            ON 
                c.product_id = p.product_id 
            WHERE 
                c.customer_id = :customer_id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();
        return $stmt;
    }

    // Update quantity in cart
    public function updateQuantity()
    {
        try {
            // First, get the product_id, size, and color from the cart item
            $query = "SELECT product_id, size, color FROM " . $this->table_name . " WHERE cart_id = :cart_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":cart_id", $this->cart_id);
            $stmt->execute();
            $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cartItem) {
                throw new Exception("Cart item not found.");
            }

            // Get the stock for the specific product, size, and color from the product_sizes table
            $stockQuery = "SELECT stock FROM product_sizes 
                       WHERE product_id = :product_id 
                       AND size = :size 
                       AND color = :color";
            $stockStmt = $this->conn->prepare($stockQuery);
            $stockStmt->bindParam(":product_id", $cartItem['product_id']);
            $stockStmt->bindParam(":size", $cartItem['size']);
            $stockStmt->bindParam(":color", $cartItem['color']);
            $stockStmt->execute();
            $stockData = $stockStmt->fetch(PDO::FETCH_ASSOC);

            if (!$stockData) {
                throw new Exception("Product size or color not found in stock.");
            }

            $availableStock = $stockData['stock'];

            // Check if the requested quantity exceeds the available stock
            if ($this->quantity > $availableStock) {
                throw new Exception("Requested quantity exceeds available stock.");
            }

            // If stock is sufficient, update the quantity in the cart
            $updateQuery = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE cart_id = :cart_id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(":quantity", $this->quantity);
            $updateStmt->bindParam(":cart_id", $this->cart_id);

            if ($updateStmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to update quantity in the database.");
            }
        } catch (Exception $e) {
            error_log("Error in updateQuantity: " . $e->getMessage());
            return $e->getMessage(); // Return the exception message
        }
    }

    // Calculate cart totals
    public function calculateCartTotals($customer_id)
    {
        try {
            $query = "
            SELECT 
                SUM(
                    CASE 
                        WHEN p.new_price IS NOT NULL AND p.new_price > 0 THEN p.new_price * c.quantity 
                        WHEN p.price IS NOT NULL THEN p.price * c.quantity 
                        ELSE 0 
                    END
                ) AS subtotal,
                SUM(
                    CASE 
                        WHEN p.new_price IS NOT NULL AND p.new_price > 0 THEN p.new_price * c.quantity 
                        WHEN p.price IS NOT NULL THEN p.price * c.quantity 
                        ELSE 0 
                    END
                ) AS total
            FROM 
                " . $this->table_name . " c
            INNER JOIN 
                products p ON c.product_id = p.product_id
            WHERE 
                c.customer_id = :customer_id
        ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":customer_id", $customer_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                throw new Exception("No cart items found for the customer.");
            }

            return [
                'subtotal' => $row['subtotal'] ? (float)$row['subtotal'] : 0.00,
                'total' => $row['total'] ? (float)$row['total'] : 0.00
            ];
        } catch (Exception $e) {
            error_log("Error in calculateCartTotals: " . $e->getMessage());
            return [
                'subtotal' => 0.00,
                'total' => 0.00
            ];
        }
    }

    // Get cart item subtotal
    public function getCartItemSubtotal($cart_id)
    {
        if (empty($cart_id)) {
            throw new Exception("Cart ID cannot be empty.");
        }

        try {
            $query = "
            SELECT 
                CASE 
                    WHEN p.new_price IS NOT NULL AND p.new_price > 0 THEN p.new_price * c.quantity
                    WHEN p.price IS NOT NULL AND p.price > 0 THEN p.price * c.quantity
                    ELSE p.price * c.quantity 
                END AS item_subtotal
            FROM 
                " . $this->table_name . " c
            INNER JOIN 
                products p ON c.product_id = p.product_id
            WHERE 
                c.cart_id = :cart_id
        ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":cart_id", $cart_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                throw new Exception("Cart item not found.");
            }

            return $row['item_subtotal'] ? (float)$row['item_subtotal'] : 0.00;
        } catch (Exception $e) {
            error_log("Error in getCartItemSubtotal: " . $e->getMessage());
            return 0.00;
        }
    }

    public function getCartItemQuantity($cart_id)
    {
        $query = "SELECT quantity FROM cart WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['quantity'] : 0;
    }

    // In the Cart class
    public function getCartQuantityForProduct($product_id, $size, $color)
    {
        $query = "SELECT SUM(quantity) AS total_quantity FROM " . $this->table_name . " 
                  WHERE customer_id = :customer_id 
                  AND product_id = :product_id 
                  AND size = :size 
                  AND color = :color";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":size", $size);
        $stmt->bindParam(":color", $color);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int)$row['total_quantity'] : 0;
    }

    public function getCartCount()
    {
        $query = "SELECT COUNT(cart_id) AS total_quantity FROM " . $this->table_name . " 
                  WHERE customer_id = :customer_id";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int)$row['total_quantity'] : 0;
    }
}
