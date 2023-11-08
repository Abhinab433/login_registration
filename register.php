<?php
$conn = new mysqli('localhost', 'root', '', 'tablebanam');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "CREATE TABLE IF NOT EXISTS tbl_Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    country VARCHAR(255) NOT NULL,
    hobbies VARCHAR(255) NOT NULL
)";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $fullname = $_POST["fullname"];
    $gender = $_POST["gender"];
    $country = $_POST["country"];
    $hobbies = $_POST["hobbies"];

    // Server-side validation
    if ($password != $confirmpassword) {
        die("Password and Confirm Password do not match.");
    }
    
    if (strlen($password) < 8) {
        die("Password must be at least 8 characters long.");
    }

    

    $sql = "INSERT INTO tbl_Users (username, password,fullname, gender, country, hobbies) VALUES (?,?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssss", $username, $password, $fullname, $gender, $country, $hobbies);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
echo "<a href='index.html'>Go Back to From</a>";
?>
