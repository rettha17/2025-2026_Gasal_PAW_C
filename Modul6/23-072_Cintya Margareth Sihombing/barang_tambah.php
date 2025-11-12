<?php include "koneksi.php"; ?>

<h2>Tambah Barang</h2>

<form action="" method="post">
    <label>Nama Barang:</label><br>
    <input type="text" name="nama_barang" required><br><br>

    <label>Harga:</label><br>
    <input type="number" name="harga" min="0" required><br><br>

    <label>Stok:</label><br>
    <input type="number" name="stok" min="0" required><br><br>

    <input type="submit" name="simpan" value="Simpan">
</form>

<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Simpan ke database
    mysqli_query($koneksi, "INSERT INTO barang (nama_barang, harga, stok) VALUES ('$nama', '$harga', '$stok')");

    echo "<script>
        alert('Barang berhasil ditambah');
        window.location='barang_list.php';
    </script>";
}
?>
