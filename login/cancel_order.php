<?php
$conn = new mysqli("localhost", "root", "", "mydatabase");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['order_id'];

// Retrieve the order items to update the stock
$order_items = $conn->query("SELECT product_id, quantity FROM order_items WHERE order_id = $order_id");

while ($item = $order_items->fetch_assoc()) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    // Update the stock quantity
    $conn->query("UPDATE product SET stock = stock + $quantity WHERE id = $product_id");
}

// Delete the order items
$conn->query("DELETE FROM order_items WHERE order_id = $order_id");

// Delete the order
$conn->query("DELETE FROM orders WHERE id = $order_id");

header("Location: sale_order.php");
exit();
?>