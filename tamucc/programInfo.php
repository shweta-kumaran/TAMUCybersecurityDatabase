<?php
    include_once 'includes/dbh.inc.php';
    session_start();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connected successfully";
    }

    if ($_SESSION['role'] != 'admin' or !isset($_SESSION['role']))
    {
        header("Location: index.php");
        die();
    }

    function programExists($newName, $conn) {
        // an index exists prog_name_idx
        $stmt = $conn->prepare("SELECT * FROM programs WHERE Prog_Name = ?");
        $stmt->bind_param("s", $newName);  
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
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
    <h1>Add a New Program</h1>
    <form method="post" action="programInfo.php">
        <input type="hidden" name="form_id" value="insert">
    
        <label for="Name">Name:</label>
        <input type="text" name="Name" id="Name" required><br>

        <label for="Description">Description:</label>
        <textarea id="Description" name="Description" rows="8" cols="80"></textarea><br>
        
        <label for="activate">Activate to Students:</label>
        <select name="activate" id="activate">
            <option value=1>Yes</option>
            <option value=0>No</option>
        </select><br>
        <input type="submit" value="Insert Program">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formId = $_POST['form_id'];
        if($formId == "insert"){
            $newName = $_POST['Name'];
            $newDescription = $_POST['Description'];
            $newActivation = $_POST['activate'];

            if(!programExists($newName, $conn) && $_SESSION['role'] == 'admin'){

                $baseSql = "INSERT INTO `programs` (`Prog_Name`, `Prog_Des`, `Prog_Access`) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($baseSql);
                $stmt->bind_param("ssi", $newName, $newDescription, $newActivation);
                if ($stmt->execute() === TRUE) {
                    echo "Inserted a new program: $newName";
                } else {
                    echo "Error adding program: " . $conn->error;
                }
                $stmt->close();
            }else{
                echo "$newName already present in the database.";
            }
        }
    }
    ?>

    <h1>Update a Program</h1>

    <form method="post" action="">
        <input type="hidden" name="form_id" value="update">
        <label for='nameToChange'>Program Name to Change:</label>
        <input type='text' name='nameToChange' id='nameToChange' value='' required><br>
        <label for="columnToChange">Attribute to Change:</label>
        <select name="columnToChange" id="columnToChange">
            <option value="Prog_Name">Program Name</option>
            <option value="Prog_Des">Program Description</option>
            <option value="Prog_Access">Program Access</option>
        </select><br>

        <label for="newValue">New Value:</label>
        <textarea id="newValue" name="newValue" rows="8" cols="80"></textarea><br>
        <text>Note: For program access enter 1 for yes, enter 0 for no.</text><br>

        <input type="submit" value="Update Program">
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $formId = $_POST['form_id'];

            if($formId == "update"){
                $nameToChange = $_POST['nameToChange'];
                $attributeToChange = $_POST['columnToChange'];
                $newValue = $_POST['newValue'];

                if(programExists($nameToChange, $conn)){
                    $sql = "UPDATE programs SET $attributeToChange = ? WHERE Prog_Name = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $newValue, $nameToChange);
                    if ($stmt->execute() === TRUE) {
                        echo "$attributeToChange updated successfully to $newValue for $nameToChange";
                    } else {
                        echo "Error updating $attributeToChange: " . $conn->error;
                    }

                }else{
                    echo "Program with that name not found.";
                }
                $stmt->close();
            }
        }
    ?>

    <h1>Program Report</h1>
    <form method="post" action="">
        <input type="hidden" name="form_id" value="select">
        <label for="role">Select All Programs or a Program Num :</label>
        <select name = "select_program_Num" id = "select_program_Num">
            <option value = "all"> All Programs </option>
            <option value = "all"> Active Programs </option>
            <?php
                $query = "SELECT * FROM programs";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Program_Num"] . "'>" . $row["Program_Num"] . "</option>";
                    }
                } 
            ?>
        </select>
        <input type="submit" value="Generate Program Report">
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "select"){
                $selectedID = $_POST['select_program_Num'];
                if ( $selectedID == "all" ) {
                    $sqlSelect = "SELECT * FROM programs";
                } else {
                    $sqlSelect = "SELECT * FROM programs WHERE Program_Num = '$selectedID'";
                }
                $result = $conn->query($sqlSelect);
            
                if ($result->num_rows > 0) {
                    // Output data of each event
                    while ($row = $result->fetch_assoc()) {
                        echo "Program ID: " . $row["Program_Num"] ." - Program Name: " . $row["Prog_Name"] ." - Program Description: " . $row["Prog_Des"] ;
                        echo "<br>";
                    }
                } else {
                    echo "Error Generating Program Report.";
                }
            }
        }
    ?>

    <h1>Deactivate a Program</h1>

    <form method='post' action=''>
        <label for="role">Select a Program Num:</label>
        <input type='hidden' name='form_id' value='deactivate'>
        <select name = "select_program_Num" id = "select_program_Num">
            <?php
                $query = "SELECT * FROM programs";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Program_Num"] . "'>" . $row["Program_Num"] . "</option>";
                    }
                }
            ?>
        </select>
        <input type ='submit' value='Deactivate'> 
    </form>

<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formId = $_POST['form_id'];
        if($formId == 'deactivate'){
            $programToChange = $_POST['select_program_Num'];
            if(programNumExists($programToChange, $conn)){
                $sql = "UPDATE programs SET Prog_Access = 0 WHERE Program_Num = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $programToChange);
                if ($stmt->execute() === TRUE) {
                    echo "$programToChange deactivated.";
                } else {
                    echo "Error deactivating program." . $stmt->error;
                }   
            }
            else
            {
                echo "Error deactivating program.";
            }
        }
    }
?>

<h1>Delete a Program</h1>

<form method='post' action=''>
    <label for="role">Select a Program Num:</label>
    <input type='hidden' name='form_id' value='delete'>
    <select name = "select_program_Num" id = "select_program_Num">
        <?php
            $query = "SELECT * FROM programs";
            $result = $conn->query($query);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["Program_Num"] . "'>" . $row["Program_Num"] . "</option>";
                }
            }
        ?>
    </select>
    <input type ='submit' value='Delete'> 
</form>

<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $formId = $_POST['form_id'];
    if($formId == 'delete'){
        $programToChange = $_POST['select_program_Num'];
        if(programNumExists($programToChange, $conn)){
            $stmt = $conn->prepare("DELETE FROM `event` WHERE Program_Num = ?");
            $stmt->bind_param("i", $programToChange);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM track WHERE Program_Num = ?");
            $stmt->bind_param("i", $programToChange);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM `application` WHERE Program_Num = ?");
            $stmt->bind_param("i", $programToChange);
            $stmt->execute();
            $stmt->close();

            $sql = "DELETE FROM programs WHERE Program_Num = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $programToChange);
            if ($stmt->execute() === TRUE) {
                echo "$programToChange deleted.";
            } else {
                echo "Error deleting program." . $stmt->error;
            }
            $stmt->close();
        }
        else
        {
            echo "Error deleting program.";
        }
    }
}
?>
</body>
</html>