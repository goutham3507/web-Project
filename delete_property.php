<?php
include("connectToDB.php");
if(!isset($_COOKIE["user_id"]) || $_COOKIE["user_id"] < 0) {
    header("Location: login.php");
}
if(!isset($_COOKIE["delete_property_id"]) || $_COOKIE["delete_property_id"] < 0) {
    header("Location: dashboard.php");
}

$sql = "DELETE FROM properties WHERE user_id=" . $_COOKIE["user_id"] ." AND property_id=". $_COOKIE["delete_property_id"] .";";
$result = mysqli_query($conn, $sql);
$conn->close();

$_COOKIE["delete_property_id"] = -1;
header("Location: dashboard.php");
?>