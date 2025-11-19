<?php include "koneksi.php"; ?>

<h2>Data Transaksi</h2>
<a href="transaksi_tambah.php">+ Tambah Transaksi</a>
<br><br>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>

<?php
$q = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY id DESC");
while ($r = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td>{$r['id']}</td>
        <td>{$r['tanggal']}</td>
        <td>Rp " . number_format($r['total'], 0, ',', '.') . "</td>
        <td>
            <a href='transaksi_detail.php?id={$r['id']}'>Detail</a> | 
            <a href='transaksi_hapus.php?id={$r['id']}' onclick='return confirm(\"Yakin ingin menghapus transaksi ini?\")'>Hapus</a>
        </td>
    </tr>";
}
?>
</table>

<br>
<a href="barang_list.php">📦 Data Barang</a>
