<?php
    include_once 'includes/dbh.inc.php';
    session_start();

    function userExists($uin, $conn) {
        // Prepare the statement
        $stmt = $conn->prepare("SELECT UIN FROM users WHERE UIN = ?");
        // Bind the parameter
        $stmt->bind_param("i", $uin); // Assuming UIN is an integer, use "s" if it's a string     
        // Execute the statement
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        // Close the statement
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Insertion</h1>
    <form method="post" action="">
        <input type="hidden" name="form_id" value="insert">
    
        <label for="UIN">UIN:</label>
        <input type="text" name="UIN" id="UIN" value="1" required><br>
    
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" value="John" required><br>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" value="Doe" required><br>
        
        <label for="Username">Username:</label>
        <input type="text" name="username" id="username" value="johndoe1" required><br>

        <label for="Password">Password:</label>
        <input type="text" name="password" id="password" value="password" required><br>

        <label for="user_type">User Type:</label>
        <select name="user_type" id="user_type">
            <option value="admin">Admin</option>
            <option value="student">Student</option>
        </select> <br>

        <label for="Email">Email:</label>
        <input type="text" name="Email" id="Email" value="johndoe@gmail.com" required><br>

        <label for="Discord">Discord:</label>
        <input type="text" name="Discord" id="Discord" value="johndoe2023" required><br>

        <input type="submit" value="Submit Form 1">
    </form>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formId = $_POST['form_id'];
        if($formId == "insert"){
            $newUIN = $_POST['UIN'];
            $newFirstName = $_POST['firstName'];
            $newLastName = $_POST['lastName'];
            $newUsername = $_POST['username'];
            $newPassword = $_POST['password'];
            $newUsertype = $_POST['user_type'];
            $newEmail = $_POST['Email'];
            $newDiscord = $_POST['Discord'];

            if(!userExists($newUIN, $conn)){

                $sql = "INSERT INTO `users` (`UIN`, `First_Name`, `M_Initial`, `Last_Name`, `Username`, `Passwords`, `User_Type`, `Email`, `Discord_Name`)
            VALUES ($newUIN, '$newFirstName', NULL, '$newLastName', '$newUsername', '$newPassword', '$newUsertype', '$newEmail', '$newDiscord')";

                if ($conn->query($sql) === TRUE) {
                    echo "Inserted $newUsertype $newFirstName $newLastName with the username $newUsername";
                } else {
                    echo "Error adding admin user: " . $conn->error;
                }
            }else{
                echo "$newUIN already present in the database.";
            }
        }
    }
?>

<h1>Updates</h2>
<!-- Form 2 -->
    <form method="post" action="">
        <input type="hidden" name="form_id" value="update">
        <!-- Other form fields for Form 2 -->
        <input type="submit" value="Submit Form 2">
    </form>

    <?php

    ?>

<!-- Form 3 -->
<h1>Selection</h1>
<form method="post" action="">
    <input type="hidden" name="form_id" value="select">

    <label for="role">Select Information to Display:</label>
    <select name="role" id="role">
        <?php 
            if($_SESSION['role'] == "admin"){
                echo "<option value='all'>All</option>";
                echo "<option value='student'>Student</option>";
                echo "<option value='admin'>Admin</option>";
            }
        ?>
        <option value="own">Own Profile</option>
    </select>

    <input type="submit" value="Submit Form 3">
</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formId = $_POST['form_id'];
        if($formId == "select"){
            // Get the selected role from the form
            $selectedRole = $_POST['role'];
            // Query to fetch users based on the selected role
            if($selectedRole == "all"){
                $sql = "SELECT * FROM users";
            }else if($selectedRole == "own"){
                $ownUIN = $_SESSION['UIN'];
                $sql = "SELECT * FROM users WHERE UIN = $ownUIN";
            }else{
                $sql = "SELECT * FROM users WHERE role = '$selectedRole'";
            }
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                // Output data of each user
                while ($row = $result->fetch_assoc()) {
                    echo "User ID: " . $row["UIN"] . " - Name: " . $row["First_Name"] . " - Email: " . $row["Email"] . " - Role: " . $row["Role"] . "<br>";
                }
            } else {
                echo "No users found for the selected role.";
            }
        }
    }
?>
<!-- Form 4 -->
<h1>Deletion</h1>
<form method="post" action="">
    <input type="hidden" name="form_id" value="delete">
    <!-- Other form fields for Form 4 -->
    <input type="submit" value="Submit Form 4">
</form>

<?php

?>
    
</body>
</html>