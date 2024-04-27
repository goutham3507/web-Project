<?php
    if(!isset($_COOKIE["user_id"]) || $_COOKIE["user_id"] < 0){
        header("Location: login.php");
    }
    if(!isset($_COOKIE["property_id"])) {
        header("Location: dashboard.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="dashboard.js"></script>
</head>
<body style="background-image: url('http://codd.cs.gsu.edu/~gganapathiappan1/WP/PW/Final/background.jpg');" onload="return addDeleteListener();">
<div id="dashboard-button" onclick=" return toDashboard(); "><b>Dashboard</b></div>
<div id="edit-button" onclick=" return editProperty(); "><b>Edit</b></div>
<!-- <div id="delete-button" onclick=" return deleteProperty(); "><b>Delete</b></div> -->
<div id="delete-button" class=<?php echo "'". $_COOKIE["property_id"] ."'";?>>
    <form action="delete_property.php" method="post" onsubmit="return deleteProperty();">
        <input type="submit" id="delete-submit" name="delete-submit" value="Delete">
    </form>
</div>




<?php
    include("connectToDB.php");
    $sql = "SELECT * FROM properties WHERE user_id=". $_COOKIE["user_id"] ." AND property_id=" . $_COOKIE["property_id"] . ";";
    $result = mysqli_query($conn, $sql);
    $property = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if($property) {
        $property_id = $property["property_id"];
        $image = trim($property["floor_plan"]);
        $image_style = "background-image: url('property_images/$image');";
        echo "<div class=\"property-container-view\" id='$property_id'>\n";
        echo "<div class=\"property-image-container-view\" style=\"$image_style\"></div>";
        echo "<b>" . $property["street_address"]. ", ". $property["city"]. ", " . $property["property_state"] . ", ". $property["country"]. "</b><br>\n";
        echo "<p>$" . $property["price"] . "</p>\n";
        echo "<p>" . $property["number_of_bedrooms"] . " bedroom(s)\n";
        echo "<p>" . $property["age"] . " year(s) old</p>\n";
        echo "<p>Additional facilities: " . $property["additional_facilities"] . "</p>\n";
        if($property["has_garden"] == 1) {
            echo "<p>Garden: Yes</p>\n";
        } else {
            echo "<p>Garden: No</p>\n";
        }
        echo "<p>Parking: " . $property["parking_availability"] . "</p>\n";
        echo "<p>Nearby facilities: " . $property["nearby_facilities"] . "</p>\n";
        echo "<p>Main roads: " . $property["main_roads"] . "</p>\n";
        echo "</div>\n";
    }
    $conn->close();
?>
</body>
</html>