<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Modal</title>
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

    <table class="my-3 table table-bordered">
      <thead>
        <tr class="table-primary">
          <th>No</th>
          <th>Nama Barang</th>
          <th>Stok</th>
          <th>Harga Modal</th>
          <th>Total Modal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include "koneksi.php";

        // Query untuk mendapatkan data barang
        $sql = "SELECT nama_barang, stok, harga_modal FROM barang";
        $hasil = mysqli_query($kon, $sql);

        $no = 0;
        $total_semua_modal = 0;

        while ($data = mysqli_fetch_array($hasil)) {
          $no++;
          $total_modal = $data['stok'] * $data['harga_modal'];
          $total_semua_modal += $total_modal;
          ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data['nama_barang']; ?></td>
            <td><?php echo $data['stok']; ?></td>
            <td><?php echo number_format($data['harga_modal'], 2, ',', '.'); ?></td>
            <td><?php echo number_format($total_modal, 2, ',', '.'); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <!-- Total Harga Modal -->
    <div class="alert alert-info">
      <h5>Total Harga Modal Keseluruhan: Rp <?php echo number_format($total_semua_modal, 2, ',', '.'); ?></h5>
    </div>

    <!-- Tombol Kembali -->
    <div class="my-4">
      <a href="modal.php" class="btn btn-primary">Kembali</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>
