<?php
include_once 'includes/dbh.inc.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$certId = mysqli_real_escape_string($conn, $_POST['certId']);
$level = mysqli_real_escape_string($conn, $_POST['level']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$sql = "INSERT INTO certification (Cert_ID, Cert_Level, Cert_Name, Cert_Des) VALUES ('$certId', '$level', '$name', '$description')";

if ($conn->query($sql) === TRUE) {
    echo "New certification added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

