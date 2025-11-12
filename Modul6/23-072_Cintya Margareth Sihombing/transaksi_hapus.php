<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    echo "<script>alert('ID transaksi tidak ditemukan!'); window.location='transaksi_list.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil semua detail transaksi untuk kembalikan stok
$details = mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE transaksi_id=$id");
while($d = mysqli_fetch_assoc($details)){
    $barang_id = $d['barang_id'];
    $jumlah = $d['jumlah'];

    // kembalikan stok barang
    mysqli_query($koneksi, "UPDATE barang SET stok = stok + $jumlah WHERE id=$barang_id");
}

// Hapus semua detail transaksi
mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE transaksi_id=$id");

// Hapus transaksi utama
mysqli_query($koneksi, "DELETE FROM transaksi WHERE id=$id");

echo "<script>alert('Transaksi berhasil dihapus'); window.location='transaksi_list.php';</script>";
exit;
?>
