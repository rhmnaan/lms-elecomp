<?php
// Test script untuk check user_materi_progress

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Config/Constants.php';

$config = new Config\Database();
$db = $config->connect();

echo "=== USER MATERI PROGRESS TABLE ===\n";
$result = $db->table('user_materi_progress')->findAll();
echo "Total records: " . count($result) . "\n\n";

foreach ($result as $row) {
    echo "ID: {$row['id']}, User: {$row['id_users']}, Materi: {$row['id_materi']}, Completed: {$row['is_completed']}, Time: {$row['completed_at']}\n";
}

echo "\n=== CEK SPECIFIC USER ===\n";
$userMateriProgress = $db->table('user_materi_progress')
    ->where('id_users', 10)
    ->findAll();
echo "Progress untuk user 10: " . count($userMateriProgress) . " records\n";
foreach ($userMateriProgress as $row) {
    echo "- Materi {$row['id_materi']}: {$row['is_completed']}\n";
}
