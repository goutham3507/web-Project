<?php
include("connectToDB.php");
if(!isset($_COOKIE["user_id"]) || $_COOKIE["user_id"] < 0) {
    header("Location: login.php");
}
if(!isset($_COOKIE["property_id"])) {
    header("Location: dashboard.php");
}

if (isset($_POST["update-property"])) {
    if(isset($_FILES["floor-plan"]["name"]) && strlen($_FILES["floor-plan"]["name"]) != 0){
        $error = "";
        $uploadSuccessful = true;
        $file = $_FILES["floor-plan"];
        $fileName = $_FILES["floor-plan"]["name"];
        $fileTmpName = $_FILES["floor-plan"]["tmp_name"];
        $fileSize = $_FILES["floor-plan"]["size"];
        $fileError = $_FILES["floor-plan"]["error"];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array("jpg", "jpeg", "png");
        if(in_array($fileActualExt, $allowed)) {
            if($fileError === 0){
                if($fileSize < 500000) {
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = "property_images/" . $fileNameNew;
                    $fileDestination = __DIR__ ."/" . $fileDestination;
                    copy($fileTmpName, $fileDestination);
                } else {
                    $error = "File too big.";
                    $uploadSuccessful = false; 
                }
            } else {
                $error = "Upload error";
                $uploadSuccessful = false; 
            }
        } else{
            $error = "File type ($fileName) not allowed";
            $uploadSuccessful = false;
        }
        if($uploadSuccessful){
            $sql = "UPDATE properties SET floor_plan='".$fileNameNew."', street_address='" . $_POST["street-address"] . "', city='" . $_POST["city"] . "', property_state='" . $_POST["state"] . "', country='" . $_POST["country"] . "', price=". $_POST["price"] . ", age=". $_POST["age"] . ", number_of_bedrooms='" . $_POST["num-of-bedrooms"] . "', additional_facilities='". $_POST["additional-facilities"] . "', parking_availability='". $_POST["parking-availability"] ."', nearby_facilities='" . $_POST["nearby-facilities"] . "', main_roads='". $_POST["main-roads"] . "', ";
            if(isset($_POST["has-garden"]) && $_POST["has-garden"] == "Yes"){
                $sql = $sql . "has_garden=1 ";
            } else {
                $sql = $sql . "has_garden=0 ";
            }
            $sql = $sql . "WHERE user_id=" . $_COOKIE["user_id"]. " AND property_id=" . $_COOKIE["property_id"] . ";";
            $result = $conn->query($sql);
            header("Location: dashboard.php");
        }
    } else {
        $sql = "UPDATE properties SET street_address='" . $_POST["street-address"] . "', city='" . $_POST["city"] . "', property_state='" . $_POST["state"] . "', country='" . $_POST["country"] . "', price=". $_POST["price"] . ", age=". $_POST["age"] . ", number_of_bedrooms='" . $_POST["num-of-bedrooms"] . "', additional_facilities='". $_POST["additional-facilities"] . "', parking_availability='". $_POST["parking-availability"] ."', nearby_facilities='" . $_POST["nearby-facilities"] . "', main_roads='". $_POST["main-roads"] . "', ";
        if(isset($_POST["has-garden"]) && $_POST["has-garden"] == "Yes"){
            $sql = $sql . "has_garden=1 ";
        } else {
            $sql = $sql . "has_garden=0 ";
        }
        $sql = $sql . "WHERE user_id=" . $_COOKIE["user_id"]. " AND property_id=" . $_COOKIE["property_id"] . ";";
        $result = $conn->query($sql);
        header("Location: dashboard.php");
    }
}

$sql = "SELECT * FROM properties WHERE user_id=". $_COOKIE["user_id"] ." AND property_id=" . $_COOKIE["property_id"] . ";";
$result = mysqli_query($conn, $sql);
$property = mysqli_fetch_array($result, MYSQLI_ASSOC);
if(!$property){
    header("Location: dashboard.php");
} 
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Property</title>
  <link rel="stylesheet" href="property_form.css">
  <script src="property_form.js"></script>
</head>

<body style="background-image: url('http://codd.cs.gsu.edu/~gganapathiappan1/WP/PW/Final/background.jpg')">
    <div id="form-container">
        <h1 style="text-align: center;">Edit Property</h1>
        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
            <?php if(strlen($error) != 0) { echo "<p style='color: red;'>".$error."</p>"; }?>
            <label>Upload floor plan (.jpg, .jpeg, .png - 500MB max):</label>
            <input type="file" id="floor-plan" name="floor-plan" accept="image/jpeg,image/jpg,image/png"><br>
            <label for="street-address">Street Address:</label><br>
            <input type="text" size="100" maxlength="100" placeholder="Street Address" id="street-address" name="street-address" value=<?php echo "\"" . $property["street_address"] . "\""; ?>><br>
            <label for="city">City:</label><br>
            <input type="text" size="35" maxlength="100" placeholder="City" id="city" name="city" value=<?php echo "\"" . $property["city"] . "\""; ?>><br>
            <label for="state">State:</label><br>
            <input type="text" size="35" maxlength="100" placeholder="State" id="state" name="state" value=<?php echo "\"" . $property["property_state"] . "\""; ?>><br>
            <label for="country">Country:</label><br>
            <input type="text" size="35" maxlength="100" placeholder="Country" id="country" name="country" value=<?php echo "\"" . $property["country"] . "\""; ?>><br>
            <label for="price">Price:</label><br>
            <input type="number" min="0" placeholder="Price" id="price" name="price" value=<?php echo "\"" . $property["price"] . "\""; ?>><br>
            <label for="age">Age:</label><br>
            <input type="number" min="0" placeholder="Age" id="age" name="age" value=<?php echo "\"" . $property["age"] . "\""; ?>><br>
            <label for="num-of-bedrooms">Number of bedrooms:</label><br>
            <input type="number" min="0" placeholder="Number of bedrooms" id="num-of-bedrooms" name="num-of-bedrooms" value=<?php echo "\"" . $property["number_of_bedrooms"] . "\""; ?>><br>
            <label for="additional-facilities">Additional facilities:</label><br>
            <input type="text" size="100" maxlength="100" placeholder="Additional facilities" id="additional-facilities" name="additional-facilities" value=<?php echo "\"" . $property["additional_facilities"] . "\""; ?>><br>
            <label for="parking-availability">Parking availability:</label><br>
            <input type="text" size="100" maxlength="100" placeholder="Parking availability" id="parking-availability" name="parking-availability" value=<?php echo "\"" . $property["parking_availability"] . "\""; ?>><br>
            <label for="nearby-facilities">Nearby facilities:</label><br>
            <textarea id="nearby-facilities" name="nearby-facilities" rows="5" cols="50" maxlength="250"><?php echo $property["nearby_facilities"]; ?></textarea><br>
            <label for="main-roads">Main roads:</label><br>
            <textarea id="main-roads" name="main-roads" rows="5" cols="50" maxlength="250"><?php echo $property["main_roads"]; ?></textarea><br>
            <label for="has-garden">Does the property have a garden?</label>
            <input type="checkbox" id="has-garden" name="has-garden" value="Yes" <?php if($property["has_garden"] == 1){ echo "checked"; }?>><br>
            <input type="submit" id="submit" name="update-property" value="Update Property">
        </form>
        <button id="cancel" onclick="return onCancelClick(); ">Cancel</button>
    </div>
</body>

</html>