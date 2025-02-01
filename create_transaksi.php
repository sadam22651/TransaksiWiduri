<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php
    // Include file koneksi, untuk menghubungkan ke database
    include "koneksi.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Query untuk mengambil data pekerja
    $queryPekerja = "SELECT id_pekerja, nama_pekerja FROM pekerja";
    $resultPekerja = mysqli_query($kon, $queryPekerja);

    // Query untuk mengambil data barang
    $queryBarang = "SELECT id_barang, nama_barang FROM barang";
    $resultBarang = mysqli_query($kon, $queryBarang);

    // Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Mengambil data dari form dan membersihkan input
        $nama_pelanggan = input($_POST["nama_pelanggan"]);
        $id_pekerja = input($_POST["id_pekerja"]);
        $id_barang = input($_POST["id_barang"]);
        $jumlah = input($_POST["jumlah"]);
        $tanggal = input($_POST["tanggal"]); // Mengambil tanggal yang dimasukkan oleh user
        
        // Query input untuk memasukkan data ke dalam tabel transaksi
        $sql = "INSERT INTO transaksi (nama_pelanggan, id_pekerja, id_barang, jumlah, tanggal) 
                VALUES ('$nama_pelanggan', '$id_pekerja', '$id_barang', '$jumlah', '$tanggal')";

        // Mengeksekusi query
        $hasil = mysqli_query($kon, $sql);

        // Mengecek apakah query berhasil atau gagal
        if ($hasil) {
            header("Location: transaksi.php");
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
    }
    ?>

    <h2>Input Data Transaksi</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        
        <div class="form-group">
            <label>Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama" required />
        </div>

        <div class="form-group">
            <label>Pekerja:</label>
            <select name="id_pekerja" class="form-control" required>
                <option value="">-- Pilih Pekerja --</option>
                <?php while ($row = mysqli_fetch_assoc($resultPekerja)) {
                    echo "<option value='" . $row['id_pekerja'] . "'>" . $row['nama_pekerja'] . "</option>";
                } ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Barang:</label>
            <select name="id_barang" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($row = mysqli_fetch_assoc($resultBarang)) {
                    echo "<option value='" . $row['id_barang'] . "'>" . $row['nama_barang'] . "</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah:</label>
            <input type="text" name="jumlah" class="form-control" placeholder="Masukkan jumlah" required />
        </div>

        <div class="form-group">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" required />
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
