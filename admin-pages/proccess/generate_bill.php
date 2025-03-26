<?php

use Classes\OrderItem;
use Classes\Order;

require_once '../../classes/database.php';
require_once '../../classes/order.php';
require_once '../../classes/order-items.php';
require_once '../../classes/customer.php';
include '../../fpdf/fpdf.php';

// Get the order ID from the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if (!$order_id) {
    // Redirect to orders page if no order ID is provided
    header("Location: orderspage.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Fetch order details
$order = new Order($db);
$order->order_id = $order_id;
$orderDetails = $order->getOrderDetails();

// Fetch customer details
$customer = new Customer($db);
$customer->customer_id = $orderDetails['customer_id'];
$customer->findById();

// Fetch order items
$orderItem = new OrderItem($db);
$items = $orderItem->getOrderItems($order_id);

// Initialize the FPDF object
$pdf = new FPDF();
$pdf->AddPage();

// Set Title and Header
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Invoice #' . $order_id, 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 10, 'Ordered on: ' . date('F j, Y \a\t g:i a', strtotime($orderDetails['created_at'])), 0, 1, 'C');
$pdf->Ln(10);

// Company Header (Optional: Add your company logo here)
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Calisto Baby', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, ' Phone: +961 81 972 848 | Email: calistobaby1@gmail.com', 0, 1, 'C');
$pdf->Ln(10);

// Customer Information
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Bill To:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Name: ' . $customer->first_name . ' ' . $customer->last_name, 0, 1);
$pdf->Cell(0, 10, 'Address: ' . $customer->address, 0, 1);
$pdf->Cell(0, 10, 'Phone: ' . $customer->phone_number, 0, 1);
$pdf->Cell(0, 10, 'Email: ' . $customer->email, 0, 1);
$pdf->Ln(10);

// Order Details Table
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Product', 1, 0, 'C');
$pdf->Cell(30, 10, 'Qty', 1, 0, 'C');
$pdf->Cell(30, 10, 'Color', 1, 0, 'C');
$pdf->Cell(30, 10, 'Size', 1, 0, 'C');
$pdf->Cell(40, 10, 'Price', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);

foreach ($items as $item) {
    $pdf->Cell(50, 10, $item['name'], 1, 0, 'C');
    $pdf->Cell(30, 10, $item['quantity'], 1, 0, 'C');
    $pdf->Cell(30, 10, $item['color'], 1, 0, 'C');
    $pdf->Cell(30, 10, $item['size'], 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . number_format($item['price_at_purchase'], 2), 1, 1, 'C');
}

$pdf->Ln(10);

// Order Summary Table
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 10, 'Subtotal', 0, 0, 'R');
$pdf->Cell(30, 10, '$' . number_format($orderDetails['total_amount'], 2), 0, 1, 'R');

if ($orderDetails['discount_amount'] > 0) {
    $pdf->Cell(140, 10, 'Discount', 0, 0, 'R');
    $pdf->Cell(30, 10, '-$' . number_format($orderDetails['discount_amount'], 2), 0, 1, 'R');
}

$pdf->Cell(140, 10, 'Shipping Fee', 0, 0, 'R');
$pdf->Cell(30, 10, '$' . number_format($orderDetails['shipping_fee'], 2), 0, 1, 'R');

$grandTotal = ($orderDetails['total_amount'] - $orderDetails['discount_amount'] + $orderDetails['shipping_fee']);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(140, 10, 'Grand Total', 0, 0, 'R');
$pdf->Cell(30, 10, '$' . number_format($grandTotal, 2), 0, 1, 'R');
$pdf->Ln(10);

// Payment Method
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Payment Method:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Cash on Delivery', 0, 1);
$pdf->Ln(10);

// Footer with Company Information
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Thank you for shopping with us!', 0, 1, 'C');
$pdf->Cell(0, 10, 'For inquiries, please contact +961 81 972 848 | calistobaby1@gmail.com ', 0, 1, 'C');

// Output the PDF and prompt download
$pdf->Output('D', 'invoice_' . $order_id . '.pdf');
?>
