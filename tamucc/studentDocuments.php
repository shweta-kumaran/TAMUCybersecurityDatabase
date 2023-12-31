<?php
    include_once 'includes/dbh.inc.php';
    session_start();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    if (!isset($_SESSION['role']))
    {
        header("Location: index.php");
        die();
    }

    function docExists($givenDoc, $conn) {
        // Prepare and bind the statement with the given parameter
        $stmt = $conn->prepare("SELECT Doc_Num FROM documentation WHERE Doc_Num = ?");
        $stmt->bind_param("i", $givenDoc); // Doc_Num integer
        
        // Execute the statement and store the results
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
    <link rel="stylesheet" href="includes/styles.css">
    <title>Document Management</title>
</head>
<body>

    <div class="header">
        <h1>Document Management</h1>
        <a href="/TAMUCybersecurityDatabase/tamucc/index.php">Home</a>
    </div>
    
    <?php //echo "<h3 class='welcome'>Welcome " . $_SESSION['user_id'] . " (" . $_SESSION['UIN'] .  ")! You are logged in as a " . $_SESSION['role'] . "</h3>";?>
    <!-- Selection form -->
    <h2>Select and View Document Links</h2>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="select">

        <label for = "select_doc_num">Select all events or an event ID:</label>
        <select name = "select_doc_num" id = "select_doc_num" required>
            <option value = "all"> All Documents </option>

            <?php               
                $currUIN = $_SESSION['UIN'];
                $sqlInsert = "SELECT * FROM `documentation` WHERE App_Num IN (SELECT App_Num FROM application WHERE UIN = '$currUIN')";
                $result = $conn->query($sqlInsert);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Doc_Num"] . "'>" . $row["Doc_Num"] . "</option>";
                    }
                } 
            ?>
        </select>
        <input type="submit" value="Select Document(s)">
    </form>

            

    <!-- Selection php -->
    <?php
        $currUIN = $_SESSION['UIN'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "select"){
                // Get the selected ID from the form
                $selectedID = $_POST['select_doc_num'];
                // Query to fetch users based on the selected Event ID
                if ( $selectedID == "all" ) {
                    // $sqlSelect = "SELECT * FROM documentation WHERE App_Num IN (SELECT App_Num FROM application WHERE UIN = '$currUIN') ORDER BY Doc_Num, App_Num";
                    $sqlSelect = "SELECT * FROM documents_with_users WHERE UIN = '$currUIN' ORDER BY Doc_Num, App_Num";

                } else {
                    $sqlSelect = "SELECT * FROM documentation WHERE Doc_Num = '$selectedID'";
                }
                $result = $conn->query($sqlSelect);
            
                if ($result->num_rows > 0) {
                    // Output data of each event
                    echo "<p class = 'result'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "Document Number: " . $row["Doc_Num"] . " - Application Number: " . $row["App_Num"] . " - Document Type: " . $row["Doc_Type"] . " - Document Link: " . $row["Link"];
                        echo "<br>";
                    }
                    echo "</p>";
                } else {
                    echo "No documents found for the selected document number.";
                }
            }
        }
    ?>

    <!-- Insertion form -->
    <h2>Upload a Document Link</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="insert">

        <label for="App_Num">Application Number:</label>
        <!-- <input type="int" name="App_Num" id="App_Num" value="" required><br> -->
        <select name = "App_Num" id = "App_Num" required>
            <option value="none" selected disabled hidden>Select an Application Number</option>
            <?php
                // $query = "SELECT * FROM documentation WHERE App_Num IN (SELECT App_Num FROM application WHERE UIN = '$currUIN') ORDER BY Doc_Num, App_Num";
                $query = "SELECT * FROM application WHERE UIN = '$currUIN'";
                
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["App_Num"] . "'>" . $row["App_Num"] . "</option>";
                    }
                } 
            ?>
        </select><br>
    
        <label for="Link">Link:</label>
        <input type="text" name="Link" id="Link" value="" required><br>

        <label for="Doc_Type">Document Type:</label>
        <input type="text" name="Doc_Type" id="Doc_Type" value="" required><br><br>

        <input type="submit" value="Insert Document">
    </form>

    <!-- Insertion php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "insert"){
                // save the new inputs as variables
                $newAppNum= $_POST['App_Num'];
                $newLink = $_POST['Link'];
                $newDocType = $_POST['Doc_Type'];

                $sqlInsert = "INSERT INTO documentation (App_Num, Link, Doc_Type) VALUES ($newAppNum, '$newLink', '$newDocType')";
                
                if ($conn->query($sqlInsert) === TRUE) {
                    echo "<p class='response'>Inserted document successfully!</p>";
                } else {
                    echo "<p class='response'>Error adding document: " . $conn->error."</p>";
                }
            }
        }
    ?>

    <!-- Deletion form -->
    <h2>Delete a document</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="delete">

        <label for = "delete_Doc_Num">Select the document to delete:</label>
        <select name = "delete_Doc_Num" id = "delete_Doc_Num" required>
            <option value="none" selected disabled hidden>Select a Document</option>
            <?php
                // $query = "SELECT * FROM documentation WHERE App_Num IN (SELECT App_Num FROM application WHERE UIN = '$currUIN') ORDER BY Doc_Num, App_Num";
                $query = "SELECT * FROM documents_with_users WHERE UIN = '$currUIN' ORDER BY Doc_Num, App_Num";
                
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Doc_Num"] . "'>" . $row["Doc_Num"] . "</option>";
                    }
                } 
            ?>
        </select>

        <input type="submit" value="Delete Document">
    </form>

    <!-- Deletion php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "delete") {
                // Get the selected doc num from the form
                $selectedNum = $_POST['delete_Doc_Num'];
                if($selectedNum == "none") {
                    echo " ";
                } else {

                    if(docExists($selectedNum, $conn)){
                        $sql = "DELETE FROM documentation WHERE Doc_Num = '$selectedNum'";
                        if ($conn->query($sql) === TRUE) {
                            echo "<p class='response'>Document with Document Number $selectedNum deleted successfully!</p>";
                        } else {
                            echo "<p class='response'>Error deleting document: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p class='response'>Document doesn't exist.</p>";
                    }
                }
            }
        }
    ?>


    <!-- Update form -->
    <h2>Replace or Edit a Document Link</h2> 
    <p> Select the document and attribute you wish to edit and click submit to show the new value text box.</p>
    <!-- use form to get the attribute and document to update -->
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="update">

        <label for = "update_Doc_Num">Select the Document to Update:</label>
        <select name = "update_Doc_Num" id = "update_Doc_Num" required>
            <option value="none" selected disabled hidden>Select a Document</option>
            <?php
                // $query = "SELECT * FROM documentation WHERE App_Num IN (SELECT App_Num FROM application WHERE UIN = '$currUIN') ORDER BY Doc_Num, App_Num";
                $query = "SELECT * FROM documents_with_users WHERE UIN = '$currUIN' ORDER BY Doc_Num, App_Num";

                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Doc_Num"] . "'>" . $row["Doc_Num"] . "</option>";
                    }
                } 
            ?>
        </select><br>
        
        <label for="columnToChange">Document Attribute to Change:</label>
        <select name="columnToChange" id="columnToChange" required>
            <option value="none" selected disabled hidden>Select an Attribute</option>
            <option value="App_Num">Application Number</option>
            <option value="Link">Link</option>
            <option value="Doc_Type">Document Type</option>
        </select><br>
        <input type="submit" value="Submit to Input New Value">
    </form>
    
    
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="updateNewValue">
        <label for="newValue">New Value:</label>
        
        <!-- pre-populate the text input with current value -->
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $formID = $_POST['form_id'];
                if($formID == "update"){
                    // Get the num and column  the form
                    $updateNum = $_POST['update_Doc_Num'];
                    $updateColumn = $_POST['columnToChange'];
                    
                    $_SESSION['doc_update_num'] = $updateNum; 
                    $_SESSION['doc_update_col'] = $updateColumn; 
                    
                    // prepare the query to get info from database to pre-populate the text box
                    $query = "SELECT * FROM `documentation` WHERE Doc_Num = $updateNum";
                    $result = $conn->query($query);

                    if($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<input type='text' name='newValue' id='newValue' value='" . $row[$updateColumn] ."' required> <br><br>";
                    } else {
                        echo "<input type='text' name='newValue' id='newValue' value='' required> <br><br>";
                    }    
                }
            }
        ?>

        <input type="submit" value="Update Document">
    </form>

    <!-- Update php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "updateNewValue"){
                // Get the new value from the form
                $newValue = $_POST['newValue'];
                
                $updateNum = $_SESSION['doc_update_num'];
                $updateColumn = $_SESSION['doc_update_col'];

                if(docExists($updateNum, $conn)) {
                    $sqlUpdate = "UPDATE documentation SET $updateColumn = '$newValue' WHERE Doc_Num = $updateNum";
                    if ($conn->query($sqlUpdate) === TRUE) {
                        echo "<p class='response'>$updateColumn updated successfully to $newValue for the document with the Document Number $updateNum</p>";
                    } else {
                        echo "<p class='response'>Error updating $updateColumn: " . $conn->error . "</p>";
                    }   
                } else {
                    echo "<p class='response'>Document with that Document Number not found.</p>";
                }
            }
        }
    ?>
    

</body>
</html>