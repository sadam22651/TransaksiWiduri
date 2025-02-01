<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <div>
    <!-- Navbar -->
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

    <!-- End Navbar -->

    <a href="create_modal.php" class="btn btn-primary my-3" role="button">BUAT MODAL</a>
    <a href="data_modal.php" class="btn btn-primary my-3" role="button">LIHAT DATA MODAL</a>

    <?php
    include "koneksi.php";

    // Hapus data jika id_barang dikirim melalui URL
    if (isset($_GET['id_barang'])) {
      $id_barang = htmlspecialchars($_GET["id_barang"]);
      $sql = "DELETE FROM barang WHERE id_barang='$id_barang'";
      $hasil = mysqli_query($kon, $sql);

      if ($hasil) {
        header("Location:modal.php");
      } else {
        echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
      }
    }
    ?>

    <thead>
      <table class="my-3 table table-bordered">
        <tr class="table-primary">
          <th>No</th>
          <th>Nama Barang</th>
          <th>Harga</th>
          <th>Harga Modal</th>
          <th>Stok</th>
          <th>Material</th>
          <th colspan="2">Aksi</th>
        </tr>
    </thead>

    <?php
    include "koneksi.php";

    // Query untuk mengambil data barang beserta material_name
    $sql = "
        SELECT b.id_barang, b.nama_barang, b.harga, b.harga_modal, b.stok, m.material_name 
        FROM barang b
        LEFT JOIN material m ON b.id_material = m.id_material
        ORDER BY b.id_barang DESC";

    $hasil = mysqli_query($kon, $sql);
    $no = 0;

    while ($data = mysqli_fetch_array($hasil)) {
      $no++;
      ?>
      <tbody>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $data["nama_barang"]; ?></td>
          <td><?php echo $data["harga"]; ?></td>
          <td><?php echo $data["harga_modal"]; ?></td>
          <td><?php echo $data["stok"]; ?></td>
          <td><?php echo $data["material_name"] ? $data["material_name"] : "Tidak Diketahui"; ?></td>
          <td>
            <a href="tambah_modal.php?id_barang=<?php echo htmlspecialchars($data['id_barang']); ?>"
              class="btn btn-success" role="button">Tambah</a>
            <a href="update_modal.php?id_barang=<?php echo htmlspecialchars($data['id_barang']); ?>"
              class="btn btn-warning" role="button">Update</a>
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_barang=<?php echo $data['id_barang']; ?>"
              class="btn btn-danger" role="button">Delete</a>

          </td>
        </tr>
      </tbody>
      <?php
    }
    ?>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>