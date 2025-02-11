<?php
$conn = new mysqli("localhost", "root", "", "mydatabase");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$products = $conn->query("SELECT * FROM product");
$customers = $conn->query("SELECT * FROM customers");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $total_amount = 0;
    $errors = [];

    $stmt = $conn->prepare("INSERT INTO orders (customer_id, total) VALUES (?, 0)");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    foreach ($_POST['product'] as $product_id => $quantity) {
        if ($quantity > 0) {
            $stmt = $conn->prepare("SELECT price, stock FROM product WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $price = $product['price'];
            $stock = $product['stock'];
            $stmt->close();

            if ($quantity > $stock) {
                $errors[] = "Not enough stock for product ID $product_id";
                continue;
            }

            $total_price = $price * $quantity;
            $total_amount += $total_price;

            // Update stock quantity
            $new_stock = $stock - $quantity;
            $stmt = $conn->prepare("UPDATE product SET stock = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_stock, $product_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, price, quantity, subtotal) 
                                    VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiidi", $order_id, $product_id, $price, $quantity, $total_price);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE orders SET total = ? WHERE id = ?");
        $stmt->bind_param("di", $total_amount, $order_id);
        $stmt->execute();
        $stmt->close();

        header("Location: invoice.php?order_id=$order_id");
        exit();
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
<style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        img { width: 100px; height: 100px; border-radius: 5px; }
    </style>
<form method="post">
    <label>Select Customer:</label>
    <select name="customer_id">
        <?php while ($row = $customers->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?> - <?= htmlspecialchars($row['phone']) ?></option>
        <?php endwhile; ?>
    </select>

    <h3>Products</h3>
    <?php while ($row = $products->fetch_assoc()): ?>
        <div>
            <img src="<?= htmlspecialchars($row['photo']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
            <label><?= htmlspecialchars($row['name']) ?> ($<?= htmlspecialchars($row['price']) ?>)</label>
            <p>Stock: <?= htmlspecialchars($row['stock']) ?></p>
            <input type="number" name="product[<?= htmlspecialchars($row['id']) ?>]" min="0">
        </div>
        <br>
    <?php endwhile; ?>

    <button type="submit">Place Order</button>
</form>
