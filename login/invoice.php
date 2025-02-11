<?php
$conn = new mysqli("localhost", "root", "", "mydatabase");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['order_id'];

$order = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();
$customer = $conn->query("SELECT * FROM customers WHERE id = {$order['customer_id']}")->fetch_assoc();
$order_details = $conn->query("SELECT od.*, p.name FROM order_items od 
                               JOIN product p ON od.product_id = p.id 
                               WHERE order_id = $order_id");
?>

<h2>Invoice #<?= $order_id ?></h2>
<p><strong>Customer:</strong> <?= $customer['name'] ?> (<?= $customer['phone'] ?>)</p>
<p><strong>Address:</strong> <?= $customer['address'] ?></p>
<p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>

<table border="1">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
<?php while ($row = $order_details->fetch_assoc()): ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['subtotal'] * $row['quantity']; ?></td>
    </tr>
<?php endwhile; ?>
</table>

<h3>Total Amount: $<?php echo $order['total']; ?></h3>

<button onclick="printAndRedirect()">Print Invoice</button>
<button onclick="cancelOrder()">Cancel Order</button>

<script>
function printAndRedirect() {
    window.print();
    window.onafterprint = function() {
        window.location.href = 'sale_order.php';
    };
}

function cancelOrder() {
    if (confirm('Are you sure you want to cancel this order?')) {
        window.location.href = 'cancel_order.php?order_id=<?= $order_id ?>';
    }
}
</script>
