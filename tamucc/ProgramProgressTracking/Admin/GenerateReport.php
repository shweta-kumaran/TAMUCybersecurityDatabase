<?php
echo '    <link rel="stylesheet" href="/TAMUCybersecurityDatabase/tamucc/includes/styles.css">';

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tamuccdb";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$reportContent = "This is the dynamically generated report content."; // Replace with your report generation logic
$dateTime = new DateTime();
$reportName = "Report " . $dateTime->format('Y-m-d H:i:s');

// Function to get completed students
function getCompletedStudents($conn, $table, $statusColumn) {
    $completedStudents = [];
    $query = "SELECT UIN FROM $table WHERE $statusColumn = 'C'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $completedStudents[] = $row['UIN'];
        }
    }
    return $completedStudents;
}

// Function to count students for certification
function countStudentsForCertification($conn, $certDesc, $statusColumn, $statusValue) {
    $query = "SELECT COUNT(DISTINCT UIN) as StudentCount FROM cert_enrollment ce JOIN certification c ON ce.Cert_ID = c.Cert_ID WHERE c.Cert_Des = '$certDesc' AND ce.$statusColumn = '$statusValue'";
    $result = $conn->query($query);
    return ($result->num_rows > 0) ? $result->fetch_assoc()['StudentCount'] : 0;
}

// Function to get students by class type
function getStudentsByClassType($conn, $classType) {
    $students = [];
    $query = "SELECT ce.UIN FROM class_enrollment ce JOIN classes c ON ce.Class_ID = c.Class_ID WHERE c.Class_Type = '$classType'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row['UIN'];
        }
    }
    return $students;
}

// Report: Number of students per program
$query = "SELECT p.Prog_Name, COUNT(t.Student_Num) AS StudentCount
          FROM programs p
          JOIN track t ON p.Program_Num = t.Program_Num
          GROUP BY p.Prog_Name;";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $reportContent .= "<h2>Students per Program</h2><ul>";
    while($row = $result->fetch_assoc()) {
        $reportContent .= "<li>Program: " . $row["Prog_Name"] . " - Students: " . $row["StudentCount"] . "</li>";
    }
    $reportContent .= "</ul>";
} else {
    $reportContent .= "<p>No results for students per program</p>";
}

// Report: Students who completed all (internships, courses, and classes)
$completedInternships = getCompletedStudents($conn, 'intern_app', 'Status');
$completedCourses = getCompletedStudents($conn, 'class_enrollment', 'Stat');
$completedClasses = getCompletedStudents($conn, 'cert_enrollment', 'Stat');
$studentsCompletedAll = array_intersect($completedInternships, $completedCourses, $completedClasses);
$reportContent .= "<p>Number of students who completed all (internships, courses, and classes): " . count($studentsCompletedAll) . "</p>";

// Report: Students in foreign language and cryptography courses
$foreignLanguageStudents = getStudentsByClassType($conn, 'f');
$cryptographyStudents = getStudentsByClassType($conn, 'c');
$reportContent .= "<p>Number of students in foreign language courses: " . count($foreignLanguageStudents) . "</p>";
$reportContent .= "<p>Number of students in cryptography courses: " . count($cryptographyStudents) . "</p>";

// Report: Dod Certifications
$enrolledInDod = countStudentsForCertification($conn, 'Dod', 'Stat', 'E'); // 'E' for enrollment
$completedDodTraining = countStudentsForCertification($conn, 'Dod', 'Training_Stat', 'C'); // 'C' for completed
$passedDodExamination = countStudentsForCertification($conn, 'Dod', 'Stat', 'C'); // 'C' for completed
$reportContent .= "<p>Number of students enrolled in Dod certifications: " . $enrolledInDod . "</p>";
$reportContent .= "<p>Number of students who completed Dod certification training: " . $completedDodTraining . "</p>";
$reportContent .= "<p>Number of students who passed Dod certification examination: " . $passedDodExamination . "</p>";

// Report: Hispanic/Latino students count
$query = "SELECT COUNT(*) as HispanicLatinoCount FROM collegestudents WHERE HispanicLatino = 1";
$result = $conn->query($query);
$hispanicLatinoCount = ($result->num_rows > 0) ? $result->fetch_assoc()['HispanicLatinoCount'] : 0;
$reportContent .= "<p>Number of minority students: " . $hispanicLatinoCount . "</p>";

// Report: Students pursuing government internships
$query = "SELECT COUNT(DISTINCT ia.UIN) AS GovInternshipCount
          FROM intern_app ia
          JOIN internship i ON ia.Intern_ID = i.Intern_ID
          WHERE i.is_Gov = 1;";
$result = $conn->query($query);
$govInternshipCount = ($result->num_rows > 0) ? $result->fetch_assoc()['GovInternshipCount'] : 0;
$reportContent .= "<p>Number of students pursuing government internships: " . $govInternshipCount . "</p>";

$dateTime = new DateTime();
$reportName = "Report " . $dateTime->format('Y-m-d H:i:s');

// Save report details in the database
$stmt = $conn->prepare("INSERT INTO reports (report_name, report_content) VALUES (?, ?)");
$stmt->bind_param("ss", $reportName, $reportContent); // $reportContent is generated from your logic
$stmt->execute();
$stmt->close();
echo $reportContent;

$conn->close();

// Redirect back to the index page
//header("Location: index.php");
exit;
?>