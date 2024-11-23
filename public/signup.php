<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hash

    // Prepare SQL to insert data
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
        $_SESSION['message'] = "Signup successful. You can now login.";
        header('Location: login.php');
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
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Signup</h1>
    <form method="POST" action="signup.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Signup</button>
    </form>
    <?php
        if (isset($_SESSION['error'])) {
            echo "<p>{$_SESSION['error']}</p>";
            unset($_SESSION['error']);
        }
    ?>
</body>
</html>
