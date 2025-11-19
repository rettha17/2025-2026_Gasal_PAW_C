<?php
include "koneksi.php";

if (!isset($_POST['simpan'])) {
?>
    <h2>Tambah Transaksi</h2>
    <form method="post">
        <label>Tanggal Transaksi:</label><br>
        <input type="date" name="tanggal" required><br><br>
        <input type="submit" name="simpan" value="Simpan">
    </form>
<?php
} else {
    $tanggal = $_POST['tanggal'];

    // Reset auto increment kalau tabel kosong
    $cek = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM transaksi");
    $d = mysqli_fetch_assoc($cek);
    if ($d['jml'] == 0) {
        mysqli_query($koneksi, "ALTER TABLE transaksi AUTO_INCREMENT = 1");
    }

    // Tambahkan transaksi baru
    mysqli_query($koneksi, "INSERT INTO transaksi (tanggal, total) VALUES ('$tanggal', 0)");

    // Ambil ID terakhir
    $id_baru = mysqli_insert_id($koneksi);

    // Redirect ke halaman detail
    header("Location: transaksi_detail.php?id=$id_baru");
    exit;
}
?>
