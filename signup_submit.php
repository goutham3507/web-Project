<?php
// Retrieve form data
$username = $_POST['user'];
$email = $_POST['email'];
$password = $_POST['pass'];
$role = $_POST['role'];

// Connect to the database (Replace with your database credentials)
$host = "localhost";
$user = "gganapathiappan1";
$pass = "gganapathiappan1";
$dbname = "gganapathiappan1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// SQL query to insert user data into the database
$sql = "INSERT INTO users (username, email, password_hash, role) VALUES ('$username', '$email', '$password_hash', '$role')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "User registered successfully";

    // Redirect buyers to the property viewing page
    if ($role === 'buyer') {
        header("Location: view_properties.php");
        exit;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
