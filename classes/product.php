<?php
class Product
{
    private $conn;
    private $table_name = "products";
    private $size_table = "product_sizes"; // Table for sizes, colors, and stock

    public $product_id;
    public $admin_id;
    public $name;
    public $description;
    public $price;
    public $new_price; // New price for products on sale
    public $currency;
    public $image;
    public $popular;
    public $created_at;
    public $updated_at;
    public $best_deal;
    public $on_sale;
    public $sizes = []; // Holds size, color, and stock data

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new product with multiple sizes and colors
    public function create($admin_id)
    {
        try {
            // Insert product details
            $query = "INSERT INTO " . $this->table_name . " (admin_id, name, description, price, new_price, currency, image, popular, best_deal, on_sale, created_at) 
                  VALUES (:admin_id, :name, :description, :price, :new_price, :currency, :image, :popular, :best_deal, :on_sale, NOW())";
            $stmt = $this->conn->prepare($query);

            // Bind main product details
            $stmt->bindParam(":admin_id", $admin_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":new_price", $this->new_price);
            $stmt->bindParam(":currency", $this->currency);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":popular", $this->popular);
            $stmt->bindParam(":best_deal", $this->best_deal);
            $stmt->bindParam(":on_sale", $this->on_sale);

            // Execute the query
            if ($stmt->execute()) {
                // Get the last inserted product_id
                $this->product_id = $this->conn->lastInsertId();

                // Insert sizes, colors, stock, and color images into product_sizes table
                foreach ($this->sizes as $size => $colorStocks) {
                    foreach ($colorStocks as $color => $data) {
                        $size_query = "INSERT INTO " . $this->size_table . " (product_id, size, color, stock, color_image) 
                                   VALUES (:product_id, :size, :color, :stock, :color_image)";
                        $size_stmt = $this->conn->prepare($size_query);

                        // Bind parameters
                        $size_stmt->bindParam(":product_id", $this->product_id);
                        $size_stmt->bindParam(":size", $size);
                        $size_stmt->bindParam(":color", $color);
                        $size_stmt->bindParam(":stock", $data['stock']);
                        $size_stmt->bindParam(":color_image", $data['color_image']);

                        // Execute the query for sizes and stocks
                        $size_stmt->execute();
                    }
                }
                return true;
            } else {
                throw new Exception("Database insert failed.");
            }
        } catch (Exception $e) {
            error_log("Error in creating product: " . $e->getMessage());
            return false;
        }
    }

    public function update($admin_id)
    {
        try {
            $this->conn->beginTransaction();

            // Update product details
            $query = "UPDATE " . $this->table_name . " SET
                admin_id = :admin_id,
                name = :name,
                description = :description,
                price = :price,
                new_price = :new_price,
                currency = :currency,
                image = :image,
                popular = :popular,
                best_deal = :best_deal,
                on_sale = :on_sale,
                updated_at = NOW()
            WHERE product_id = :product_id";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(":admin_id", $admin_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":new_price", $this->new_price);
            $stmt->bindParam(":currency", $this->currency);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":popular", $this->popular);
            $stmt->bindParam(":product_id", $this->product_id);
            $stmt->bindParam(":best_deal", $this->best_deal);
            $stmt->bindParam(":on_sale", $this->on_sale);

            // Execute the query
            if (!$stmt->execute()) {
                throw new Exception("Product update failed.");
            }

            // Delete existing sizes and colors
            $delete_query = "DELETE FROM " . $this->size_table . " WHERE product_id = :product_id";
            $delete_stmt = $this->conn->prepare($delete_query);
            $delete_stmt->bindParam(":product_id", $this->product_id);

            if (!$delete_stmt->execute()) {
                throw new Exception("Failed to delete existing sizes/colors.");
            }

            // Insert new sizes and colors
            foreach ($this->sizes as $size => $colorStocks) {
                foreach ($colorStocks as $color => $data) {
                    $size_query = "INSERT INTO " . $this->size_table . " (product_id, size, color, stock, color_image)
                               VALUES (:product_id, :size, :color, :stock, :color_image)";
                    $size_stmt = $this->conn->prepare($size_query);

                    $size_stmt->bindParam(":product_id", $this->product_id);
                    $size_stmt->bindParam(":size", $size);
                    $size_stmt->bindParam(":color", $color);
                    $size_stmt->bindParam(":stock", $data['stock']);
                    $size_stmt->bindParam(":color_image", $data['color_image']);

                    if (!$size_stmt->execute()) {
                        throw new Exception("Failed to insert new size/color.");
                    }
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error in updating product: " . $e->getMessage());
            return false;
        }
    }

    // Get all products
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // get the new arrived products
    public function newArrival()
    {
        // SELECT * FROM products WHERE products.created_at >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)
        $query = "SELECT * FROM " . $this->table_name . " WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get last n products
    public function getLastByLimit($limit)
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC LIMIT $limit";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a product by ID
    public function getById()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE product_id = :product_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get sizes and stock for a product
    public function getSizesAndColors()
    {
        $query = "SELECT size, color, stock, color_image FROM " . $this->size_table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get available colors
    public function getAvailableColors()
    {
        $query = "SELECT DISTINCT color FROM " . $this->size_table . " WHERE stock > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAvailableColorsById($product_id)
    {
        $query = "SELECT DISTINCT color FROM " . $this->size_table . " WHERE product_id = :product_id AND stock > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Get available sizes for a specific color
    public function getAvailableSizes($color)
    {
        $query = "SELECT DISTINCT size FROM " . $this->size_table . " WHERE product_id = :product_id AND color = :color AND stock > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":color", $color);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Get available sizes for a specific color
    public function getAvailableSizesById($product_id)
    {
        $query = "SELECT DISTINCT size FROM " . $this->size_table . " WHERE product_id = :product_id AND stock > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Add this method to the Product classx`
    public function getTags()
    {
        $query = "SELECT t.tag_id, t.name FROM tags t
              JOIN product_tags pt ON t.tag_id = pt.tag_id
              WHERE pt.product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPorductsOnSale()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE on_sale = :on_sale ORDER BY created_at DESC LIMIT 8";
        $stmt = $this->conn->prepare($query);
        $on_sale = 1;
        $stmt->bindParam(":on_sale", $on_sale, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPorductsBestDeal()
    {
        // Calculate sale percentage and filter products where sale percentage >= 30%
        $query = "SELECT *, 
                         ((price - new_price) / price) * 100 AS sale_percentage 
                  FROM " . $this->table_name . " 
                  WHERE best_deal = :best_deal 
                    AND on_sale = :on_sale 
                    AND ((price - new_price) / price) * 100 >= 30 
                  ORDER BY created_at DESC 
                  LIMIT 4";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $best_deal = 1;
        $on_sale = 1;
        $stmt->bindParam(":best_deal", $best_deal, PDO::PARAM_INT);
        $stmt->bindParam(":on_sale", $on_sale, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch and return the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPorductsPopular()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE popular = :popular ORDER BY created_at DESC LIMIT 8";
        $stmt = $this->conn->prepare($query);
        $popular = 1;
        $stmt->bindParam(":popular", $popular, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRelatedProducts()
    {
        $query = "SELECT DISTINCT p.*
              FROM " . $this->table_name . " p
              JOIN product_tags pt1 ON p.product_id = pt1.product_id
              JOIN product_tags pt2 ON pt1.tag_id = pt2.tag_id
              WHERE pt2.product_id = :product_id AND p.product_id != :product_id
              LIMIT 8";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStockForSizeAndColor($size, $color)
    {
        $query = "SELECT stock FROM " . $this->size_table . " WHERE product_id = :product_id AND size = :size AND color = :color";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":size", $size);
        $stmt->bindParam(":color", $color);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['stock'] : 0;
    }

    public function updateStockForSizeAndColor($size, $color, $new_stock)
    {
        $query = "UPDATE " . $this->size_table . " 
              SET stock = :new_stock 
              WHERE product_id = :product_id AND size = :size AND color = :color";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":new_stock", $new_stock);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":size", $size);
        $stmt->bindParam(":color", $color);

        return $stmt->execute();
    }

    public function getSizesAndColorsForProduct($product_id)
    {
        $query = "SELECT size, color FROM " . $this->size_table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
