<?php
    if(!isset($_COOKIE["user_id"]) || $_COOKIE["user_id"] < 0){
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="dashboard.js"></script>
</head>
<body style="background-image: url('http://codd.cs.gsu.edu/~gganapathiappan1/WP/PW/Final/css-pattern-by-magicpattern.png');" onload="return addListeners(); ">
    <?php
    // Get the username from the URL parameter
    // $username = isset($_COOKIE["username"]) ? htmlspecialchars($_SESSION["username"]) : '';
    ?>
    <div class="welcome-text">
        <h2>Seller Dashboard</h2>
    </div>

    <div class="add-property-button" onclick="return onAddPropertyClick(); "><label id="add-property-label">+</label></div>

    <!-- Logout button -->
    <form action="logout.php" method="post" class="logout-button" onclick="return onLogoutClick(); ">
        <button type="submit" id="logout">Logout</button>
    </form>
    <div id="grid-container">
    <?php 
        include("connectToDB.php");
        $sql = "SELECT * FROM properties WHERE user_id=". $_COOKIE["user_id"] .";";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $property_id = $row["property_id"];
            $image = trim($row["floor_plan"]);
            $image_style = "background-image: url('property_images/$image');";
            echo "<div class=\"property-container\" id='$property_id'>\n";
            echo "<div class=\"property-image-container\" style=\"$image_style\"></div>";
            $address = $row["street_address"]. ", ". $row["city"]. ", " . $row["property_state"] . ", ". $row["country"];
            if(strlen($address) > 60) {
                $address = substr($address, 0, 60);
                $address = $address . "...";
            }
            echo "<b>" . $address . "</b><br>\n";
            echo "<p>$" . $row["price"] . "</p>\n";
            echo "<p>" . $row["number_of_bedrooms"] . " bedroom(s)\n";
            echo "<p>" . $row["age"] . " year(s) old</p>\n";
            echo "</div>\n";
        }
        }
        $conn->close();
    ?>
    </div>
</body>
</html>
