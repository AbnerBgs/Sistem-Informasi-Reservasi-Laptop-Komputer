<?php
$host = "sql309.infinityfree.com";
$user = "if0_43504921";
$pass = "rVlnwhjpFHSpx";
$db   = "if0_43504921_service_laptop";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>