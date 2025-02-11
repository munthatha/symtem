<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch customer details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "<script>alert('Customer not found!'); window.location.href='list_customers.php';</script>";
        exit;
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='list_customers.php';</script>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        .customer-box { width: 50%; margin: auto; padding: 20px; border: 1px solid #ddd; text-align: left; }
        h2 { color: #4CAF50; }
        p { font-size: 18px; }
        .back-button { margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .back-button:hover { background-color: #0056b3; }
        img { width: 150px; height: 150px; border-radius: 10px; display: block; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="customer-box">
        <h2>Customer Details</h2>
        <img src="customer_img/<?php echo htmlspecialchars($customer['image']); ?>" alt="Customer Photo">
        <p><strong>ID:</strong> <?php echo htmlspecialchars($customer['id']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['name']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($customer['address']); ?></p>
        <p><strong>Location:</strong> <a href="<?php echo htmlspecialchars($customer['google_map_link']); ?>" target="_blank"><?php echo htmlspecialchars($customer['google_map_link']); ?></a></p>
        <p><strong>Joined Date:</strong> <?php echo htmlspecialchars($customer['created_at']); ?></p>
        <a class="back-button" href="list_customers.php">Back to List</a>
    </div>
</body>
</html>

