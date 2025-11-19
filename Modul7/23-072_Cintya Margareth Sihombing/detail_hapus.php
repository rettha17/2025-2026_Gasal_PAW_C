<?php
include "koneksi.php";

// Pastikan parameter lengkap
if (!isset($_GET['id']) || !isset($_GET['transaksi_id'])) {
    echo "<script>alert('Parameter tidak lengkap!'); window.location='transaksi_list.php';</script>";
    exit;
}

$id_detail = $_GET['id'];           // id baris detail_transaksi
$transaksi_id = $_GET['transaksi_id'];

// Ambil data detail transaksi (jumlah & barang_id)
$q = mysqli_query($koneksi, "
    SELECT * FROM detail_transaksi WHERE id = $id_detail
");

if (mysqli_num_rows($q) == 0) {
    echo "<script>alert('Detail transaksi tidak ditemukan!'); 
    window.location='transaksi_detail.php?id=$transaksi_id';</script>";
    exit;
}

$detail = mysqli_fetch_assoc($q);
$barang_id = $detail['barang_id'];
$jumlah = $detail['jumlah'];

// 1️⃣ Kembalikan stok barang
mysqli_query($koneksi, "
    UPDATE barang SET stok = stok + $jumlah WHERE id = $barang_id
");

// 2️⃣ Hapus baris detail transaksi
mysqli_query($koneksi, "
    DELETE FROM detail_transaksi WHERE id = $id_detail
");

// 3️⃣ Hitung ulang total transaksi
$q_total = mysqli_query($koneksi, "
    SELECT SUM(d.jumlah * b.harga) AS total 
    FROM detail_transaksi d
    JOIN barang b ON d.barang_id = b.id
    WHERE d.transaksi_id = $transaksi_id
");

$total_row = mysqli_fetch_assoc($q_total);
$total_baru = $total_row['total'] ?? 0;

// 4️⃣ Update total transaksi
mysqli_query($koneksi, "
    UPDATE transaksi SET total = $total_baru WHERE id = $transaksi_id
");

// 5️⃣ Kembali ke halaman detail
echo "<script>alert('Barang berhasil dihapus!'); 
window.location='transaksi_detail.php?id=$transaksi_id';</script>";
exit;
