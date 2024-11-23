<?php
session_start();
include '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $event_name = $_POST['event_name'];
    $student_name = $_POST['student_name'];
    $class = $_POST['class'];
    $year = $_POST['year'];
    $department = $_POST['department'];
    $payment_details = $_POST['payment_details'];
    $college_name = $_POST['college_name'];

    // Prepare SQL to insert registration
    $sql = "INSERT INTO registrations (user_id, event_name, student_name, class, year, department, payment_details, college_name) 
            VALUES (:user_id, :event_name, :student_name, :class, :year, :department, :payment_details, :college_name)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'user_id' => $user_id,
            'event_name' => $event_name,
            'student_name' => $student_name,
            'class' => $class,
            'year' => $year,
            'department' => $department,
            'payment_details' => $payment_details,
            'college_name' => $college_name
        ]);
        $_SESSION['message'] = "Registration successful!";
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Register for Event</h1>
    <form method="POST" action="event_registration.php">
        <input type="text" name="event_name" placeholder="Event Name" required>
        <input type="text" name="student_name" placeholder="Student Name" required>
        <input type="text" name="class" placeholder="Class" required>
        <input type="text" name="year" placeholder="Year" required>
        <input type="text" name="department" placeholder="Department" required>
        <input type="text" name="payment_details" placeholder="Payment Details" required>
        <input type="text" name="college_name" placeholder="College Name" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
