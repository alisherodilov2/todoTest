<?php

$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die('.env file not found');
}

$envVars = parse_ini_file($envFile);
if ($envVars === false) {
    die('Error parsing .env file');
}

$servername = $envVars['DB_HOST'] ?? 'localhost';
$username = $envVars['DB_USERNAME'] ?? 'root';
$password = $envVars['DB_PASSWORD'] ?? '';
$dbname = $envVars['DB_NAME'] ?? 'todo_db';

$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === true) {
    $conn->select_db($dbname);

    $sql = "CREATE TABLE IF NOT EXISTS todos (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        task VARCHAR(255) NOT NULL,
        completed BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!$conn->query($sql)) {
        echo 'Error creating table: ' . $conn->error;
    }
} else {
    echo 'Error creating database: ' . $conn->error;
}
?>
