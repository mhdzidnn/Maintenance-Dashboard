<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec('DROP DATABASE IF EXISTS maintenance_dashboard');
    $pdo->exec('CREATE DATABASE maintenance_dashboard');
    echo "Database recreated successfully.\n";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
