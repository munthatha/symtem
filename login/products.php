<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        img { width: 100px; height: 100px; border-radius: 5px; }
    </style>
</head>
<body>

    <h2>Products List</h2>
    <a href="add_stock.php">Add Product Stock</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = "img/" . htmlspecialchars($row['image']);
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td><img src='" . $imagePath . "' alt='Product Image'></td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>$" . htmlspecialchars($row['price']) . "</td>
                        <td>" . htmlspecialchars($row['stock']) . "</td>
                        </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No products found</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php $conn->close(); ?>
