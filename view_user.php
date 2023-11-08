<html>
    <head><title>View</title>
    <style>
            body{
                background-color:skyblue;
            }
        </style></head>
    <body>
        <?php
            $conn = new mysqli('localhost', 'root', '', 'tablebanam');
            if ($conn->connect_error) 
            {
                 die("Connection Failed: " . $conn->connect_error);
            }
            else{
               $id=$_GET['id'];
               $query = "SELECT * FROM tbl_users WHERE id = ?";
               $stmt = $conn->prepare($query);
               $stmt->bind_param("i", $id);
               $stmt->execute();
               $result = $stmt->get_result();
               if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();}
            }
        ?>
        <h1>User Profile</h1>
              <p>User Name: <?php echo $user['username']; ?></p>
              <p>Full Name <?php echo $user['fullname']; ?></p>
              <p>Gender <?php echo $user['gender']; ?></p>
              <p>Country <?php echo $user['country']; ?></p>
              <p>Hobbies <?php echo $user['hobbies']; ?></p>
              <p><a href="user_management.php">Go Back</a></p>
    </body>
</html>