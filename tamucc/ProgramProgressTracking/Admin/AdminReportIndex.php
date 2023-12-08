<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch existing reports
$result = $conn->query("SELECT * FROM reports");

echo "<h1>Generated Reports</h1>";
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><a href='viewReport.php?id=" . $row['report_id'] . "'>" . $row['report_name'] . "</a> - <a href='deleteReport.php?id=" . $row['report_id'] . "'>Delete</a></li>";
}
echo "</ul>";

// Link to generate a new report
echo "<a href='generateReport.php'>Generate New Report</a>";

$conn->close();
?>
