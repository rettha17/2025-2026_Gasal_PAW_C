<?php
include "koneksi.php";

// Ambil ID transaksi dari URL
if (!isset($_GET['id'])) {
    echo "<script>alert('ID transaksi tidak ditemukan!'); window.location='transaksi_list.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data transaksi
$q = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id=$id");
if (mysqli_num_rows($q) == 0) {
    echo "<script>alert('Transaksi tidak ditemukan!'); window.location='transaksi_list.php';</script>";
    exit;
}

$t = mysqli_fetch_assoc($q);

// ===============================
// PROSES TAMBAH DETAIL TRANSAKSI
// ===============================
if (isset($_POST['tambah'])) {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];

    // 1️⃣ Cek stok barang
    $q_barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id=$barang_id");
    $barang = mysqli_fetch_assoc($q_barang);

    if ($barang['stok'] < $jumlah) {
        echo "<script>alert('Stok tidak cukup! Stok tersedia: {$barang['stok']}'); 
        window.location='transaksi_detail.php?id=$id';</script>";
        exit;
    }

    // 2️⃣ Cek barang sudah ada di detail atau tidak
    $cek = mysqli_query($koneksi, "SELECT * FROM detail_transaksi 
                                   WHERE transaksi_id=$id AND barang_id=$barang_id");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Barang ini sudah ada di transaksi!'); 
        window.location='transaksi_detail.php?id=$id';</script>";
        exit;
    }

    // 3️⃣ Kurangi stok barang
    mysqli_query($koneksi, "UPDATE barang SET stok = stok - $jumlah WHERE id = $barang_id");

    // 4️⃣ Simpan ke detail transaksi
    mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, barang_id, jumlah)
                            VALUES ($id, $barang_id, $jumlah)");

    // 5️⃣ Update total transaksi
    $q_total = mysqli_query($koneksi, "
        SELECT SUM(d.jumlah * b.harga) AS total 
        FROM detail_transaksi d 
        JOIN barang b ON d.barang_id = b.id 
        WHERE d.transaksi_id = $id
    ");
    $total_row = mysqli_fetch_assoc($q_total);
    $total = $total_row['total'] ?? 0;

    mysqli_query($koneksi, "UPDATE transaksi SET total=$total WHERE id=$id");

    // reload
    header("Location: transaksi_detail.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
</head>
<body>
<h2>Detail Transaksi #<?= $t['id'] ?></h2>
Tanggal: <?= $t['tanggal'] ?><br>
Total: <b>Rp <?= number_format($t['total'],0,',','.') ?></b><br><br>

<!-- Form tambah barang -->
<form method="post">
    Pilih Barang:
    <select name="barang_id" required>
        <option value="">-- pilih barang --</option>
        <?php
        $barang_list = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang");
        while ($b = mysqli_fetch_assoc($barang_list)) {
            echo "<option value='{$b['id']}'>
                {$b['nama_barang']} - Stok: {$b['stok']} (Rp " . number_format($b['harga'],0,',','.') . ")
            </option>";
        }
        ?>
    </select>

    Jumlah:
    <input type="number" name="jumlah" min="1" required>

    <input type="submit" name="tambah" value="Tambah Barang">
</form>

<br>

<!-- Tabel detail transaksi -->
<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Aksi</th>
    </tr>

    <?php
    $detail = mysqli_query($koneksi, "
        SELECT d.*, b.nama_barang, b.harga 
        FROM detail_transaksi d 
        JOIN barang b ON d.barang_id = b.id 
        WHERE d.transaksi_id = $id
    ");

    $no = 1;
    while ($r = mysqli_fetch_assoc($detail)) {
        $sub = $r['harga'] * $r['jumlah'];

        echo "<tr>
            <td>$no</td>
            <td>{$r['nama_barang']}</td>
            <td>Rp " . number_format($r['harga'],0,',','.') . "</td>
            <td>{$r['jumlah']}</td>
            <td>Rp " . number_format($sub,0,',','.') . "</td>
            <td>
                <a href='detail_hapus.php?id={$r['id']}&transaksi_id={$t['id']}'
                   onclick=\"return confirm('Yakin ingin menghapus barang ini?')\">
                    Hapus
                </a>
            </td>
        </tr>";

        $no++;
    }
    ?>
</table>

<br>
<a href="transaksi_list.php">← Kembali ke Transaksi</a>

</body>
</html>
