<?php
$koneksi = mysqli_connect("localhost", "root", "", "my_tp5");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>