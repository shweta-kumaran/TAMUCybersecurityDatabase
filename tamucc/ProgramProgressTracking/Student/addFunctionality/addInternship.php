<?php
echo '    <link rel="stylesheet" href="/TAMUCybersecurityDatabase/tamucc/includes/styles.css">';

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";

// Create connection
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$internId = mysqli_real_escape_string($conn, $_POST['internId']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$isGov = mysqli_real_escape_string($conn, $_POST['isGov']);

$sql = "INSERT INTO internship (Intern_ID, Name, Description, is_Gov) VALUES ('$internId', '$name', '$description', '$isGov')";

if (mysqli_query($conn, $sql) === TRUE) {
    echo "New internship added successfully<br>";

    $newInternId = $internId ? $internId : mysqli_insert_id($conn);

    // Retrieve and sanitize intern_app data
    $iaNum = mysqli_real_escape_string($conn, $_POST['iaNum']);
    $studentUIN = mysqli_real_escape_string($conn, $_POST['studentUIN']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    // Insert data into intern_app
    $internAppSql = "INSERT INTO intern_app (IA_Num, UIN, Intern_ID, Status, Year) VALUES ('$iaNum', '$studentUIN', '$newInternId', '$status', '$year')";
    
    if (mysqli_query($conn, $internAppSql) === TRUE) {
        echo "Intern application added successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
