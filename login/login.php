<?php
$host = 'localhost';
$dbname = 'mydatabase';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM users1 WHERE username = :username AND password = MD5(:password)");
    $stmt->execute(['username' => $username, 'password' => $password]);

    // Fetch the user
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($user) {
        // Check user type and redirect accordingly
        switch ($user["usertype"]) {
            case "admin":
                header('Location: welcome.html');
                break;
            case "stock":
                header('Location: stock_dashboard.php');
                break;
            case "sale":
                header('Location: sale_home.php');
                break;
            default:
                echo "Invalid user type.";
                break;
        }
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }
}
?>