<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
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

    // Query untuk mengambil data material
    $query_material = "SELECT id_material, material_name FROM material";
    $result_material = mysqli_query($kon, $query_material);

    // Cek apakah ada nilai id_barang yang dikirimkan dengan metode GET
    if (isset($_GET['id_barang'])) {
        $id_barang = input($_GET["id_barang"]);
        $sql = "SELECT * FROM barang WHERE id_barang = $id_barang";
        $result = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($result);
    }

    // Cek apakah ada kiriman form dari metode POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_barang = htmlspecialchars($_POST["id_barang"]);
        $nama_barang = input($_POST["nama_barang"]);
        $harga = input($_POST["harga"]);
        $stok = input($_POST["stok"]);
        $id_material = input($_POST["id_material"]);
        $harga_modal = input($_POST["harga_modal"]);

        // Query untuk update data pada tabel barang
        $sql = "UPDATE barang SET
                nama_barang = '$nama_barang',
                harga = '$harga',
                stok = '$stok',
                id_material = '$id_material',
                harga_modal = '$harga_modal'
                WHERE id_barang = $id_barang";

        // Menjalankan query update
        $hasil = mysqli_query($kon, $sql);

        // Menangani hasil eksekusi query
        if ($hasil) {
            header("Location: modal.php"); // Redirect setelah berhasil
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
    }
    ?>

    <h2>Update Data</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>" required />
        </div>

        <div class="form-group">
            <label>Harga Jual</label>
            <input type="text" name="harga" class="form-control" value="<?= $data['harga'] ?>" required />
        </div>

        <div class="form-group">
            <label>Harga Modal</label>
            <input type="text" name="harga_modal" class="form-control" value="<?= $data['harga_modal'] ?>" required />
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="text" name="stok" class="form-control" value="<?= $data['stok'] ?>" required />
        </div>

        <div class="form-group">
            <label>Material</label>
            <select name="id_material" class="form-control" required>
                <option value="">-- Pilih Material --</option>
                <?php
                // Looping untuk membuat dropdown
                if (mysqli_num_rows($result_material) > 0) {
                    while ($row = mysqli_fetch_assoc($result_material)) {
                        $selected = ($row['id_material'] == $data['id_material']) ? 'selected' : '';
                        echo "<option value='" . $row['id_material'] . "' $selected>" . $row['material_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada data material</option>";
                }
                ?>
            </select>
        </div>

        <input type="hidden" name="id_barang" value="<?= $data['id_barang']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
