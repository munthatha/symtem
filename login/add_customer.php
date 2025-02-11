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
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $google_map_link = $_POST['google_map_link'];

    // Upload image
    $image = "default.jpg"; // Default image
    if ($_FILES["image"]["name"]) {
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "customer_img/" . $image);
    }

    // Insert customer into database
    $sql = "INSERT INTO customers (name, phone, address, google_map_link, image) 
            VALUES ('$name', '$phone', '$address', '$google_map_link', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        echo"<script>alert('Customer added successfully!'); window.location.href='list_customers.php';</script>";
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
    <title>Add customers</title>
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
            background-color:rgb(76, 170, 69); color: white;
        }
        #map {
            height: 400px;
            width: 100%;
            margin: 20px 0;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });

            var marker = new google.maps.Marker({
                position: {lat: -34.397, lng: 150.644},
                map: map,
                draggable: true
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                updateMarkerPosition(marker.getPosition());
            });

            google.maps.event.addListener(marker, 'dragend', function() {
                updateMarkerPosition(marker.getPosition());
            });

            function updateMarkerPosition(position) {
                var lat = position.lat();
                var lng = position.lng();
                var googleMapLink = `https://www.google.com/maps?q=${lat},${lng}`;
                document.getElementById('google_map_link').value = googleMapLink;
            }
        }
    </script>
</head>
<body>

    <h2>Add Customer</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" name="name" placeholder="Name" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" name="phone" placeholder="Phone" required><br>
        <label for="address">Address:</label><br>
        <textarea name="address" placeholder="Address" required></textarea><br>
        <label for="google_map_link">Google Map Link:</label><br>
        <input type="text" id="google_map_link" name="google_map_link" placeholder="Google Map Link" required readonly><br>
        <div id="map"></div>
        <label for="image">Image:</label><br>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" class="box">
        <br><br>
        <button type="submit">Add Customer</button>
    </form>

</body>
</html>
