<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
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

<form method="GET" action="laporan.php">
  <label for="">Nama Pelanggan:</label>
  <input type="text" name="cari" value="<?php if (isset($_GET['cari'])) echo $_GET['cari']; ?>">

  <label for="">Tanggal Mulai:</label>
  <input type="date" name="tanggal_mulai" value="<?php if (isset($_GET['tanggal_mulai'])) echo $_GET['tanggal_mulai']; ?>">

  <label for="">Tanggal Selesai:</label>
  <input type="date" name="tanggal_selesai" value="<?php if (isset($_GET['tanggal_selesai'])) echo $_GET['tanggal_selesai']; ?>">

  <button type="submit">Cari</button>
</form>

<?php
// Query utama dengan join
if (isset($_GET['cari']) || isset($_GET['tanggal_mulai']) || isset($_GET['tanggal_selesai'])) {
    $pencaharian = isset($_GET['cari']) ? $_GET['cari'] : '';
    $tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
    $tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

    // Menyusun query berdasarkan inputan
    $query = "
        SELECT t.*, b.nama_barang, b.harga_modal, p.nama_pekerja 
        FROM transaksi t
        JOIN barang b ON t.id_barang = b.id_barang
        JOIN pekerja p ON t.id_pekerja = p.id_pekerja
        WHERE t.nama_pelanggan LIKE '%$pencaharian%'
    ";

    // Menambahkan filter tanggal jika diisi
    if ($tanggal_mulai && $tanggal_selesai) {
        $query .= " AND t.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
    } elseif ($tanggal_mulai) {
        $query .= " AND t.tanggal >= '$tanggal_mulai'";
    } elseif ($tanggal_selesai) {
        $query .= " AND t.tanggal <= '$tanggal_selesai'";
    }
} else {
    // Query default jika tidak ada pencarian
    $query = "
        SELECT t.*, b.nama_barang, b.harga_modal, p.nama_pekerja 
        FROM transaksi t
        JOIN barang b ON t.id_barang = b.id_barang
        JOIN pekerja p ON t.id_pekerja = p.id_pekerja
    ";
}

$hasil = mysqli_query($kon, $query);
$no = 0;

// Variabel untuk menghitung total keuntungan
$total_keuntungan_kotor = 0;
$total_keuntungan_bersih = 0;
?>

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
            <th>Keuntungan Bersih</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($data = mysqli_fetch_array($hasil)) : 
        $no++; 

        // Menghitung keuntungan kotor (total harga ditambahkan semua)
        $total_keuntungan_kotor += $data['harga_total'];

        // Menghitung keuntungan bersih
        $keuntungan_bersih = $data['harga_total'] - ($data['harga_modal'] * $data['jumlah']);
        $total_keuntungan_bersih += $keuntungan_bersih;
    ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data["nama_pelanggan"]; ?></td>
            <td><?php echo $data["nama_pekerja"]; ?></td>
            <td><?php echo $data["nama_barang"]; ?></td>
            <td><?php echo $data["jumlah"]; ?></td>
            <td><?php echo $data["tanggal"]; ?></td>
            <td><?php echo $data["harga_total"]; ?></td>
            <td><?php echo $keuntungan_bersih; ?></td> <!-- Keuntungan Bersih -->
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<!-- Menampilkan Total Keuntungan Kotor dan Bersih -->
<div class="my-4 p-4 bg-light border rounded" style="width: 25%; margin-left: 0;">
    <div class="alert alert-success" role="alert">
        <h6 class="mb-0">Total Keuntungan Kotor: </h6>
        <p class="fs-7"><?php echo number_format($total_keuntungan_kotor, 2, ',', '.'); ?></p>
    </div>
    <div class="alert alert-primary" role="alert">
        <h6 class="mb-0">Total Keuntungan Bersih: </h6>
        <p class="fs-7"><?php echo number_format($total_keuntungan_bersih, 2, ',', '.'); ?></p>
    </div>
</div>

<!-- Tombol Cetak -->
<button id="btnPrint" class="btn btn-primary">Cetak Laporan</button>

<script>
    // Tambahkan event listener ke tombol
    document.getElementById('btnPrint').addEventListener('click', function () {
        window.print(); // Memanggil dialog cetak
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
