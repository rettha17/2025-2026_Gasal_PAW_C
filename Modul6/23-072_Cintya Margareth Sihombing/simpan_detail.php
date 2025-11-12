<?php
include "koneksi.php";

$transaksi_id = $_POST['transaksi_id'];
$barang_id = $_POST['barang_id'];
$jumlah = $_POST['jumlah'];

// Cek apakah barang sudah ada di transaksi
$cek = mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE transaksi_id='$transaksi_id' AND barang_id='$barang_id'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Barang ini sudah ada di transaksi ini!'); history.back();</script>";
    exit;
}

// Simpan detail
mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, barang_id, jumlah) VALUES ('$transaksi_id', '$barang_id', '$jumlah')");

// Hitung ulang total
$q = mysqli_query($koneksi, "SELECT d.*, b.harga FROM detail_transaksi d JOIN barang b ON d.barang_id=b.id WHERE d.transaksi_id='$transaksi_id'");
$total = 0;
while($r = mysqli_fetch_assoc($q)){
    $total += $r['harga'] * $r['jumlah'];
}
mysqli_query($koneksi, "UPDATE transaksi SET total='$total' WHERE id='$transaksi_id'");

echo "<script>alert('Data detail transaksi disimpan!'); window.location='transaksi_detail.php?id=$transaksi_id';</script>";
