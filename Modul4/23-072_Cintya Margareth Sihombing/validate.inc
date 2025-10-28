<?php
// Fungsi untuk memvalidasi input surname (hanya huruf, tanda kutip tunggal, atau strip)
function validateName($field_list, $field_name) {
    // Pastikan field ada
    if (!isset($field_list[$field_name]))
        return false;

    // Pola hanya huruf, tanda kutip tunggal, atau strip
    $pattern = "/^[a-zA-Z'-]+$/";

    // Cek apakah input sesuai pola
    if (!preg_match($pattern, $field_list[$field_name]))
        return false;

    // Jika lolos semua, return true
    return true;
}
?>
