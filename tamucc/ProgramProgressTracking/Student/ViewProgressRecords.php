<?php
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

// Function to check if an index exists
function indexExists($conn, $table, $indexName) {
    $sql = "SHOW INDEX FROM " . $table . " WHERE Key_name = '" . $indexName . "'";
    $result = $conn->query($sql);
    return ($result && $result->num_rows > 0);
}


function createIndexes($conn) {
    $tables = ["internship", "certification", "classes"];
    if (False)
    {
        foreach ($tables as $table) {
            $indexName = "idx_" . $table . "_ID";
            $columnToIndex = $table . "_ID"; // Correct column name
            
            if (!indexExists($conn, $table, $indexName)) {
                $sql = "CREATE INDEX " . $indexName . " ON " . $table . " (" . $columnToIndex . ")";
                $conn->query($sql);
            }
        }
    }
    
}


// Call the createIndexes function to create indexes if needed
createIndexes($conn);

function fetchAll($conn, $table) {
    $sql = "SELECT * FROM " . $table;
    return $conn->query($sql);
}

$internships = fetchAll($conn, "internship");
$certifications = fetchAll($conn, "certification");
$classes = fetchAll($conn, "classes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Program Progress Tracking</title>
    <link rel="stylesheet" href="/TAMUCybersecurityDatabase/tamucc/includes/styles.css">
</head>
<body>
    <div class="header">
        <h1>Program Progress Tracking</h1>
        <a href="/TAMUCybersecurityDatabase/tamucc/index.php">Home</a>
    </div>

    <h2>Internships</h2>
    <ul>
    <?php while($row = $internships->fetch_assoc()): ?>
        <li><a href="SelectFunctionality/detail.php?type=internship&id=<?= $row['Intern_ID'] ?>"><?= $row['Name'] ?></a></li>
    <?php endwhile; ?>
    </ul>

    <h2>Certifications</h2>
    <ul>
    <?php while($row = $certifications->fetch_assoc()): ?>
        <li><a href="SelectFunctionality/detail.php?type=certification&id=<?= $row['Cert_ID'] ?>"><?= $row['Cert_Name'] ?></a></li>
    <?php endwhile; ?>
    </ul>

    <h2>Classes</h2>
    <ul>
    <?php while($row = $classes->fetch_assoc()): ?>
        <li><a href="SelectFunctionality/detail.php?type=classes&id=<?= $row['Class_ID'] ?>"><?= $row['Class_Name'] ?></a></li>
    <?php endwhile; ?>
    </ul>
</body>
</html>

<?php
$conn->close();
?>
