<?php
$conn = new mysqli("localhost", "root", "", "mydatabase");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customers = $conn->query("SELECT * FROM customers");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $orders = $conn->query("SELECT * FROM orders WHERE customer_id = $customer_id");
    $total_sales = 0;
    $total_products = 0;
    $total_quantity = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Customer Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h2 {
            color: #333;
        }
        form {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>View Customer Orders</h2>
<form method="post">
    <label>Select Customer:</label>
    <select name="customer_id">
        <?php while ($row = $customers->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?> - <?= htmlspecialchars($row['phone']) ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit">View Orders</button>
</form>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <?php while ($order = $orders->fetch_assoc()): ?>
        <h3>Invoice #<?= $order['id'] ?></h3>
        <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
        <p><strong>Total Amount:</strong> $<?= $order['total'] ?></p>
        <?php $total_sales += $order['total']; ?>

        <?php
        $order_details = $conn->query("SELECT od.*, p.name FROM order_items od 
                                       JOIN product p ON od.product_id = p.id 
                                       WHERE order_id = {$order['id']}");
        ?>

        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        <?php while ($row = $order_details->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['subtotal'] * $row['quantity'] ?></td>
            </tr>
            <?php
            $total_products++;
            $total_quantity += $row['quantity'];
            ?>
        <?php endwhile; ?>
        </table>
    <?php endwhile; ?>
    <h3>Total Sales for Customer: $<?= $total_sales ?></h3>
    <h3>Total Products Ordered: <?= $total_products ?></h3>
    <h3>Total Quantity Ordered: <?= $total_quantity ?></h3>
<?php endif; ?>

</body>
</html>