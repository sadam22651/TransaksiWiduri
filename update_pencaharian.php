<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update pencaharian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php
    // Include file koneksi untuk menghubungkan ke database
    include "koneksi.php";

    // Fungsi untuk membersihkan input
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Mengambil ID transaksi dari URL
    if (isset($_GET['id_transaksi'])) {
        $id_transaksi = input($_GET['id_transaksi']);
        $sql = "SELECT * FROM transaksi WHERE id_transaksi = $id_transaksi";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($hasil);
    }

    // Query untuk mengambil data pekerja dan barang
    $queryPekerja = "SELECT id_pekerja, nama_pekerja FROM pekerja";
    $resultPekerja = mysqli_query($kon, $queryPekerja);

    $queryBarang = "SELECT id_barang, nama_barang FROM barang";
    $resultBarang = mysqli_query($kon, $queryBarang);

    // Proses jika form disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_transaksi = htmlspecialchars($_POST["id_transaksi"]);
        $nama_pelanggan = input($_POST["nama_pelanggan"]);
        $id_pekerja = input($_POST["id_pekerja"]);
        $id_barang = input($_POST["id_barang"]);
        $jumlah = input($_POST["jumlah"]);
        $tanggal = input($_POST["tanggal"]); // Ambil tanggal dari input

        // Query untuk update data transaksi termasuk tanggal
        $sql = "UPDATE transaksi SET 
                nama_pelanggan = '$nama_pelanggan', 
                id_pekerja = '$id_pekerja', 
                id_barang = '$id_barang', 
                jumlah = '$jumlah', 
                tanggal = '$tanggal' 
                WHERE id_transaksi = $id_transaksi";

        // Mengeksekusi query
        $hasil = mysqli_query($kon, $sql);

        // Cek apakah query berhasil
        if ($hasil) {
            header("Location: pencaharian.php"); // Redirect setelah berhasil
        } else {
            echo "<div class='alert alert-danger'>Data Gagal Disimpan.</div>";
        }
    }
    ?>

    <h2>Update Data pencaharian</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="<?php echo $data['nama_pelanggan']; ?>" required />
        </div>

        <div class="form-group">
            <label>Pekerja:</label>
            <select name="id_pekerja" class="form-control" required>
                <option value="">-- Pilih Pekerja --</option>
                <?php while ($row = mysqli_fetch_assoc($resultPekerja)) {
                    // Menandai pekerja yang dipilih
                    $selected = ($row['id_pekerja'] == $data['id_pekerja']) ? 'selected' : '';
                    echo "<option value='" . $row['id_pekerja'] . "' $selected>" . $row['nama_pekerja'] . "</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Barang:</label>
            <select name="id_barang" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($row = mysqli_fetch_assoc($resultBarang)) {
                    // Menandai barang yang dipilih
                    $selected = ($row['id_barang'] == $data['id_barang']) ? 'selected' : '';
                    echo "<option value='" . $row['id_barang'] . "' $selected>" . $row['nama_barang'] . "</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah:</label>
            <input type="text" name="jumlah" class="form-control" value="<?php echo $data['jumlah']; ?>" required />
        </div>

        <div class="form-group">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo $data['tanggal']; ?>" required />
        </div>

        <input type="hidden" name="id_transaksi" value="<?php echo $data['id_transaksi']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>

    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
