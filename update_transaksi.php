<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaksi</title>
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

    // Mengambil ID transaksi dari URL (misalnya: transaksi.php?id_transaksi=1)
    if (isset($_GET['id_transaksi'])) {
        $id_transaksi = $_GET['id_transaksi'];

        // Query untuk mengambil data transaksi berdasarkan id_transaksi
        $queryTransaksi = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
        $resultTransaksi = mysqli_query($kon, $queryTransaksi);
        $dataTransaksi = mysqli_fetch_assoc($resultTransaksi);

        // Query untuk mengambil data pekerja
        $queryPekerja = "SELECT id_pekerja, nama_pekerja FROM pekerja";
        $resultPekerja = mysqli_query($kon, $queryPekerja);

        // Query untuk mengambil data barang
        $queryBarang = "SELECT id_barang, nama_barang FROM barang";
        $resultBarang = mysqli_query($kon, $queryBarang);
    }

    // Cek apakah ada kiriman form dari method POST untuk update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_transaksi = input($_POST["id_transaksi"]);
        $nama_pelanggan = input($_POST["nama_pelanggan"]);
        $id_pekerja = input($_POST["id_pekerja"]);
        $id_barang = input($_POST["id_barang"]);
        $jumlah = input($_POST["jumlah"]);
        $tanggal = input($_POST["tanggal"]);
        
        // Query untuk update data transaksi
        $sql = "UPDATE transaksi SET nama_pelanggan = '$nama_pelanggan', id_pekerja = '$id_pekerja', id_barang = '$id_barang', jumlah = '$jumlah', tanggal = '$tanggal' WHERE id_transaksi = '$id_transaksi'";

        // Mengeksekusi query
        $hasil = mysqli_query($kon, $sql);

        // Mengecek apakah query berhasil atau gagal
        if ($hasil) {
            header("Location: transaksi.php");
        } else {
            echo "<div class='alert alert-danger'> Data Gagal diperbarui.</div>";
        }
    }
    ?>

    <h2>Update Data Transaksi</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="hidden" name="id_transaksi" value="<?php echo $dataTransaksi['id_transaksi']; ?>" />
        
        <div class="form-group">
            <label>Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="<?php echo $dataTransaksi['nama_pelanggan']; ?>" required />
        </div>

        <div class="form-group">
            <label>Pekerja:</label>
            <select name="id_pekerja" class="form-control" required>
                <option value="">-- Pilih Pekerja --</option>
                <?php while ($row = mysqli_fetch_assoc($resultPekerja)) {
                    // Menandai pekerja yang sudah dipilih
                    $selected = ($row['id_pekerja'] == $dataTransaksi['id_pekerja']) ? 'selected' : '';
                    echo "<option value='" . $row['id_pekerja'] . "' $selected>" . $row['nama_pekerja'] . "</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Barang:</label>
            <select name="id_barang" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($row = mysqli_fetch_assoc($resultBarang)) {
                    // Menandai barang yang sudah dipilih
                    $selected = ($row['id_barang'] == $dataTransaksi['id_barang']) ? 'selected' : '';
                    echo "<option value='" . $row['id_barang'] . "' $selected>" . $row['nama_barang'] . "</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah:</label>
            <input type="text" name="jumlah" class="form-control" value="<?php echo $dataTransaksi['jumlah']; ?>" required />
        </div>

        <div class="form-group">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo $dataTransaksi['tanggal']; ?>" required />
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
