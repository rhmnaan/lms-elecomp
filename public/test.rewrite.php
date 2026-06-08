<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Debug Information</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Current Directory: " . getcwd() . "<br>";
echo "FCPATH: " . __DIR__ . DIRECTORY_SEPARATOR . "<br><br>";

echo "<h3>File Check:</h3>";
$files_to_check = [
    'index.php' => __DIR__ . '/index.php',
    '../app/Config/Paths.php' => __DIR__ . '/../app/Config/Paths.php',
    '../vendor/autoload.php' => __DIR__ . '/../vendor/autoload.php',
    '../writable' => __DIR__ . '/../writable',
];

foreach ($files_to_check as $name => $path) {
    $exists = file_exists($path);
    $readable = $exists ? is_readable($path) : false;
    echo "$name: " . ($exists ? '✅ EXISTS' : '❌ NOT FOUND');
    echo " | " . ($readable ? '✅ READABLE' : '❌ NOT READABLE') . "<br>";
}

echo "<br><h3>Try Loading CodeIgniter:</h3>";
try {
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    require __DIR__ . '/../app/Config/Paths.php';
    echo "✅ Paths.php loaded successfully!<br>";
    
    $paths = new Config\Paths();
    echo "✅ Paths object created!<br>";
    echo "System Directory: " . $paths->systemDirectory . "<br>";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>