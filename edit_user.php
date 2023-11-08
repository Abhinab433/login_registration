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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $hobbies = $_POST['hobbies'];

    $query = "UPDATE tbl_users SET username=?, password=?, fullname=?, gender=?, country=?, hobbies=? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $username, $password, $fullname, $gender, $country, $hobbies, $id);
    if ($stmt->execute()) {
        echo "User data updated successfully.";
    } else {
        echo "Error updating user data: " . $stmt->error;
    }
}

$query = "SELECT * FROM tbl_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found or multiple users with the same ID.";
}

$conn->close();
?>

<html>
<head>
    <title>Edit</title>
    <style>
            body{
                background-color:bisque;
            }
        </style>
</head>
<body>
    <h1>Edit User Profile</h1>
    <form method="post" action="edit_user.php?id=<?php echo $id; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <h2>Edit Form</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>"><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo $user['password']; ?>"><br>
        <label for="confirmpassword">Confirm Password:</label>
        <input type="password" name="confirmpassword" id="confirmpassword"value="<?php echo $user['password']; ?>"><br>
        <label for="fullname">Full Name:</label>
        <input type="text" name="fullname" id="fullname" value="<?php echo $user['fullname']; ?>"><br>
        <select name="gender" required>
            <option value="male" <?php if ($user['gender'] === 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if ($user['gender'] === 'female') echo 'selected'; ?>>Female</option>
            <option value="other" <?php if ($user['gender'] === 'other') echo 'selected'; ?>>Other</option>
        </select><br>
        <label for="country">Country:</label>
        <input type="text" name="country" id="country" value="<?php echo $user['country']; ?>"><br>
        <label for="hobbies">Hobbies:</label>
        <input type="text" name="hobbies" id="hobbies" value="<?php echo $user['hobbies']; ?>"><br>
        <input type="submit" value="Update">
    </form>
    <p><a href="user_management.php">Go Back</a></p>
</body>
</html>
