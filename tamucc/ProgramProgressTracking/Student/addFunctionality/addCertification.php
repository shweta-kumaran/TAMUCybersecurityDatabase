<?php
echo '    <link rel="stylesheet" href="/TAMUCybersecurityDatabase/tamucc/includes/styles.css">';

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$certId = mysqli_real_escape_string($conn, $_POST['certId']);
$level = mysqli_real_escape_string($conn, $_POST['level']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$sql = "INSERT INTO certification (Cert_ID, Cert_Level, Cert_Name, Cert_Des) VALUES ('$certId', '$level', '$name', '$description')";

if (mysqli_query($conn, $sql) === TRUE) {
    echo "New certification added successfully<br>";

    // Assuming CertE_Num is auto-increment, no need to include it in the insert statement
    $studentUIN = mysqli_real_escape_string($conn, $_POST['studentUIN']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $trainingStat = mysqli_real_escape_string($conn, $_POST['trainingStat']);
    $programNum = mysqli_real_escape_string($conn, $_POST['programNum']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $certYear = mysqli_real_escape_string($conn, $_POST['certYear']);

    $enrollmentSql = "INSERT INTO cert_enrollment (UIN, Cert_ID, Stat, Training_Stat, Program_Num, Semester, Cert_Year) VALUES ('$studentUIN', '$certId', '$status', '$trainingStat', '$programNum', '$semester', '$certYear')";

    if (mysqli_query($conn, $enrollmentSql) === TRUE) {
        echo "Certification enrollment added successfully";
    } else {
        echo "Error in certification enrollment: " . mysqli_error($conn);
    }

} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
