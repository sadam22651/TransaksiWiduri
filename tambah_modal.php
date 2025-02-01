<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php
    include "koneksi.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Cek apakah ada nilai id_barang yang dikirimkan dengan metode GET
    if (isset($_GET['id_barang'])) {
        $id_barang = input($_GET['id_barang']);
        $sql = "SELECT stok, nama_barang FROM barang WHERE id_barang = $id_barang";
        $result = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($result);
    }

    // Cek apakah ada kiriman form dari metode POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_barang = htmlspecialchars($_POST['id_barang']);
        $stok_tambah = input($_POST['stok_tambah']);

        // Query untuk menambahkan stok ke stok lama
        $sql_update = "UPDATE barang SET stok = stok + $stok_tambah WHERE id_barang = $id_barang";
        $hasil = mysqli_query($kon, $sql_update);

        // Menangani hasil eksekusi query
        if ($hasil) {
            header("Location: modal.php"); // Redirect setelah berhasil
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
    }
    ?>

    <h2>Tambah Stok</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" class="form-control" value="<?= $data['nama_barang'] ?>" disabled />
        </div>

        <div class="form-group">
            <label>Stok Saat Ini</label>
            <input type="text" class="form-control" value="<?= $data['stok'] ?>" disabled />
        </div>

        <div class="form-group">
            <label>Tambah Stok</label>
            <input type="number" name="stok_tambah" class="form-control" required />
        </div>

        <input type="hidden" name="id_barang" value="<?= $id_barang; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
