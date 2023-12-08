<?php
    include_once 'includes/dbh.inc.php';
    session_start();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connected successfully";
    }

    if ($_SESSION['role'] == 'admin' or !isset($_SESSION['role']))
    {
        header("Location: index.php");
        die();
    }

    function programNumExists($newNum, $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM programs WHERE Program_Num = ?");
        $stmt->bind_param("i", $newNum);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Submit an Application</h1>
    <form method="post" action="">
        <input type="hidden" name="form_id" value="insert">
    
        <label for="prog">Program you wish to apply to:</label>
        <select name = "programName" id = "programName">
        <?php
            $query = "SELECT * FROM programs";
            $result = $conn->query($query);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["Program_Num"] . "'>" . $row["Prog_Name"] . "</option>";
                }
            }
        ?>
        </select><Br>

        <label for="">Uncom_Cert: Are you currently enrolled in other uncompleted certifications sponsored by the Cybersecurity Center? (If so, provide details)</label><br>
        <textarea id="Uncom_Cert" name="Uncom_Cert" rows="8" cols="80"></textarea><br>

        <label for="">Com_Cert: Have you completed any cybersecurity industry certifications via the Cybersecurity Center? (If so, provide details)</label><Br>
        <textarea id="Com_Cert" name="Com_Cert" rows="8" cols="80"></textarea><br>
        
        <label for="">Purpose Statement:</label><br>
        <textarea id="purpose" name="purpose" rows="8" cols="80"></textarea><br>
        <input type="submit" value="Submit Application">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formId = $_POST['form_id'];
        if($formId == "insert"){
            $program = $_POST['programName'];
            $uncom = $_POST['Uncom_Cert'];
            $com = $_POST['Com_Cert'];
            $ps = $_POST['purpose'];
            $uin = $_SESSION['UIN'];

            if(programNumExists($program, $conn)){
                $baseSql = "INSERT INTO `application` (`Program_Num`, `UIN`, `Uncom_Cert`, `Com_Cert`, `Purpose_Statement`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($baseSql);
                $stmt->bind_param("iisss", $program, $uin, $uncom, $com, $ps);
                if ($stmt->execute() === TRUE) {
                    echo "Submitted an Application for Program: $program";
                } else {
                    echo "Error submitting application: " . $conn->error;
                }
                $stmt->close();
            }
        }
    }
    ?>



<h1>Update a Program</h1>

<form method="post" action="">
    <input type="hidden" name="form_id" value="update">
    <label for='applicationToChange'>Application Number to Change:</label>
    <select name = "applicationid" id = "applicationid">
        <?php
            $query = "SELECT * FROM `application` WHERE UIN = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_SESSION['UIN']);
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["App_Num"] . "'>" . $row["App_Num"] . "</option>";
            }
            $stmt->close();
        ?>
        </select><Br>
   
    <label for="columnToChange">Attribute to Change:</label>
    <select name="columnToChange" id="columnToChange">
        <option value="Program_Num">Program Num</option>
        <option value="Uncom_Cert">Uncom_Cert</option>
        <option value="Com_Cert">Com_Cert</option>
        <option value="Purpose_Statement">Purpose Statement</option>
    </select><br>

    <label for="newValue">Attribute Updated Value:</label><br>
    <textarea id="newValue" name="newValue" rows="8" cols="80"></textarea><br>

    <input type="submit" value="Update Application">
</form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $formId = $_POST['form_id'];

            if($formId == "update"){
                $applicationToChange = $_POST['applicationid'];
                $attributeToChange = $_POST['columnToChange'];
                $newValue = $_POST['newValue'];
                $sql = "UPDATE `application` SET $attributeToChange = ? WHERE App_Num = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $newValue, $applicationToChange);
                if ($stmt->execute() === TRUE) {
                    echo "$attributeToChange updated successfully to $newValue for Application $applicationToChange";
                } else {
                    echo "Error updating $attributeToChange: " . $conn->error;
                }
                $stmt->close();
            }
        }
    ?>

<h1>Review Application Information and Status</h1>
    <form method="post" action="">
        <input type="hidden" name="form_id" value="select">
        <label for="role">Select All Applications or a Application Num :</label>
        <select name = "select_appNum" id = "select_appNum">
            <option value = "all"> All applications submitted </option>
            <?php
                $query = "SELECT * FROM `application` WHERE UIN = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION['UIN']);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["App_Num"] . "'>" . $row["App_Num"] . "</option>";
                }
                $stmt->close();
            ?>
        </select>
        <input type="submit" value="Generate Application Report">
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "select"){
                $selectedID = $_POST['select_appNum'];
                if ( $selectedID == "all" ) {
                    $stmt = "SELECT * FROM `application` WHERE UIN = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $_SESSION['UIN']);
                } else {
                    $stmt = "SELECT * FROM `application` WHERE App_Num = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $selectedID);
                }
                $stmt->execute();
                $result = $stmt->get_result();
            
                while ($row = $result->fetch_assoc()) {
                    echo "Application Num: " . $row["App_Num"] ." - Program Num: " . $row["Program_Num"] ." - Uncompleted Certification Description: " . $row["Uncom_Cert"] . " - Completed Certification Description: " . $row["Uncom_Cert"]. " - Purpose Statement: " . $row["Purpose_Statement"];
                    echo "<br>";
                }

                if ($result == null)
                    echo "Error Generating Program Report.";
                }
            }
    ?>

</body>
</html>