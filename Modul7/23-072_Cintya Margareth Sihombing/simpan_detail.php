<?php
include "koneksi.php";

$transaksi_id = $_POST['transaksi_id'];
$barang_id    = $_POST['barang_id'];
$jumlah       = $_POST['jumlah'];

// ================================
// CEK BARANG SUDAH ADA DI DETAIL?
// ================================
$cek = mysqli_query($koneksi, 
    "SELECT * FROM detail_transaksi 
     WHERE transaksi_id='$transaksi_id' AND barang_id='$barang_id'"
);

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Barang ini sudah ada di transaksi ini!'); history.back();</script>";
    exit;
}

// ================================
// CEK STOK CUKUP?
// ================================
$stokData = mysqli_query($koneksi, "SELECT stok FROM barang WHERE id='$barang_id'");
$stok = mysqli_fetch_assoc($stokData)['stok'];

if ($jumlah > $stok) {
    echo "<script>alert('Stok tidak mencukupi! Stok tersedia: $stok'); history.back();</script>";
    exit;
}

// ================================
// SIMPAN DETAIL TRANSAKSI
// ================================
mysqli_query($koneksi, 
    "INSERT INTO detail_transaksi (transaksi_id, barang_id, jumlah) 
     VALUES ('$transaksi_id', '$barang_id', '$jumlah')"
);

// ================================
// KURANGI STOK BARANG
// ================================
mysqli_query($koneksi, 
    "UPDATE barang SET stok = stok - $jumlah 
     WHERE id='$barang_id'"
);

// ================================
// HITUNG ULANG TOTAL TRANSAKSI
// ================================
$q = mysqli_query($koneksi, 
    "SELECT d.jumlah, b.harga 
     FROM detail_transaksi d 
     JOIN barang b ON d.barang_id = b.id 
     WHERE d.transaksi_id = '$transaksi_id'"
);

$total = 0;
while ($r = mysqli_fetch_assoc($q)) {
    $total += $r['harga'] * $r['jumlah'];
}

mysqli_query($koneksi, 
    "UPDATE transaksi SET total='$total' 
     WHERE id='$transaksi_id'"
);

// ================================
// SELESAI
// ================================
echo "<script>
        alert('Detail transaksi berhasil ditambahkan!');
        window.location='transaksi_detail.php?id=$transaksi_id';
      </script>";
