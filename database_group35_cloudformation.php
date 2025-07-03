<?php
$host = "mydb.c1psoqzrglo8.us-east-1.rds.amazonaws.com"; //RDS endpoint
$user = "admin";       // RDS username
$password = "admin7288"; // RDS password
$dbname = "testdb";    // database name

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $id_no = $_POST['identification_no'];

    if (preg_match('/^\d{4}$/', $id_no)) {
        $stmt = $conn->prepare("INSERT INTO users (name, position, identification_no) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $position, $id_no);
        $success = $stmt->execute() ? "✅ Data saved successfully!" : "❌ Error saving data.";
        $stmt->close();
    } else {
        $success = "⚠️ ID number must be exactly 4 digits.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Form</title>
</head>
<body>
    <h2>Register User</h2>
    <form method="post" action="">
        <label>Full Name:</label>
        <input type="text" name="name" required><br>
        <label>Position:</label>
        <input type="text" name="position" required><br>
        <label>ID Number (4 digits):</label>
        <input type="text" name="identification_no" pattern="\d{4}" required><br>
        <input type="submit" value="Submit">
    </form>

    <?php if ($success): ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
</body>
</html>
