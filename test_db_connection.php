<?php
$servername = "wordpress_db";
$username = "wordpress";
$password = "password"; // ここを docker-compose.yml の WORDPRESS_DB_PASSWORD の値に置き換えてください
$dbname = "wordpress_db";

// 接続を作成
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to database successfully using PDO";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
$conn = null; 
?>
