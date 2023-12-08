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

// Function to fetch classes
function fetchClasses($conn) {
    $sql = "SELECT Class_ID, Class_Name, Class_Desc, Class_Type FROM classes";
    $result = $conn->query($sql);
    return $result;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_id = $_POST['class_id'];
    $new_name = $_POST['class_name'];
    $new_desc = $_POST['class_desc'];
    $new_type = $_POST['class_type'];

    // SQL to update class
    $sql = "UPDATE classes SET Class_Name = '$new_name', Class_Desc = '$new_desc', Class_Type = '$new_type' WHERE Class_ID = $class_id";

    if ($conn->query($sql) === TRUE) {
        echo "Class updated successfully<br>";
    } else {
        echo "Error updating class: " . $conn->error . "<br>";
    }
}

// Fetch classes for display and selection
$result = fetchClasses($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Class</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="header">
        <h2>Select a Class to Edit</h2>
        <a href="/TAMUCybersecurityDatabase/tamucc/index.php">Home</a>
    </div>

<form action="" method="post">
    <label for="class_id">Select Class:</label>
    <select name="class_id">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["Class_ID"] . "'>" . $row["Class_Name"] . "</option>";
            }
        } else {
            echo "<option>No classes available</option>";
        }
        ?>
    </select>
    <br>
    <input type="text" name="class_name" placeholder="New Class Name"><br>
    <input type="text" name="class_desc" placeholder="New Class Description"><br>
    <input type="text" name="class_type" placeholder="New Class Type"><br>
    <input type="submit" value="Update Class">
</form>

</body>
</html>

<?php
$conn->close();
?>
