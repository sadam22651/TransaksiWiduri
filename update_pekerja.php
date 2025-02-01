<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>halaman utama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>



<div class="container">
    <?php

    //Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id
    if (isset($_GET['id_pekerja'])) {
        $id_pekerja=input($_GET["id_pekerja"]);
        $sql="select * from pekerja where id_pekerja=$id_pekerja";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_assoc($hasil);


    }

    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_pekerja=htmlspecialchars($_POST["id_pekerja"]);
        $nama_pekerja=input($_POST["nama_pekerja"]);
        $alamat=input($_POST["alamat"]);
        
        
        

        //Query update data pada tabel anggota
        $sql="update pekerja set
			nama_pekerja='$nama_pekerja',
            alamat='$alamat'
			where id_pekerja=$id_pekerja";

        //Mengeksekusi atau menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:pekerja.php");
        }
        else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";

        }

    }

    ?>
    <h2>Update Data</h2>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        
        <div class="form-group">
            <label>nama pekerja:</label>
            <input type="text" name="nama_pekerja" class="form-control" value="<?=$data["nama_pekerja"]?>" required/>
        </div>
        
        <div class="form-group">
            <label>alamat:</label>
            <input type="text" name="alamat" class="form-control" value="<?=$data["alamat"]?>" required/>
        </div>

        

        <input type="hidden" name="id_pekerja" value="<?php echo $data['id_pekerja']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

