<!-- db.php -->
<?php
// db.php - PDO connection
$host   = '127.0.0.1';
$db     = 'visitor_db';    // we'll create this DB below
$user   = 'root';          // default in XAMPP; change if you create a dedicated user
$pass   = '';              // XAMPP default is usually empty for root
$charset= 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  // dev: show a friendly message (in production log instead)
  http_response_code(500);
  echo "DB connection failed: " . htmlspecialchars($e->getMessage());
  exit;
}
