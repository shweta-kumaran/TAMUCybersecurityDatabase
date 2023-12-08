<?php
    include_once 'includes/dbh.inc.php';


    session_start();

    $server_name = "localhost";
    $user_name = "pma";

    $connection = mysqli_connect($server_name, $user_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully <br>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        
        // Hash the password (make sure to use a secure hashing algorithm)
    
        // Perform SQL query
        $query = "SELECT * FROM users WHERE Username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Check if the user exists and the password is correct
        if ($result->num_rows >= 1) {
            $user = $result->fetch_assoc();
            if ($user['Passwords'] == $password) {
                // Authentication successful
                // Set session variables, e.g., $_SESSION['user_id'] = $user['id']
                $_SESSION['user_id'] = $username; 
                $_SESSION['UIN'] = $user['UIN'];
                $_SESSION['role'] = $user['User_Type'];
                echo "Authentication successful";
            } else {
                // Incorrect password
                echo "Incorrect password";
            }
        } else {
            // User not found
            echo "User not found";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles.css">
    <title>Document</title>
</head>
<body>

    <div class="header">
        <h1>Cybersecurity Center Student Tracking and Reporting</h1>
    </div>
    
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Submit</button>
    </form>

    <a href = 'studentSignUp.php'>Students sign up here!</a> <br>

    <?php
        if(isset($_SESSION['role'])){
            echo "<h3 class='welcome'>Welcome " . $_SESSION['user_id'] . " (" . $_SESSION['UIN'] .  ")! You are logged in as a " . $_SESSION['role'] . "</h3><br>";
        }else{
            echo "Please log in!";
        }
    ?>

    <a href="userAuth.php">User Management and Authentication</a> <br>
    <a href="ProgramProgressTracking/Student/studentAccess.html">Program Progress Tracking</a> <br>
    <?php
        if($_SESSION['role'] == 'Student' or $_SESSION['role'] == 'student'){
            echo "<h3>Student Sites</h3>"; 
            echo "<a href='studentDocuments.php'>Student Documents</a> <br>";
            echo "<a href='applicationInfo.php'>Application Information Mangement</a> <br>";
        }    
    ?>
    <?php
        if($_SESSION['role'] == 'admin'){
            echo "<h3>Admin Sites</h3>";    
            echo "<a href='eventMan.php'>Event Management</a> <br>";
            echo "<a href='programInfo.php'>Program Information Management</a><br>";
            echo "<a href='ProgramProgressTracking/admin/adminAccess.html'>Admin Program Tracking</a><br>";
        }   
    ?>
    


    
</body>
</html>