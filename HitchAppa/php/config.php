<?php
// Database connection. Override the defaults with environment variables in production.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli(
    getenv('DB_HOST') ?: 'localhost',
    getenv('DB_USERNAME') ?: 'root',
    getenv('DB_PASSWORD') ?: '',
    getenv('DB_DATABASE') ?: 'user_info'
);
$conn->set_charset('utf8mb4');
