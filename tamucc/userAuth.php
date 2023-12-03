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
            $newLastName = $_POST['lastName'];
            $newUsername = $_POST['username'];
            $newPassword = $_POST['password'];
            $newUsertype = $_POST['user_type'];
            $newEmail = $_POST['Email'];
            $newDiscord = $_POST['Discord'];

            if(!userExists($newUIN, $conn)){

                $baseSql = "INSERT INTO `users` (`UIN`, `First_Name`, `M_Initial`, `Last_Name`, `Username`, `Passwords`, `User_Type`, `Email`, `Discord_Name`)
            VALUES ($newUIN, '$newFirstName', NULL, '$newLastName', '$newUsername', '$newPassword', '$newUsertype', '$newEmail', '$newDiscord')";

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
                $sql = "SELECT * FROM users WHERE User_Type = '$selectedRole'";
            }
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                // Output data of each user
                while ($row = $result->fetch_assoc()) {
                    echo "User ID: " . $row["UIN"] . " - Name: " . $row["First_Name"] . " - Email: " . $row["Email"] . " - Role: " . $row["User_Type"];
                    if($row["User_Type"] == "Student"){
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