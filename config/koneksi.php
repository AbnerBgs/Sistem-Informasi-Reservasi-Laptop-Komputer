<?php
$conn = mysqli_connect(
    "sql309.infinityfree.com",
    "if0_43504921",
    "rVlnwhjpFHSpx",
    "if0_43504921_service_laptop"
    );

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>