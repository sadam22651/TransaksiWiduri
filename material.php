<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div>
 <!-- navbar -->
 <nav class="navbar navbar-expand-lg bg-warning">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php">WIDURIWEB</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="transaksi.php">Transaksi</a> 
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="modal.php">Modal</a> 
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="material.php">Material</a> 
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="pekerja.php">Pekerja</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="pencaharian.php">Pencaharian</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="laporan.php">Laporan</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- end navbar -->
<a href="create_material.php" class="btn btn-primary" role="button">Tambah Material</a>

<?php
    include "koneksi.php";

    // Cek apakah ada kiriman form dari method GET untuk menghapus material
    if (isset($_GET['id_material'])) {
        $id_material = htmlspecialchars($_GET["id_material"]);
        $sql = "DELETE FROM material WHERE id_material = '$id_material'";
        $hasil = mysqli_query($kon, $sql);

        if ($hasil) {
            header("Location: material.php");
        } else {
            echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
        }
    }
?>

<table class="my-3 table table-bordered">
    <thead>
        <tr class="table-primary">
            <th>No</th>
            <th>Material Name</th>
            <th>Description</th>
            <th colspan="2">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        // Query untuk mengambil data material
        $sql = "SELECT * FROM material ORDER BY id_material DESC";
        $hasil = mysqli_query($kon, $sql);
        $no = 0;

        while ($data = mysqli_fetch_array($hasil)) {
            $no++;
        ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data["material_name"]; ?></td>
                <td><?php echo $data["description"]; ?></td>
                <td>
                    <a href="update_material.php?id_material=<?php echo htmlspecialchars($data['id_material']); ?>" class="btn btn-warning" role="button">Update</a>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_material=<?php echo $data['id_material']; ?>" class="btn btn-danger" role="button">Delete</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
