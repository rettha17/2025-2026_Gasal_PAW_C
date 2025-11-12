<?php
include "koneksi.php";

$id = $_GET['id'];

// cek apakah barang dipakai di detail_transaksi
$cek = mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE barang_id='$id'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Barang tidak bisa dihapus karena sudah dipakai di transaksi!'); window.location='barang_list.php';</script>";
    exit;
}

// jika aman, hapus
mysqli_query($koneksi, "DELETE FROM barang WHERE id='$id'");
echo "<script>alert('Barang berhasil dihapus'); window.location='barang_list.php';</script>";
