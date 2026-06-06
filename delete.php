<?php
// delete.php - Handles deleting a student record

include 'db.php'; // Include database connection

// Check if an 'id' was passed in the URL (e.g., delete.php?id=5)
if (isset($_GET['id'])) {
    
    // Get the student ID and ensure it is an integer for security
    $id = (int)$_GET['id'];
    
    // Prepare the SQL DELETE statement
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    
    // 'i' means the parameter is an integer
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Deletion successful
    } else {
        // Handle error (optional: display error message)
        // echo "Error deleting record: " . $stmt->error;
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Redirect back to the main list page (index.php) after deletion (or attempted deletion)
header("Location: index.php");
exit;
?>