<?php
// form.php - Handles both CREATE (Add) and UPDATE (Edit) operations

include 'db.php'; 

$id = $_GET['id'] ?? null; // Get ID from URL if editing, otherwise it's null
$name=$email=$course=$year=$marks=""; // Initialize variables
$is_editing = false;
$page_title = "Add New Student Record";

// --- Logic for Edit Mode (Fetching Existing Data) ---
if ($id) {
    $is_editing = true;
    $page_title = "Edit Student Record (ID: $id)";
    
    // Fetch the existing record to pre-fill the form
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $res = $result->fetch_assoc();
        $name=$res['name']; 
        $email=$res['email']; 
        $course=$res['course']; 
        $year=$res['year']; 
        $marks=$res['marks'];
    } else {
        // If ID is invalid, redirect back
        header("Location: index.php");
        exit;
    }
    $stmt->close();
}

// --- Logic for Form Submission (CREATE or UPDATE) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get and sanitize POST data
    $post_id = $_POST['id'] ?? null; // Hidden ID field determines if it's an update
    $name = $_POST['name']; 
    $email = $_POST['email']; 
    $course = $_POST['course']; 
    $year = (int)$_POST['year']; 
    $marks = (int)$_POST['marks'];

    if (!empty($post_id)) {
        // --- UPDATE Operation ---
        $stmt = $conn->prepare("UPDATE students SET name=?, email=?, course=?, year=?, marks=? WHERE student_id=?");
        // sssiii = 3 strings, 3 integers (including the ID at the end)
        $stmt->bind_param("sssiii", $name, $email, $course, $year, $marks, $post_id);
    } else {
        // --- INSERT (CREATE) Operation ---
        $stmt = $conn->prepare("INSERT INTO students (name, email, course, year, marks) VALUES (?, ?, ?, ?, ?)");
        // sssii = 3 strings, 2 integers
        $stmt->bind_param("sssii", $name, $email, $course, $year, $marks);
    }

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // Redirect to main page after success
        header("Location: index.php");
        exit; 
    } else {
        $message = "<p style='color: red;'>❌ Error: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form div { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="number"] { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <h2><?= $page_title ?></h2>
    <?= $message ?? '' ?> 

    <form method="post" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>"> 
        
        <div>
            <label for="name">Name (Required):</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
        </div>
        <div>
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" value="<?= htmlspecialchars($course) ?>">
        </div>
        <div>
            <label for="year">Year (1-5):</label>
            <input type="number" id="year" name="year" min="1" max="5" value="<?= htmlspecialchars($year) ?>">
        </div>
        <div>
            <label for="marks">Marks (0-100):</label>
            <input type="number" id="marks" name="marks" min="0" max="100" value="<?= htmlspecialchars($marks) ?>">
        </div>
        
        <button type="submit"><?= $is_editing ? 'Update Record' : 'Add Student' ?></button>
        <a href="index.php" style="margin-left: 15px;">⬅️ Cancel / Back to List</a>
    </form>

</body>
</html>