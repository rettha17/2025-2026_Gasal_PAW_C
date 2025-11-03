<?php
include "config.php";

// Cek apakah ada ID di URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id='$id'");
$row = mysqli_fetch_array($data);

// Jika data tidak ditemukan
if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// UPDATE DATA
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id='$id'");

    if ($query) {
        echo "<script>alert('Data berhasil diupdate'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card col-md-6 mx-auto">
        <div class="card-header bg-warning text-white">
            <h4>Edit Data Master Supplier</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" value="<?= $row['nama']; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Telp</label>
                    <input type="text" name="telp" value="<?= $row['telp']; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="<?= $row['alamat']; ?>" class="form-control" required>
                </div>

                <button type="submit" name="update" class="btn btn-warning">Update</button>
                <a href="index.php" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
