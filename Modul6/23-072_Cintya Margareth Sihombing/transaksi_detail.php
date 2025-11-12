<?php
include "koneksi.php";
$id = $_GET['id'];

// Ambil data transaksi
$q = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id=$id");
$t = mysqli_fetch_assoc($q);

// Tambah detail barang kalau form disubmit
if (isset($_POST['tambah'])) {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga dari tabel barang
    $b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga FROM barang WHERE id=$barang_id"));
    $harga = $b['harga'];

    // Simpan ke tabel detail
    mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, barang_id, jumlah) VALUES ($id, $barang_id, $jumlah)");

    // Update total transaksi
    mysqli_query($koneksi, "
        UPDATE transaksi 
        SET total = (
            SELECT SUM(b.harga * d.jumlah)
            FROM detail_transaksi d
            JOIN barang b ON d.barang_id = b.id
            WHERE d.transaksi_id = $id
        )
        WHERE id = $id
    ");

    // Reload halaman biar tampil total terbaru
    header("Location: transaksi_detail.php?id=$id");
    exit;
}
?>

<h2>Detail Transaksi #<?= $t['id'] ?></h2>
Tanggal: <?= $t['tanggal'] ?><br>
Total: <b>Rp <?= number_format($t['total']) ?></b><br><br>

<form method="post">
    Pilih Barang:
    <select name="barang_id" required>
        <option value="">-- pilih barang --</option>
        <?php
        $barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang");
        while ($b = mysqli_fetch_assoc($barang)) {
            echo "<option value='{$b['id']}'>{$b['nama_barang']}</option>";
        }
        ?>
    </select>

    Jumlah: <input type="number" name="jumlah" min="1" required>
    <input type="submit" name="tambah" value="Tambah Barang">
</form>
<br>

<table border="1" cellpadding="5">
<tr>
    <th>No</th><th>Nama Barang</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th>
</tr>

<?php
$q = mysqli_query($koneksi, "
    SELECT d.*, b.nama_barang, b.harga 
    FROM detail_transaksi d 
    JOIN barang b ON d.barang_id=b.id 
    WHERE d.transaksi_id=$id
");

$no = 1;
$total = 0;
while ($r = mysqli_fetch_assoc($q)) {
    $sub = $r['harga'] * $r['jumlah'];
    $total += $sub;
    echo "<tr>
        <td>$no</td>
        <td>{$r['nama_barang']}</td>
        <td>Rp " . number_format($r['harga']) . "</td>
        <td>{$r['jumlah']}</td>
        <td>Rp " . number_format($sub) . "</td>
        <td><a href='detail_hapus.php?id={$r['id']}&transaksi_id=$id'>Hapus</a></td>
    </tr>";
    $no++;
}
?>
</table>

<br>
<a href="transaksi_list.php">← Kembali ke Transaksi</a>
