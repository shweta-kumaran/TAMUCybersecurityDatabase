<?php
include_once 'includes/dbh.inc.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$internId = mysqli_real_escape_string($conn, $_POST['internId']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$isGov = mysqli_real_escape_string($conn, $_POST['isGov']);

$sql = "INSERT INTO internship (Intern_ID, Name, Description, is_Gov) VALUES ('$internId', '$name', '$description', '$isGov')";

if ($conn->query($sql) === TRUE) {
    echo "New internship added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>