<?php
include "config.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menyimpan data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Supplier Baru</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card col-md-6 mx-auto">
        <div class="card-header bg-primary text-white">
            <h4>Tambah Data Master Supplier Baru</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Telp</label>
                    <input type="text" name="telp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                <a href="index.php" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
