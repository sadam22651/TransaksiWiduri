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
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-warning">
      <div class="container-fluid">
        <a class="navbar-brand" href="home.php">WIDURIWEB</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
    <a href="create_transaksi.php" class="btn btn-primary" role="button">TRANSAKSI</a>

    <?php

    // Include koneksi ke database
    include "koneksi.php";

    // Cek apakah ada kiriman form dari method GET untuk menghapus transaksi
    if (isset($_GET['id_transaksi'])) {
      $id_transaksi = htmlspecialchars($_GET["id_transaksi"]);

      $sql = "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'";
      $hasil = mysqli_query($kon, $sql);

      // Kondisi apakah berhasil atau tidak
      if ($hasil) {
        header("Location:transaksi.php");
      } else {
        echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
      }
    }

    // Mengambil tanggal hari ini
    $tanggal_today = date("Y-m-d");

    // Query SQL untuk mengambil data transaksi hari ini
    $sql = "
        SELECT transaksi.*, barang.nama_barang, pekerja.nama_pekerja 
        FROM transaksi 
        JOIN barang ON transaksi.id_barang = barang.id_barang 
        JOIN pekerja ON transaksi.id_pekerja = pekerja.id_pekerja 
        WHERE transaksi.tanggal = '$tanggal_today' 
        ORDER BY transaksi.id_transaksi DESC
    ";
    ?>

    <!-- Tabel untuk menampilkan transaksi hari ini -->
    <table class="my-3 table table-bordered">
      <thead>
        <tr class="table-primary">
          <th>No</th>
          <th>Nama Pelanggan</th>
          <th>Nama Pekerja</th>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Tanggal</th>
          <th>Total Harga</th>
          <th colspan='2'>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $hasil = mysqli_query($kon, $sql);
        $no = 0;
        while ($data = mysqli_fetch_array($hasil)) {
          $no++;
          ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data["nama_pelanggan"]; ?></td>
            <td><?php echo $data["nama_pekerja"]; ?></td>
            <td><?php echo $data["nama_barang"]; ?></td>
            <td><?php echo $data["jumlah"]; ?></td>
            <td><?php echo $data["tanggal"]; ?></td>
            <td><?php echo $data["harga_total"]; ?></td>
            <td>
              <a href="update_transaksi.php?id_transaksi=<?php echo htmlspecialchars($data['id_transaksi']); ?>"
                class="btn btn-warning" role="button">Update</a>
              <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_transaksi=<?php echo $data['id_transaksi']; ?>"
                class="btn btn-danger" role="button">Delete</a>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>