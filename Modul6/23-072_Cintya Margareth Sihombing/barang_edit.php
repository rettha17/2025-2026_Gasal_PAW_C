<?php
include "koneksi.php";

$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM barang WHERE id='$id'");
$r = mysqli_fetch_assoc($q);
?>

<h2>Edit Barang</h2>

<form action="" method="post">
    <label>Nama Barang:</label><br>
    <input type="text" name="nama_barang" value="<?= $r['nama_barang'] ?>" required><br><br>

    <label>Harga:</label><br>
    <input type="number" name="harga" min="0" value="<?= $r['harga'] ?>" required><br><br>

    <input type="submit" name="update" value="Update">
</form>

<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];

    mysqli_query($koneksi, "UPDATE barang SET nama_barang='$nama', harga='$harga' WHERE id='$id'");
    echo "<script>alert('Barang berhasil diupdate'); window.location='barang_list.php';</script>";
}
?>
