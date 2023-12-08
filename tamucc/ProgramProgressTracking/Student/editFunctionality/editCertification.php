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

// Function to fetch certifications
function fetchCertifications($conn) {
    $sql = "SELECT Cert_ID, Cert_Level, Cert_Name, Cert_Des FROM certification";
    $result = $conn->query($sql);
    return $result;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cert_id = $_POST['cert_id'];
    $new_level = $_POST['cert_level'];
    $new_name = $_POST['cert_name'];
    $new_des = $_POST['cert_des'];

    // SQL to update certification
    $sql = "UPDATE certification SET Cert_Level = '$new_level', Cert_Name = '$new_name', Cert_Des = '$new_des' WHERE Cert_ID = '$cert_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Certification updated successfully<br>";
    } else {
        echo "Error updating certification: " . $conn->error . "<br>";
    }
}

// Fetch certifications for display and selection
$result = fetchCertifications($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Certification</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="header">
        <h2>Select a Certification to Edit</h2>
        <a href="index.php">Home</a>
    </div>


<form action="" method="post">
    <label for="cert_id">Select Certification:</label>
    <select name="cert_id">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["Cert_ID"] . "'>" . $row["Cert_Name"] . "</option>";
            }
        } else {
            echo "<option>No certifications available</option>";
        }
        ?>
    </select>
    <br>
    <input type="text" name="cert_level" placeholder="New Certification Level"><br>
    <input type="text" name="cert_name" placeholder="New Certification Name"><br>
    <input type="text" name="cert_des" placeholder="New Description"><br>
    <input type="submit" value="Update Certification">
</form>

</body>
</html>

<?php
$conn->close();
?>
