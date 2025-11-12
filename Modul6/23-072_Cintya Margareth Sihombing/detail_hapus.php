<?php
include "koneksi.php";
$id = $_GET['id'];
$transaksi_id = $_GET['transaksi_id'];

// ambil data detail
$d = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE id=$id"));
$barang_id = $d['barang_id'];
$jumlah = $d['jumlah'];

// kembalikan stok
mysqli_query($koneksi, "UPDATE barang SET stok = stok + $jumlah WHERE id=$barang_id");

// hapus detail
mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE id=$id");

header("Location: transaksi_detail.php?id=$transaksi_id");
exit;
?>
