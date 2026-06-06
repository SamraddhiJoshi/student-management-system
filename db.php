<?php
// *** UPDATED FOR INFINITYFREE DEPLOYMENT ***
// 1. Hostname (from screenshot)
$servername = "sql310.infinityfree.com"; 

// 2. Username (from screenshot)
$username = "if0_40381344"; 

// 3. Password (Crucial: Replace with your InfinityFree account password)
$password = "pi7vvZTn1tLqUdX"; 

// 4. Database Name (from screenshot)
$dbname = "if0_40381344_studentdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Optional: echo "Connected successfully";
?>