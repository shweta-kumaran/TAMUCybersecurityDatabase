<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";
$reportId = $_GET['id'] ?? null;

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($reportId) {
    $stmt = $conn->prepare("DELETE FROM reports WHERE report_id = ?");
    $stmt->bind_param("i", $reportId);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

header("Location: AdminReportIndex.php");
exit;
?>
