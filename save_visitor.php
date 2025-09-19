<!-- save_visitor.php -->
<?php
// save_visitor.php

// --- Database configuration ---
$host = '127.0.0.1'; // or 'localhost'
$db   = 'visitors'; // replace with your database name
$user = 'root';       // default XAMPP user
$pass = '';           // default XAMPP password is empty
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// --- Get form data safely ---
$name   = trim($_POST['name'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$reason = trim($_POST['reason'] ?? '');
$notes  = trim($_POST['notes'] ?? '');
$ip     = $_SERVER['REMOTE_ADDR'] ?? '';

// --- Basic validation ---
if (!$name || !$phone || !$reason) {
    die("Error: Name, phone, and reason are required fields.");
}

// --- Insert into database ---
try {
    $stmt = $pdo->prepare("INSERT INTO visitors (name, phone, reason, notes, ip, checked_in_at) VALUES (:name, :phone, :reason, :notes, :ip, NOW())");
    $stmt->execute([
        ':name'   => $name,
        ':phone'  => $phone,
        ':reason' => $reason,
        ':notes'  => $notes,
        ':ip'     => $ip
    ]);

    // Redirect to success page
    header("Location: success.html");
    exit;
} catch (\PDOException $e) {
    die("Error saving visitor: " . $e->getMessage());
}
?>
