<?php
// Database connection parameters
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";

// Create a database connection
$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$uin = "";
$studentData = null;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['uin'])) {
    // Get the UIN entered by the admin
    $uin = $conn->real_escape_string($_POST['uin']);

    // Query to retrieve student information using JOINs without a view
    $sql = "
    SELECT
        u.UIN,
        u.First_Name,
        u.Last_Name,
        i.Name,
        c.Class_Name,
        cer.Cert_Name
    FROM users u
    LEFT JOIN internship i ON u.UIN = i.UIN
    LEFT JOIN classes c ON u.UIN = c.UIN
    LEFT JOIN certification cer ON u.UIN = cer.UIN
    WHERE u.UIN = '$uin';
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $studentData = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $studentData = "No results found for the entered UIN";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Student Information</title>
</head>
<body>
    <h1>Admin Student Information</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Enter UIN: <input type="text" name="uin">
        <input type="submit" value="Retrieve Information">
    </form>

    <?php
    // Display student information
    if (is_array($studentData)) {
        echo "<h2>Student Information:</h2>";
        foreach ($studentData as $data) {
            echo "UIN: " . $data['UIN'] . "<br>";
            echo "Name: " . $data['First_Name'] . " " . $data['Last_Name'] . "<br>";
            echo "Internship: " . $data['Name'] . "<br>";
            echo "Class: " . $data['Class_Name'] . "<br>";
            echo "Certification: " . $data['Cert_Name'] . "<br><br>";
        }
    } elseif ($studentData) {
        echo "<p>$studentData</p>";
    }
    ?>
</body>
</html>
