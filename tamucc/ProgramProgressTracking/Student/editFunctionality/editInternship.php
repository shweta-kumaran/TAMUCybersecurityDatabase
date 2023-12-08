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

// Function to fetch internships
function fetchInternships($conn) {
    $sql = "SELECT Intern_ID, Name, Description, is_Gov FROM internship";
    $result = $conn->query($sql);
    return $result;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $intern_id = $_POST['intern_id'];
    $new_name = $_POST['intern_name'];
    $new_description = $_POST['intern_description'];
    $new_isGov = $_POST['intern_isGov'];

    // SQL to update internship
    $sql = "UPDATE internship SET Name = '$new_name', Description = '$new_description', is_Gov = '$new_isGov' WHERE Intern_ID = '$intern_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Internship updated successfully<br>";
    } else {
        echo "Error updating internship: " . $conn->error . "<br>";
    }
}

// Fetch internships for display and selection
$result = fetchInternships($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Internship</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="header">
        <h2>Select an Internship to Edit</h2>
        <a href="index.php">Home</a>
    </div>

<form action="" method="post">
    <label for="intern_id">Select Internship:</label>
    <select name="intern_id">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["Intern_ID"] . "'>" . $row["Name"] . "</option>";
            }
        } else {
            echo "<option>No internships available</option>";
        }
        ?>
    </select>
    <br>
    <input type="text" name="intern_name" placeholder="New Internship Name"><br>
    <input type="text" name="intern_description" placeholder="New Description"><br>
    <input type="text" name="intern_isGov" placeholder="Is Government (0 or 1)"><br>
    <input type="submit" value="Update Internship">
</form>

</body>
</html>

<?php
$conn->close();
?>
