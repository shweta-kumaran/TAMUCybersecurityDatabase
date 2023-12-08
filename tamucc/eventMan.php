<?php
    include_once 'includes/dbh.inc.php';
    session_start();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SESSION['role'] != 'admin' or !isset($_SESSION['role']))
    {
        header("Location: index.php");
        die();
    }

    function eventExists($givenEvent, $conn) {
        // Prepare and bind the statement with the given parameter
        $stmt = $conn->prepare("SELECT Event_ID FROM event WHERE Event_ID = ?");
        $stmt->bind_param("i", $givenEvent); // eventID integer
        
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

    function eventStudentExists($givenEventID, $givenUIN, $conn) {
        // Prepare and bind the statement with the given parameter
        $stmt = $conn->prepare("SELECT Event_ID FROM event_tracking WHERE (Event_ID = ? and UIN = ?)");
        $stmt->bind_param("ii", $givenEventID, $givenUIN); // eventID and UIN integer
        
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

    <title>Event Management</title>
</head>
<body>

    <div class="header">
        <h1>Event Management</h1>
        <a href="index.php">Home</a>
    </div>
    
    <?php //echo "<h3 class='welcome'>Welcome " . $_SESSION['user_id'] . " (" . $_SESSION['UIN'] .  ")! You are logged in as a " . $_SESSION['role'] . "</h3><br>";?>
    <!-- Selection form -->
    <h2>Select and View Events and their Attendance</h2>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="select">

        <label for = "select_event_ID">Select all events or an event ID:</label>
        <select name = "select_event_ID" id = "select_event_ID" required>
            <option value = "all"> All Events </option>

            <?php
                $query = "SELECT * FROM event";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Event_ID"] . "'>" . $row["Event_ID"] . "</option>";
                    }
                } 
            ?>
        </select>
        <input type="submit" value="Select Event(s)">
    </form>

            

    <!-- Selection php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "select"){
                // Get the selected role from the form
                $selectedID = $_POST['select_event_ID'];
                // Query to fetch users based on the selected Event ID
                if ( $selectedID == "all" ) {
                    $sqlSelect = "SELECT * FROM event";
                } else {
                    $sqlSelect = "SELECT * FROM event WHERE Event_ID = '$selectedID'";
                }
                $result = $conn->query($sqlSelect);
            
                if ($result->num_rows > 0) {
                    // Output data of each event
                    echo "<p class = 'result'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "Event ID: " . $row["Event_ID"] . " - Program Number: " . $row["Program_Num"]  . " - Admin UIN: " . $row["UIN"] . " - Event Type: " . $row["Event_Type"] . " - Start Date: " . $row["Start_Date"] . " - End Date: " . $row["End_Date"];
                        echo "<br>";
                    }
                    echo "</p>";
                } else {
                    echo "No events found for the selected Event ID.";
                }
                
                echo "<br> Attendance: <br>";

                if ( $selectedID == "all" ) {
                    $sqlSelect = "SELECT * FROM event_attendance ORDER BY Event_ID";
                } else {
                    $sqlSelect = "SELECT * FROM event_attendance WHERE Event_ID = '$selectedID' ORDER BY Event_ID";
                }
                    
                $result = $conn->query($sqlSelect);
            
                if ($result->num_rows > 0) {
                    // Output data of each event
                    echo "<p class = 'result'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "Event ID: " . $row["Event_ID"] . " - Name : " . $row["First_Name"] . " " . $row["Last_Name"] . " - UIN: " . $row["UIN"];
                        echo "<br>";
                    }
                    echo "</p>";
                } else {
                    echo "<p class = 'result'>No attendance found for the selected Event ID.</p>";
                }
            }
        }
    ?>

    <!-- Insertion form -->
    <h2>Insert an Event</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="insert">

        <label for="UIN">UIN:</label>
        <select name = "UIN" id = "UIN" required>
            <option value="none" selected disabled hidden>Select a UIN</option>
            <?php
                $query = "SELECT * FROM users WHERE User_Type = 'admin'";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["UIN"] . "'>" . $row["UIN"] . "</option>";
                    }
                } 
            ?>
        </select><br>

    
        <label for="Program_Num">Program Number:</label>
        <select name = "Program_Num" id = "Program_Num" required>
            <option value="none" selected disabled hidden>Select a Program Number</option>
            <?php
                $query = "SELECT * FROM programs";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Program_Num"] . "'>" . $row["Program_Num"] . "</option>";
                    }
                } 
            ?>
        </select><br>

        <label for="Start_Date">Start Date:</label>
        <input type="date" name="Start_Date" id="Start_Date" value="" required><br>
        
        <label for="Time">Time:</label>
        <input type="time" name="Time" id="Time" value="" required><br>

        <label for="Location">Location:</label>
        <input type="text" name="Location" id="Location" value="" required><br>

        <label for="End_Date">End Date:</label>
        <input type="date" name="End_Date" id="End_Date" value="" required><br>

        <label for="">Event Type:</label>
        <input type="text" name="Event_Type" id="Event_Type" value="" required><br><br>


        <input type="submit" value="Insert Event">
    </form>

    <!-- Insertion php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "insert"){
                // save the new inputs as variables
                $newUIN = $_POST['UIN'];
                $newProgNum = $_POST['Program_Num'];
                $newStartDate = $_POST['Start_Date'];
                $newTime = $_POST['Time'];
                $newLocation = $_POST['Location'];
                $newEndDate = $_POST['End_Date'];
                $newEventType = $_POST['Event_Type'];

                $sqlInsert = 
                    "INSERT INTO event 
                        (UIN, Program_Num, Start_Date, Time, Location, End_Date, Event_Type)
                    VALUES 
                        ($newUIN, $newProgNum, '$newStartDate', '$newTime', '$newLocation', '$newEndDate', '$newEventType')";
                
                if ($conn->query($sqlInsert) === TRUE) {
                    echo "<p class='response'>Inserted event successfully!</p>";
                } else {
                    echo "<p class='response'>Error adding event: " . $conn->error . "</p>";
                }
            }
        }
    ?>

    <!-- Deletion form -->
    <h2>Delete an Event</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="delete">

        <label for = "delete_event_ID">Select the event by EventID to delete:</label>
        <select name = "delete_event_ID" id = "delete_event_ID" required>
            <option value="none" selected disabled hidden>Select an ID</option>
            <?php
                $query = "SELECT * FROM event";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Event_ID"] . "'>" . $row["Event_ID"] . "</option>";
                    }
                } 
            ?>
        </select>

        <input type="submit" value="Delete Event">
    </form>

    <!-- Deletion php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "delete"){
                // Get the ID to delete from the form
                $selectedID = $_POST['delete_event_ID'];
                if(eventExists($selectedID, $conn)){
                    $sqlDelete = "DELETE FROM `event` WHERE Event_ID = '$selectedID'";
                    if ($conn->query($sqlDelete) === TRUE) {
                        echo "<p class='response'>Event with Event ID $selectedID deleted successfully!</p>";
                    } else {
                        echo "<p class='response'>Error deleting event: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p class='response'>Event doesn't exist.</p>";
                }
            }
        }
    ?>


    <!-- Update form -->
    <h2>Update an Event</h2> <br>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="update">

        <label for = "update_event_ID">Select the event ID for the event you wish to update:</label>
        <select name = "update_event_ID" id = "update_event_ID" required>
            <option value="none" selected disabled hidden>Select an ID</option>
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
        <select name="columnToChange" id="columnToChange" required>
            <option value="none" selected disabled hidden>Select an Attribute</option>
            <option value="UIN">UIN</option>
            <option value="Program_Num">Program Number</option>
            <option value="Start_Date">Start Date</option>
            <option value="Time">Time</option>
            <option value="Location">Location</option>
            <option value="End_Date">End Date</option>
            <option value="Event_Type">Event Type</option>
        </select><br>

        <label for="newValue">New Value:</label>
        <input type="text" name="newValue" id="newValue" value="" required><br><br>

        <input type="submit" value="Update Event">
    </form>

    <!-- Update php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "update"){
                // Get the ID, column, and value from the form
                $updateID = $_POST['update_event_ID'];
                $updateColumn = $_POST['columnToChange'];
                $newValue = $_POST['newValue'];

                if(eventExists($updateID, $conn)) {
                    $sqlUpdate = "UPDATE event SET $updateColumn = '$newValue' WHERE Event_ID = $updateID";
                    if ($conn->query($sqlUpdate) === TRUE) {
                        echo "<p class='response'>$updateColumn updated successfully to $newValue for the event with Event ID $updateID!</p>";
                    } else {
                        echo "<p class='response'>Error updating $updateColumn: " . $conn->error . "</p>";
                    }   
                } else {
                    echo "<p class='response'>Event with that ID not found.</p>";
                }

            }
        }
    ?>

    <!-- Editing Event Attendance form -->
    <h2>Add/Remove student events attendance  </h2>
    <form method = "post" action = "">
        <input type="hidden" name="form_id" value="edit_attendance">

        <label for = "select_event_ID">Select an event ID to edit attendance:</label>
        <select name = "select_event_ID" id = "select_event_ID" required>
        <option value="none" selected disabled hidden>Select an Event ID</option>

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

        <label for = "select_UIN">Select a student by UIN to edit:</label>
        <select name = "select_UIN" id = "select_UIN" required>
        <option value="none" selected disabled hidden>Select a Student UIN</option>

            <?php
                $query = "SELECT * FROM collegestudents";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["UIN"] . "'>" . $row["UIN"] . "</option>";
                    }
                } 
            ?>
        </select> <br>

        <label for = "add_remove">Add or remove the student?:</label>
        <select name = "add_remove" id = "add_remove" required>
            <option value = "none" selected disabled hidden>Select Add or Remove</option>
            <option value = "add">Add</option>
            <option value = "remove">Remove</option>
        </select>
        <br><br>
        <input type="submit" value="Edit Attendance">
    </form>

    <!-- Editing Event Attendance php -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formID = $_POST['form_id'];
            if($formID == "edit_attendance"){
                // Get the selected ID, UIN, and user choice from the form
                $add_remove = $_POST['add_remove'];
                $selectedID = $_POST['select_event_ID'];
                $selectedUIN = $_POST['select_UIN'];

                if($add_remove == "add") {
                    if(!eventStudentExists($selectedID, $selectedUIN, $conn)){
                        $sqlInsert = "INSERT INTO event_tracking (Event_ID, UIN) VALUES ($selectedID, $selectedUIN)";
                        
                        if ($conn->query($sqlInsert) === TRUE) {
                            echo "<p class='response'>Student with UIN $selectedUIN added to Event with Event ID $selectedID successfully!</p>";
                        } else {
                            echo "<p class='response'>Error adding event attendance: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p class='response'>Student already has attendance at given event.</p>";
                    }

                } else if ($add_remove == "remove") {
                    if(eventStudentExists($selectedID, $selectedUIN, $conn)){
                        $sqlDelete = "DELETE FROM `event_tracking` WHERE UIN = '$selectedUIN'";
                        if ($conn->query($sqlDelete) === TRUE) {
                            echo "<p class='response'>Student with UIN $selectedUIN removed from Event with Event ID $selectedID successfully!</p>";
                        } else {
                            echo "<p class='response'>Error removing event attendance: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p class='response'>Student attendance at given event doesn't exist.</p>";
                    }
                }
            }
        }
    ?>
</body>
</html>