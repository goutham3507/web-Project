<?php
include("connectToDB.php");
if(!isset($_COOKIE["user_id"]) || $_COOKIE["user_id"] < 0) {
    header("Location: login.php");
}

if (isset($_POST["add-property"])) {
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
        $input_names = array("street-address", "city", "state", "country", "price", "age", "num-of-bedrooms", "additional-facilities", "parking-availability", "nearby-facilities", "main-roads");
        $sql = "INSERT INTO properties (floor_plan, street_address, city, property_state, country, price, age, number_of_bedrooms, additional_facilities, parking_availability, nearby_facilities, main_roads, has_garden, user_id) VALUES ( ";
        $sql = $sql . "' ". $fileNameNew ."', ";
        foreach($input_names as $input_name){
            if($input_name != "price" && $input_name != "age"){
                $sql = $sql . "'". $_POST[$input_name] . "', ";
            } else {
                $sql = $sql . $_POST[$input_name] . ", ";
            }
        }
        if(isset($_POST["has-garden"]) && $_POST["has-garden"] == "Yes"){
            $sql = $sql . "1, ";
        } else {
            $sql = $sql . "0, ";
        }
        $sql = $sql . $_COOKIE["user_id"] . ");";
        $result = $conn->query($sql);
        $conn->close();
        header("Location: dashboard.php");
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Property</title>
  <link rel="stylesheet" href="property_form.css">
  <script src="property_form.js"></script>
</head>

<body style="background-image: url('http://codd.cs.gsu.edu/~gganapathiappan1/WP/PW/Final/background.jpg')">
    <div id="form-container">
    <?php echo $fileDestination; ?>
    <h1 style="text-align: center;">Add Property</h1>
        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
            <label>Upload floor plan (.jpg, .jpeg, .png - 500MB max):</label>
            <input type="file" id="floor-plan" name="floor-plan" accept="image/jpeg,image/jpg,image/png"><br>
            <label for="street-address">Street Address:</label><br>
            <input type="text" size="100" maxlength="100" placeholder="Street Address" id="street-address" name="street-address"><br>
            <label for="city">City:</label><br>
            <input type="text" size="35" maxlength="100" placeholder="City" id="city" name="city"><br>
            <label for="state">State:</label><br>
            <input type="text" size="35" maxlength="100" placeholder="State" id="state" name="state"><br>
            <label for="country">Country:</label><br>
            <input type="text" size="35" maxlength="100" placeholder="Country" id="country" name="country"><br>
            <label for="price">Price:</label><br>
            <input type="number" min="0" placeholder="Price" id="price" name="price"><br>
            <label for="age">Age:</label><br>
            <input type="number" min="0" placeholder="Age" id="age" name="age"><br>
            <label for="num-of-bedrooms">Number of bedrooms:</label><br>
            <input type="number" min="0" placeholder="Number of bedrooms" id="num-of-bedrooms" name="num-of-bedrooms"><br>
            <label for="additional-facilities">Additional facilities:</label><br>
            <input type="text" size="100" maxlength="100" placeholder="Additional facilities" id="additional-facilities" name="additional-facilities"><br>
            <label for="parking-availability">Parking availability:</label><br>
            <input type="text" size="100" maxlength="100" placeholder="Parking availability" id="parking-availability" name="parking-availability"><br>
            <label for="nearby-facilities">Nearby facilities:</label><br>
            <textarea id="nearby-facilities" name="nearby-facilities" rows="5" cols="50" maxlength="250"></textarea><br>
            <label for="main-roads">Main roads:</label><br>
            <textarea id="main-roads" name="main-roads" rows="5" cols="50" maxlength="250"></textarea><br>
            <label for="has-garden">Does the property have a garden?</label>
            <input type="checkbox" id="has-garden" name="has-garden" value="Yes"><br>
            <input type="submit" id="submit" name="add-property" value="Add Property"> 
        </form>
        <button id="cancel" onclick="return onCancelClick(); ">Cancel</button>
    </div>
</body>

</html>