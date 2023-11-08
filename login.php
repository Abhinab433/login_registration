<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $conn = new mysqli('localhost', 'root', '', 'tablebanam');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } else {
        $query = "SELECT * FROM tbl_users WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if ($password===$user["password"]) {
                $_SESSION["authenticated"] = true;header("Location: user_management.php");
                exit();
            }
        } else {
            // Authentication failed
            echo "Login failed. Please try again.";
        }
    }
    $stmt->close();
    $conn->close();
}
?>
