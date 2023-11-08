<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'tablebanam');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$query="DELETE FROM tbl_users where id=?";
$stmt=$conn->prepare($query);
$stmt->bind_param("i",$id);

if ($stmt->execute()) {
    echo "User data was deleted .";
} else {
    echo "Error deleting user data: " . $stmt->error;
}
?>
<html>
    <head><title>Delete</title></head>
</html>