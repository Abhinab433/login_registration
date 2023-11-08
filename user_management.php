<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {header("Location: login.html");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'tablebanam');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }
    else{

// Query the database to fetch user data
$query = "SELECT * FROM tbl_users";
$result = $conn->query($query);
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        table,td{
            border:solid 1px;
            background-color:white;
            border-radius:10px;
            padding:10px;
        }
        body{
            background-color:red;
        }
        div{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h2{
            text-align:center;
            color:white;
        }
    </style>
</head>
<body>
    
    <h2>User Management</h2>
    <div>
    <table>
        <tr>          
            <th>Username</th>
            <th>Full Name</th>
            
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>               
                <td><?= $row["username"] ?></td>
                <td><?= $row["fullname"] ?></td>
                <td>
                    <a href="view_user.php?id=<?= $row["id"] ?>">View</a>
                    <a href="edit_user.php?id=<?= $row["id"] ?>">Edit</a>
                    <a href="delete_user.php?id=<?= $row["id"] ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    </div>
</body>
</html>
        