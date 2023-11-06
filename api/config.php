<?php
$servername = "sql213.infinityfree.com";
$username = "if0_35351462";
$password = "cnOTJAbroveSEZO";
$database = "if0_35351462_ahmedtest";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else {
    echo "Connected successfully";
}
?>
