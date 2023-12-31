<?php
    include_once 'includes/dbh.inc.php';

    $server_name = "localhost";
    $user_name = "pma";

    $connection = mysqli_connect($server_name, $user_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

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
    <title>Document</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="header">
        <h1>Programs</h1>
        <a href="/TAMUCybersecurityDatabase/tamucc/index.php">Home</a>
    </div>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Submit</button>
</form>

    
</body>
</html>