<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "tamuccdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$classId = mysqli_real_escape_string($conn, $_POST['classId']);
$className = mysqli_real_escape_string($conn, $_POST['className']);
$classDesc = mysqli_real_escape_string($conn, $_POST['classDesc']);
$classType = mysqli_real_escape_string($conn, $_POST['classType']);

$sql = "INSERT INTO classes (Class_ID, Class_Name, Class_Desc, Class_Type) VALUES ('$classId', '$className', '$classDesc', '$classType')";

if ($conn->query($sql) === TRUE) {
    echo "New class added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
