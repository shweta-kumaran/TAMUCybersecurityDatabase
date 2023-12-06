<?php
    include_once 'includes/dbh.inc.php';
    session_start();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connected successfully";
    }

    if (!isset($_SESSION['role']))
    {
        header("Location: index.php");
        die();
    }

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management</title>
</head>
<body>

    <h1>Document Management</h1>
    <a href="index.php">Home</a>

    <!-- Selection form -->
    <h2>Select and View Document Links</h2>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="select">

        <!-- <label for = "select_event_ID">Select all events or an event ID:</label>
        <select name = "select_event_ID" id = "select_event_ID">
            <option value = "all"> All events </option>

            <?php
                $query = "SELECT * FROM event";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Event_ID"] . "'>" . $row["Event_ID"] . "</option>";
                    }
                } 
            ?>
        </select> -->
        <input type="submit" value="Select Events Form">
    </form>

            

    <!-- Selection php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "select"){
                // // Get the selected role from the form
                // $selectedID = $_POST['select_event_ID'];
                // // Query to fetch users based on the selected Event ID
                // if ( $selectedID == "all" ) {
                //     $sqlSelect = "SELECT * FROM event";
                // } else {
                //     $sqlSelect = "SELECT * FROM event WHERE Event_ID = '$selectedID'";
                // }
                // $result = $conn->query($sqlSelect);
            
                // if ($result->num_rows > 0) {
                //     // Output data of each event
                //     while ($row = $result->fetch_assoc()) {
                //         echo "Event ID: " . $row["Event_ID"] . " - Program Number: " . $row["Program_Num"] . " - Event Type: " . $row["Event_Type"] . " - Start Date: " . $row["Start_Date"] . " - End Date: " . $row["End_Date"];
                //         echo "<br>";
                //     }
                // } else {
                //     echo "No Events found for the selected Event ID.";
                // }
            }
        }
    ?>

    <!-- Insertion form -->
    <h2>Upload a Document Link</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="insert">

        <!-- <label for="UIN">UIN:</label>
        <input type="text" name="UIN" id="UIN" value="" required><br>
    
        <label for="Program_Num">Program Number:</label>
        <input type="int" name="Program_Num" id="Program_Num" value="" required><br>

        <label for="Start_Date">Start Date:</label>
        <input type="date" name="Start_Date" id="Start_Date" value="" required><br>
        
        <label for="Time">Time:</label>
        <input type="time" name="Time" id="Time" value="" required><br>

        <label for="Location">Location:</label>
        <input type="text" name="Location" id="Location" value="" required><br>

        <label for="End_Date">End Date:</label>
        <input type="date" name="End_Date" id="End_Date" value="" required><br>

        <label for="">Event Type:</label>
        <input type="text" name="Event_Type" id="Event_Type" value="" required><br><br> -->


        <input type="submit" value="Insert Events Form">
    </form>

    <!-- Insertion php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "insert"){
                // // save the new inputs as variables
                // $newUIN = $_POST['UIN'];
                // $newProgNum = $_POST['Program_Num'];
                // $newStartDate = $_POST['Start_Date'];
                // $newTime = $_POST['Time'];
                // $newLocation = $_POST['Location'];
                // $newEndDate = $_POST['End_Date'];
                // $newEventType = $_POST['Event_Type'];

                // $sqlInsert = 
                //     "INSERT INTO event 
                //         (UIN, Program_Num, Start_Date, Time, Location, End_Date, Event_Type)
                //     VALUES 
                //         ($newUIN, $newProgNum, '$newStartDate', '$newTime', '$newLocation', '$newEndDate', '$newEventType')";
                
                // if ($conn->query($sqlInsert) === TRUE) {
                //     echo "Inserted event successfully!";
                // } else {
                //     echo "Error adding event: " . $conn->error;
                // }
            }
        }
    ?>

    <!-- Deletion form -->
    <h2>Delete a document</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="delete">

        <!-- <label for = "delete_event_ID">Select the event by EventID to delete:</label>
        <select name = "delete_event_ID" id = "delete_event_ID">
            <?php
                $query = "SELECT * FROM event";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Event_ID"] . "'>" . $row["Event_ID"] . "</option>";
                    }
                } 
            ?>
        </select> -->

        <input type="submit" value="Insert delete Form">
    </form>

    <!-- Deletion php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "delete"){
                // // Get the selected role from the form
                // $selectedID = $_POST['delete_event_ID'];
                // if(eventExists($selectedID, $conn)){
                //     $sql = "DELETE FROM `event` WHERE Event_ID = '$selectedID'";
                //     if ($conn->query($sql) === TRUE) {
                //         echo "Event with Event ID $selectedID deleted successfully!";
                //     } else {
                //         echo "Error deleting event: " . $conn->error;
                //     }
                // } else {
                //     echo "Event doesn't exist.";
                // }
            }
        }
    ?>


    <!-- Update form -->
    <h2>Replace or Edit a Document Link</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="update">

        <!-- <label for = "update_event_ID">Select the event ID for the event you wish to update:</label>
        <select name = "update_event_ID" id = "update_event_ID">
            <?php
                $query = "SELECT * FROM event";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Event_ID"] . "'>" . $row["Event_ID"] . "</option>";
                    }
                } 
            ?>
        </select><br>
        
        <label for="columnToChange">Event Attribute to Change:</label>
        <select name="columnToChange" id="columnToChange">
            <option value="UIN">UIN</option>
            <option value="Program_Num">Program Number</option>
            <option value="Start_Date">Start Date</option>
            <option value="Time">Time</option>
            <option value="Location">Location</option>
            <option value="End_Date">End Date</option>
            <option value="Event_Type">Event Type</option>
        </select><br>

        <label for="newValue">New Value:</label>
        <input type="text" name="newValue" id="newValue" value="" required><br><br> -->

        <input type="submit" value="Insert update Form">
    </form>

    <!-- Update php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "update"){
                // // Get the selected role from the form FIXME
                // $updateID = $_POST['update_event_ID'];
                // $updateColumn = $_POST['columnToChange'];
                // $newValue = $_POST['newValue'];

                // if(eventExists($updateID, $conn)) {
                //     $sqlUpdate = "UPDATE event SET $updateColumn = '$newValue' WHERE Event_ID = $updateID";
                // } else {
                //     echo "Event with that ID not found.";
                // }

                // if ($conn->query($sqlUpdate) === TRUE) {
                //     echo "$updateColumn updated successfully to $newValue for the event with Event ID $updateID!";
                // } else {
                //     echo "Error updating $updateColumn: " . $conn->error;
                // }   
            }
        }
    ?>
    

</body>
</html>