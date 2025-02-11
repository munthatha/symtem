<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Upload image
    $image = "default.jpg"; // Default image
    if ($_FILES["image"]["name"]) {
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "img/" . $image);
    }

    // Insert product into database
    $sql = "INSERT INTO product (name, description, price, stock, image) 
            VALUES ('$name', '$description', '$price', '$stock', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product added successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product Stock</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { width: 40%; margin: auto; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            width: 200px;
            border-radius: 5px;
            background-color:rgb(76, 170, 69); color: white}
    </style>
</head>
<body>

    <h2>Add Product Stock</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required><br>
        <textarea name="description" placeholder="Product Description" required></textarea><br>
        <input type="number" name="price" placeholder="Price" required><br>
        <input type="number" name="stock" placeholder="Stock Quantity" required><br>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" class="box">
        <button type="submit">Add Product</button>
    </form>

</body>
</html>
