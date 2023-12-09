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

    function collegestudentExists($uin, $conn) {
        // Prepare the statement
        $stmt = $conn->prepare("SELECT UIN FROM collegestudents WHERE UIN = ?");
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

    function columnExists($tableName, $columnName, $conn) {
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // SQL query
        $sql = "SELECT COUNT(*)
                FROM information_schema.columns
                WHERE table_name = '$tableName' AND column_name = '$columnName'";
        // Execute query
        $result = $conn->query($sql);
        // Check if the column exists
        $exists = $result->fetch_row()[0] > 0;
        return $exists;
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
    <a href="index.php">Home</a> <br>
    <h1>User Management and Authentication</h1>
    <h2>Insertion</h2>
    <form method="post" action="">
        <input type="hidden" name="form_id" value="insert">
    
        <label for="UIN">UIN:</label>
        <input type="text" name="UIN" id="UIN" value="1" required><br>
    
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" value="John" required><br>

        <label for="mInitial">Middle Initial:</label>
        <input type="text" name="mInitial" id="mInitial" value=""><br>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" value="Doe" required><br>
        
        <label for="Username">Username:</label>
        <input type="text" name="username" id="username" value="johndoe1" required><br>

        <label for="Password">Password:</label>
        <input type="text" name="password" id="password" value="password" required><br>

        <label for="user_type">User Type:</label>
        <select name="user_type" id="user_type">
            <?php
                if($_SESSION['role'] == "admin"){
                    echo "<option value='admin'>Admin</option>";
                }
            ?>
            <option value="student">Student</option>
        </select> <br>

        <label for="Email">Email:</label>
        <input type="text" name="Email" id="Email" value="johndoe@gmail.com" required><br>

        <label for="Discord">Discord:</label>
        <input type="text" name="Discord" id="Discord" value="johndoe2023" required><br>

        <h3>Add only if inserting student</h3>

        <label for="gender">Gender:</label>
        <select name="gender" id="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br>

        <label for="hispanic">Hispanic/Latino:</label>
        <select name="hispanic" id="hispanic">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select><br>

        <label for="Discord">Race:</label>
        <input type="text" name="race" id="race" value="Indian" required><br>

        <label for="citizen">US Citizen:</label>
        <select name="citizen" id="citizen">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select><br>

        <label for="firstGen">First Generation:</label>
        <select name="firstGeneration" id="firstGeneration">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select><br>

        <label for="Date of Birth">Date of Birth (YYYY-MM-DD):</label>
        <input type="text" name="DoB" id="DoB" value="2000-01-01" required><br>

        <label for="gpa">Select GPA:</label>
        <select name="gpa" id="gpa">
            <?php
            // Generate options for GPA from 0.0 to 4.0
            for ($i = 40; $i >= 0; $i = $i-1) {
                $gpaValue = $i / 10.0;
                echo "<option value=\"$gpaValue\">$gpaValue</option>";
            }
            ?>
        </select><br>

        <label for="major">Major:</label>
        <input type="text" name="major" id="major" value="Accounting" required><br>

        <label for="minor1">Minor 1:</label>
        <input type="text" name="minor1" id="minor1" value=""><br>

        <label for="minor2">Minor 2:</label>
        <input type="text" name="minor2" id="minor2" value=""><br>

        <label for="expectedGrad">Expected Graduation (YYYY):</label>
        <input type="text" name="expectedGrad" id="expectedGrad" value="2023" required><br>

        <label for="school">School:</label>
        <input type="text" name="school" id="school" value="Texas A&M" required><br>

        <label for="currentClassification">Current Classification:</label>
        <select name="currentClassification" id="currentClassification">
            <option value="Freshman">Freshman</option>
            <option value="Sophomore">Sophomore</option>
            <option value="Junior">Junior</option>
            <option value="Senior">Senior</option>
            <option value="PostGrad">Post Grad</option>
        </select><br>

        <label for="Phone">Phone Number (XXXXXXXXXX):</label>
        <input type="text" name="phoneNum" id="phoneNum" value="1234567890" required><br>

        <label for="studentType">Student Type:</label>
        <select name="studentType" id="studentType">
            <option value="Undergrad">Undergrad</option>
            <option value="PostGrad">Post-Grad</option>
            <option value="Doctoral">Doctoral</option>
        </select><br>

        <input type="submit" value="Insert User">
    </form>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formId = $_POST['form_id'];
        if($formId == "insert"){
            $newUIN = $_POST['UIN'];
            $newFirstName = $_POST['firstName'];
            $newMiddleInitial = $_POST['mInitial'];
            $newLastName = $_POST['lastName'];
            $newUsername = $_POST['username'];
            $newPassword = $_POST['password'];
            $newUsertype = $_POST['user_type'];
            $newEmail = $_POST['Email'];
            $newDiscord = $_POST['Discord'];

            if($newMiddleInitial = ""){
                $newMiddleInitial = NULL;
            }

            if(!userExists($newUIN, $conn)){

                $baseSql = "INSERT INTO `users` (`UIN`, `First_Name`, `M_Initial`, `Last_Name`, `Username`, `Passwords`, `User_Type`, `Email`, `Discord_Name`)
            VALUES ($newUIN, '$newFirstName', '$newMiddleInitial', '$newLastName', '$newUsername', '$newPassword', '$newUsertype', '$newEmail', '$newDiscord')";

                if ($conn->query($baseSql) === TRUE) {
                    echo "Inserted $newUsertype $newFirstName $newLastName with the username $newUsername";
                } else {
                    echo "Error adding admin user: " . $conn->error;
                }

                if($newUsertype == "student"){
                    $gender = $_POST['gender'];
                    $hispanic = $_POST['hispanic'];
                    $race = $_POST['race'];
                    $citizen = $_POST['citizen'];
                    $firstGen = $_POST['firstGeneration'];
                    $dob = $_POST['DoB'];
                    $gpa = $_POST['gpa'];
                    $major = $_POST['major'];
                    $minor1 = $_POST['minor1'];
                    $minor2 = $_POST['minor2'];
                    $expectedGrad = $_POST['expectedGrad'];
                    $school = $_POST['school'];
                    $currentClass = $_POST['currentClassification'];
                    $phone = $_POST['phoneNum'];
                    $stuType = $_POST['studentType'];

                    if($minor1 == ""){
                        $minor1 == 'NULL';
                    }

                    if($minor2 == ""){
                        $minor2 == 'NULL';
                    }

                    $studentSql = "INSERT INTO `collegestudents` (
                        `UIN`,
                        `Gender`,
                        `HispanicLatino`,
                        `Race`,
                        `USCitizen`,
                        `First_Generation`,
                        `DoB`,
                        `GPA`,
                        `Major`,
                        `Minor1`,
                        `Minor2`,
                        `Expected_Graduation`,
                        `School`,
                        `Current_Classification`,
                        `Phone`,
                        `Student_Type`
                    ) VALUES (
                        '$newUIN',
                        '$gender',
                        '$hispanic',
                        '$race',
                        '$citizen',
                        '$firstGen',
                        '$dob',
                        '$gpa',
                        '$major',
                        '$minor1',
                        '$minor2',
                        '$expectedGrad',
                        '$school',
                        '$currentClass',
                        '$phone',
                        '$stuType'
                    )";

                    if ($conn->query($studentSql) === TRUE) {
                        echo "Inserted $newUsertype $newFirstName $newLastName with UIN $newUIN and GPA $gpa";
                    } else {
                        echo "Error adding student user: " . $conn->error;
                    }
                }

            }else{
                echo "$newUIN already present in the database.";
            }
        }
    }
