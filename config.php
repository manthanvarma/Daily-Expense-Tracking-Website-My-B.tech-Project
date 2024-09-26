<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=detw", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "failed" . $e->getMessage();
}

?>

<link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/1490/1490817.png">