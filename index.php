<?php
// index.php
// This line includes your database connection file
include 'db.php'; 

// Fetch the data from the 'students' table
$sql = "SELECT * FROM students ORDER BY student_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records Display</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { color: #333; }
        table { width: 90%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .add-link { display: block; margin-bottom: 20px; color: #28a745; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Student Records from Database</h2>
    
    <a href="form.php" class="add-link">➕ Add New Student</a>

    <?php
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // 1. START TABLE AND PRINT HEADER (ONLY ONCE)
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Year</th><th>Marks</th><th>Action</th></tr>"; // <--- THIS LINE SHOULD BE HERE, NOT INSIDE THE LOOP!
        
        // 2. START LOOP FOR DATA ROWS
       // Loop through each row of data
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            
            // 1. ID
            echo "<td>" . $row["student_id"]. "</td>";
            
            // 2. Name
            echo "<td>" . $row["name"]. "</td>";
            
            // 3. Email 
            echo "<td>" . $row["email"]. "</td>";
            
            // 4. Course 
            echo "<td>" . $row["course"]. "</td>";
            
            // 5. Year 
            echo "<td>" . $row["year"]. "</td>";
            
            // 6. Marks 
            echo "<td>" . $row["marks"]. "</td>";
            
            // 7. Action
            echo "<td>
                    <a href='form.php?id=" . $row["student_id"] . "'>Edit</a> | 
                    <a href='delete.php?id=" . $row["student_id"] . "' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
                  </td>"; 
            echo "</tr>";
        }
        
        // 3. END TABLE
        echo "</table>";
    } else {
        // Message if the table is empty
        echo "<p>No student records found in the database.</p>";
    }
    
    
    // Close the database connection
    $conn->close();
    ?>

</body>
</html>