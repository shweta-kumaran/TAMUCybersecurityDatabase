<?php
    include_once 'includes/dbh.inc.php';
    session_start();

    // $server_name = "localhost";
    // $user_name = "pma";
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $connection = mysqli_connect($server_name, $user_name);

    // echo "Connected successfully";

    // "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
</head>
<body>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Submit</button>
    </form>
    <h1>Event Management</h1>
    <!-- <form action="" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form> -->

    <!-- Selection form -->
    <h2>Select and View Events</h2>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="select">

        <label for = "event_ID">Select all events or an event ID:</label>
        <select name = "event_ID" id = "event_ID">
            <option value = "all"> All events </option>

            <?php
                $query = "SELECT * FROM event_info";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Event_ID"] . "'>" . $row["Event_ID"] . "</option>";
                    }
                } 
            ?>
        </select><br>
        <input type="submit" value="Select Events Form">
    </form>

            

    <!-- Selection php -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formID = $_POST['form_id'];
        if($formID == "event"){
            // Get the selected role from the form
            $selectedRole = $_POST['event_ID'];
            // Query to fetch users based on the selected role
            if($selectedRole == "all"){
                $sql = "SELECT * FROM users";
            }else if($selectedRole == "own"){
                $ownUIN = $_SESSION['UIN'];
                $sql = "SELECT * FROM users WHERE UIN = $ownUIN";
            }else{
                $sql = "SELECT * FROM users WHERE User_Type = '$selectedRole'";
            }
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                // Output data of each user
                while ($row = $result->fetch_assoc()) {
                    echo "User ID: " . $row["UIN"] . " - Name: " . $row["First_Name"] . " - Email: " . $row["Email"] . " - Role: " . $row["User_Type"];
                    if($row["User_Type"] == "student"){
                        $studentUIN = $row["UIN"];
                        $studentSql = "SELECT * FROM collegestudents WHERE UIN=$studentUIN";
                        $studentResult = $conn->query($studentSql);
                        $stuRow = $studentResult->fetch_assoc();
                        echo " - Gender: " . $stuRow['Gender'] . " - GPA: " . $stuRow['GPA'] . 
                        " - Major: " . $stuRow['Major'] . " - Expected Graduation: " . $stuRow['Expected_Graduation'] . 
                        " - School: " . $stuRow['School'] . " - Current Classification: " . $stuRow['Current_Classification'] . 
                        " - Phone: " . $stuRow['Phone'] . " - Student Type: " . $stuRow['Student_Type'];
                    }
                    echo "<br>";
                }
            } else {
                echo "No users found for the selected role.";
            }
        }
        

        
    }
    ?>

    <!-- Insertion form -->
    <h2>Insert an Event</h2> <br>

    <!-- Insertion php -->


    <!-- Deletion form -->
    <h2>Delete an Event</h2> <br>

    <!-- Deletion php -->


    <!-- Update form -->
    <h2>Update an Event</h2> <br>

    <!-- Update php -->
    

</body>
</html>