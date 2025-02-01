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
    // Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Query untuk mengambil data material
    $query_material = "SELECT id_material, material_name FROM material";
    $result_material = mysqli_query($kon, $query_material);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_barang = input($_POST["nama_barang"]);
        $harga = input($_POST["harga"]);
        $stok = input($_POST["stok"]);
        $id_material = input($_POST["id_material"]);
        $harga_modal = input($_POST["harga_modal"]);

        // Query untuk menyimpan data ke tabel barang
        $sql = "INSERT INTO barang (nama_barang, harga, stok, id_material, harga_modal) VALUES
                ('$nama_barang', '$harga', '$stok', '$id_material', '$harga_modal')";
        $hasil = mysqli_query($kon, $sql);

        if ($hasil) {
            header("Location:modal.php");
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan: " . mysqli_error($kon) . "</div>";
        }
    }
    ?>
    <h2>Input Data</h2>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" placeholder="Masukan nama barang" required />
        </div>

        <div class="form-group">
            <label>Harga Jual</label>
            <input type="text" name="harga" class="form-control" placeholder="Masukan harga jual" required />
        </div>

        <div class="form-group">
            <label>Harga Modal</label>
            <input type="text" name="harga_modal" class="form-control" placeholder="Masukan harga modal" required />
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="text" name="stok" class="form-control" placeholder="Masukan stok" required />
        </div>

        <div class="form-group">
            <label>Material</label>
            <select name="id_material" class="form-control" required>
                <option value="">-- Pilih Material --</option>
                <?php
                // Looping untuk membuat dropdown
                if (mysqli_num_rows($result_material) > 0) {
                    while ($row = mysqli_fetch_assoc($result_material)) {
                        echo "<option value='" . $row['id_material'] . "'>" . $row['material_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada data material</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
