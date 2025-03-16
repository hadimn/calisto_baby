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
        $query = "INSERT INTO " . $this->table_name . " (customer_id, product_id, quantity, color, size, added_at) 
                  VALUES (:customer_id, :product_id, :quantity, :color, :size, :added_at)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":size", $this->size);
        $stmt->bindParam(":added_at", $this->added_at);

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
        $query = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":cart_id", $this->cart_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
