<?php
include "koneksi.php";
?>

<h2>Data Barang</h2>
<a href="barang_tambah.php">+ Tambah Barang</a>
<br><br>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

<?php
$q = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id ASC");
while ($r = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td>{$r['id']}</td>
        <td>{$r['nama_barang']}</td>
        <td>Rp " . number_format($r['harga'], 0, ',', '.') . "</td>
        <td>{$r['stok']}</td>
        <td>
            <a href='barang_edit.php?id={$r['id']}'>Edit</a> | 
            <a href='barang_hapus.php?id={$r['id']}' onclick='return confirm(\"Yakin hapus barang ini?\")'>Hapus</a>
        </td>
    </tr>";
}
?>
</table>

<br>
<a href="transaksi_list.php">← Kembali ke Transaksi</a>
