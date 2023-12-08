<?php
echo '    <link rel="stylesheet" href="/TAMUCybersecurityDatabase/tamucc/includes/styles.css">';

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";


$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$classId = mysqli_real_escape_string($conn, $_POST['classId']);
$className = mysqli_real_escape_string($conn, $_POST['className']);
$classDesc = mysqli_real_escape_string($conn, $_POST['classDesc']);
$classType = mysqli_real_escape_string($conn, $_POST['classType']);

$sql = "INSERT INTO classes (Class_ID, Class_Name, Class_Desc, Class_Type) VALUES ('$classId', '$className', '$classDesc', '$classType')";

if ($conn->query($sql) === TRUE) {
    echo "New class added successfully<br>";

    // Get the newly added class ID if not provided
    $newClassId = $classId ? $classId : $conn->insert_id;

    // Retrieve and sanitize enrollment data
    $ceNum = mysqli_real_escape_string($conn, $_POST['ceNum']);
    $studentUIN = mysqli_real_escape_string($conn, $_POST['studentUIN']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    // Insert enrollment data into class_enrollment
    $enrollmentSql = "INSERT INTO class_enrollment (CE_Num, UIN, Class_ID, Stat, Semester, Year) VALUES ('$ceNum', '$studentUIN', '$newClassId', '$status', '$semester', '$year')";
    
    if ($conn->query($enrollmentSql) === TRUE) {
        echo "Enrollment added successfully";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
