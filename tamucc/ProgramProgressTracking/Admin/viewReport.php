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
    $stmt = $conn->prepare("SELECT * FROM reports WHERE report_id = ?");
    $stmt->bind_param("i", $reportId);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();

    echo "<h1>" . htmlspecialchars($report['report_name']) . "</h1>";
    echo "<p>" . htmlspecialchars($report['report_content']) . "</p>";

    $stmt->close();
}

$conn->close();
?>
