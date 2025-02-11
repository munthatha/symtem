<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Buttons</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            width: 50px;
            border-radius: 7px;
            text-decoration: none;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            width: 200px;
            border-radius: 5px;
        }
        .customer { background-color:rgb(76, 170, 69); color: white; }

    </style>
</head>
<body>

    <h2>Customer</h2>
    <form>
    <a href="add_customer.php" class="btn customer">Add</a>
</body>
</html>

<?php
// Database connection
$servername = "localhost";
$username = "root";  // Default username for XAMPP
$password = "";      // Default password is empty for XAMPP
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search functionality
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$sql = "SELECT * FROM customers WHERE 
        name LIKE '%$search%' OR 
        phone LIKE '%$search%' OR 
        address LIKE '%$search%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        input {
            padding: 8px;
            width: 250px;
            margin-bottom: 10px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
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
        tr:hover {
            background-color: #ddd;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form method="GET">
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search customers...">
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick='viewCustomer({$row['id']})'>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No customers found</td></tr>";
        }
        ?>
    </table>

    <script>
        function viewCustomer(id) {
            window.location.href = "customer_details.php?id=" + id;
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
