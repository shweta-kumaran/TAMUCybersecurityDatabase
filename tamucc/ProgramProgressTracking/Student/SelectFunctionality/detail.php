<?php
if (isset($_GET['type']) && isset($_GET['id'])) {
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "tamuccdb";

    // Create connection
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $type = $_GET['type'];
    $id = $_GET['id'];

    // Determine the correct ID column name based on the type
    switch ($type) {
        case 'internship':
            $idColumn = 'intern_id';
            break;
        case 'certification':
            $idColumn = 'cert_id'; // Replace with your actual certification ID column name
            break;
        case 'classes':
            $idColumn = 'Class_ID'; // Replace with your actual class ID column name
            break;
        default:
            $idColumn = 'id'; // Default ID column name if type is unknown
    }

    $sql = "SELECT * FROM " . $type . " WHERE " . $idColumn . " = '" . $id . "'";

    $result = $conn->query($sql);
    $item = $result->fetch_assoc();

} else {
    header("Location: studentAccess.html");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Page</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="header">
        <h1>Details</h1>
        <a href="/TAMUCybersecurityDatabase/tamucc/index.php">Home</a>
    </div>
    <?php if ($item): ?>
        <?php foreach($item as $key => $value): ?>
            <p><strong><?= $key ?>:</strong> <?= $value ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No details found.</p>
    <?php endif; ?>
</body>
</html>

<?php
$conn->close();
?>
