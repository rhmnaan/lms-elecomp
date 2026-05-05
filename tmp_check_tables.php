<?php
$conn = new mysqli("localhost", "root", "", "lms_elecomp");
if ($conn->connect_errno) {
    echo "CONNECT_FAIL: " . $conn->connect_error . "\n";
    exit(1);
}
foreach (["tugas", "tugas_pengumpulan", "tugas_komentar"] as $table) {
    $res = $conn->query("SHOW COLUMNS FROM $table");
    echo "\nTABLE $table\n";
    while ($row = $res->fetch_assoc()) {
        echo $row["Field"] . " " . $row["Type"] . " " . ($row["Null"] === "NO" ? "NOT NULL" : "NULL") . " " . $row["Extra"] . "\n";
    }
}
