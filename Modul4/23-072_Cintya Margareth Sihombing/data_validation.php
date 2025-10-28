<?php
$hari = 31;
$bulan = 11;
$tahun = 2025;

if (checkdate($bulan, $hari, $tahun)) {
    echo "Tanggal valid";
} else {
    echo "Tanggal tidak valid";
}
?>