?>

<h2>Updates</h2>
<!-- Form 2 -->
    <form method="post" action="">
        <input type="hidden" name="form_id" value="update">

        <?php
        if($_SESSION['role'] == 'admin'){
            echo "<label for='uinToChange'>UIN to Change:</label>";
            echo "<input type='text' name='uinToChange' id='uinToChange' value='' required><br>";
        }else{
            $userUIN = $_SESSION['UIN'];
            echo "<input type='hidden' name='uinToChange' value='$userUIN'>";
        }

        ?>

        <label for="columnToChange">Attribute to Change:</label>
        <select name="columnToChange" id="columnToChange">
            <?php
            if($_SESSION['role'] == 'admin'){
                echo '<option value="User_Type">User Type</option>';
                echo '<option value="GPA">GPA</option>';
                echo '<option value="Major">Major</option>';
                echo '<option value="Minor1">Minor1</option>';
                echo '<option value="Minor2">Minor2</option>';
                echo '<option value="Expected_Graduation">Expected Graduation</option>';
                echo '<option value="School">School</option>';
                echo '<option value="Current_Classification">Current Classification</option>';
                echo '<option value="Phone">Phone Number</option>';
                echo '<option value="Student_type">Student Type</option>';
            }
            ?>
            
            <option value="Email">Email</option>
            <option value="Discord_Name">Discord Name</option>
            <option value="Gender">Gender</option>
            <option value="HispanicLatino">Hispanic/Latino</option>
            <option value="Race">Race</option>
            <option value="USCitizen">US Citizen</option>
            <option value="First_Generation">First Generation</option>
            <option value="DoB">Date of Birth</option>
            <option value="First_Name">First Name</option>
            <option value="M_Initial">Middle Initial</option>
            <option value="Last_Name">Last Name</option>
            <option value="Username">Username</option>
            <option value="Passwords">Password</option>
        </select><br>

        <label for="newValue">New Value:</label>
        <input type="text" name="newValue" id="newValue" value="" required><br>

        <input type="submit" value="Submit Form 2">
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $formId = $_POST['form_id'];
            if($formId == "update"){
                $uinToChange = $_POST['uinToChange'];
                $attributeToChange = $_POST['columnToChange'];
                $newValue = $_POST['newValue'];

                if(userExists($uinToChange, $conn)){
                    $sql = "";

                    if(columnExists('users', $attributeToChange, $conn)){
                        $sql = "UPDATE users SET $attributeToChange = '$newValue' WHERE UIN = $uinToChange";
                    }else{
                        $sql = "UPDATE collegestudents SET $attributeToChange = '$newValue' WHERE UIN = $uinToChange";
                    }

                    if ($conn->query($sql) === TRUE) {
                        echo "$attributeToChange updated successfully to $newValue for $uinToChange";
                    } else {
                        echo "Error updating $attributeToChange: " . $conn->error;
                    }

                }else{
                    echo "User with that UIN not found.";
                }
            }
        }
    ?>

