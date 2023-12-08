<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";

// Function to create a database connection
function createConnection() {
    global $dbServername, $dbUsername, $dbPassword, $dbName;
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Handle deletion if the delete parameter is set
if (isset($_GET['delete']) && isset($_GET['id']) && isset($_GET['type'])) {
    $conn = createConnection();
    $id = $_GET['id'];
    $type = $_GET['type'];
    $idColumn = $type === 'classes' ? 'Class_ID' : ($type === 'internship' ? 'Intern_ID' : 'Cert_ID');

    $stmt = $conn->prepare("DELETE FROM " . $type . " WHERE " . $idColumn . " = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<p>Record deleted successfully.</p>";
    } else {
        echo "<p>Error deleting record: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}

// Show form and list records if the form is submitted
if (isset($_POST['submit'])) {
    $conn = createConnection();
    $recordType = $_POST['recordType'];
    $sql = "SELECT * FROM " . $recordType;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            // Determine the display column based on the record type
            switch ($recordType) {
                case 'classes':
                    $displayColumn = 'Class_Name'; // Adjust to your actual column name
                    break;
                case 'internship':
                    $displayColumn = 'Name'; // Adjust to your actual column name
                    break;
                case 'certification':
                    $displayColumn = 'Cert_Name'; // Adjust to your actual column name
                    break;
                default:
                    $displayColumn = 'Name'; // A default column name
            }
            $idColumn = $recordType === 'classes' ? 'Class_ID' : ($recordType === 'internship' ? 'Intern_ID' : 'Cert_ID');
            echo "<li>" . $row[$displayColumn] . " - <a href='?delete&id=" . $row[$idColumn] . "&type=" . $recordType . "'>Delete</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No records found.</p>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Progress Records</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="header">
        <h1>Delete Progress Records</h1>
        <a href="/TAMUCybersecurityDatabase/tamucc/index.php">Home</a>
    </div>
    <form action="" method="post">
        <select name="recordType">
            <option value="classes">Class</option>
            <option value="internship">Internship</option>
            <option value="certification">Certification</option>
        </select>
        <input type="submit" name="submit" value="Choose">
    </form>
</body>
</html>
