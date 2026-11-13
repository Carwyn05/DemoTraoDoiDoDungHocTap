<?php
// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$pass = ""; // XAMPP mặc định để trống
$dbname = "trao_doi_hoc_tap";

$conn = new mysqli($host, $user, $pass, $dbname, 3307);

if ($conn->connect_error) {             
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
    