<!-- Form 3 -->
<h2>Selection</h2>
<form method="post" action="">
    <input type="hidden" name="form_id" value="select">

    <label for="role">Select Information to Display:</label>
    <select name="role" id="role">
        <?php 
            if($_SESSION['role'] == "admin"){
                echo "<option value='student'>Student</option>";
                echo "<option value='admin'>Admin</option>";
                echo "<option value='deactivated'>Deactivated</option>";
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
            $ownUIN = $_SESSION['UIN'];
            // Query to fetch users based on the selected role
            if($selectedRole == "own"){
                $sql = "SELECT * FROM users WHERE UIN = $ownUIN";
            }else if($selectedRole == 'student'){
                $sql = "SELECT * FROM student_users";
            }else if($selectedRole == 'admin'){
                $sql = "SELECT * FROM admin_users";      
            }else{
                $sql = "SELECT * FROM deactivated_users";
            }

            $result = $conn->query($sql);
            
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>UIN</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Email</th>";
            echo "<th>Role</th>";
            echo "<th>Discord Name</th>";
            if ($selectedRole == 'student' || collegestudentExists($ownUIN, $conn)) {
                echo "<th>Gender</th>";
                echo "<th>GPA</th>";
                echo "<th>Major</th>";
                echo "<th>Expected Graduation</th>";
                echo "<th>School</th>";
                echo "<th>Current Classification</th>";
                echo "<th>Phone</th>";
                echo "<th>Student Type</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            if ($result->num_rows > 0) {
                // Output data for each user
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["UIN"] . "</td>";
                    echo "<td>" . $row["First_Name"] . "</td>";
                    echo "<td>" . $row["Last_Name"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["User_Type"] . "</td>";
                    echo "<td>" . $row["Discord_Name"] . "</td>";
                    if ($row["User_Type"] == "student") {
                        // Fetch student details and output
                        $studentUIN = $row["UIN"];
                        $studentSql = "SELECT * FROM collegestudents WHERE UIN=$studentUIN";
                        $studentResult = $conn->query($studentSql);
                        $stuRow = $studentResult->fetch_assoc();
                        echo "<td>" . $stuRow['Gender'] . "</td>";
                        echo "<td>" . $stuRow['GPA'] . "</td>";
                        echo "<td>" . $stuRow['Major'] . "</td>";
                        echo "<td>" . $stuRow['Expected_Graduation'] . "</td>";
                        echo "<td>" . $stuRow['School'] . "</td>";
                        echo "<td>" . $stuRow['Current_Classification'] . "</td>";
                        echo "<td>" . $stuRow['Phone'] . "</td>";
                        echo "<td>" . $stuRow['Student_Type'] . "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>No users found for the selected role.</td></tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
        }
    }
?>
<!-- Form 4 -->
<h2>Deletion</h2>
    <?php
        if($_SESSION['role'] == 'admin'){
            echo "<form method='post' action=''>";
            echo "  <input type='hidden' name='form_id' value='delete'>";
            echo "  <label for='uinToChange'>UIN to Delete:</label>";
            echo "  <input type='text' name='uinToChange' id='uinToChange' value='' required><br>";
            echo "  <input type='submit' value='Delete UIN'><br>";
            echo "</form>";
        }
    ?>

<form method='post' action=''>
    <input type='hidden' name='form_id' value='deactivate'>
    <?php
        if($_SESSION['role'] == 'admin'){
            echo "<label for='uinToChange'>UIN to Deactivate:</label>";
            echo "<input type='text' name='uinToChange' id='uinToChange' value='' required><br>";
        }else{
            $userUIN = $_SESSION['UIN'];
            echo "<input type='hidden' name='form_id' value='$userUIN'>";
        }
    ?>
        <input type ='submit' value='Deactivate'> 
</form>

<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formId = $_POST['form_id'];
        if($formId == 'delete'){
            $uinToChange = $_POST['uinToChange'];
            if(collegestudentExists($uinToChange, $conn)){
                $sql = "DELETE FROM `collegestudents` WHERE UIN = '$uinToChange'";
                if ($conn->query($sql) === TRUE) {
                    echo "$uinToChange deleted.";
                } else {
                    echo "Error deleting student.";
                }
            }

            if(userExists($uinToChange, $conn)){
                $sql = "DELETE FROM `users` WHERE UIN = '$uinToChange'";
                if ($conn->query($sql) === TRUE) {
                    echo "$uinToChange deleted.";
                } else {
                    echo "Error deleting student.";
                }
            }else{
                echo "User doesn't exist.";
            }
        }

        if($formId == 'deactivate'){
            $uinToChange = $_POST['uinToChange'];
            if(userExists($uinToChange, $conn)){
                $sql = "UPDATE users SET User_Type = 'deactivated' WHERE UIN = $uinToChange";
                if ($conn->query($sql) === TRUE) {
                    echo "$uinToChange deactivated.";
                } else {
                    echo "Error deleting student.";
                }
            }
        }
    }
?>
    
</body>
</html>