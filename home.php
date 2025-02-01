<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>halaman utama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="bg-light" >
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
<!-- body -->
    <div class="row text-center align-items-center mt-4 ">
      <div class="col-12">
        <img src="assets/pic1.png" width="150" height="150" />
        <h2 class="mt-2">✨TRANSAKSI WIDURI✨</h2>
        <i>Berpengalaman lebih dari <span style="color:coral">20th</span> di bidangnya</i>
      </div>
    </div>
    <!-- bagian bawah -->
    <div class="row text-dark mt-4">
      <div class="col-sm-4 g-4 p-4 ">
        <div class="card bg-warning">
          <div class="card-body">
            <h5 class="card-title text-center">Asah Akik</h5>
            <img src="assets/gambar1.png" class="object-fit-contain rounded mx-auto d-block" alt="..." height="180">
            <p class="card-text">Kami menyediakan jasa asah akik yang mulus dan harga yang bersahabat</p>
          </div>
        </div>
      </div>
      <div class="col-sm-4 g-4 p-4">
        <div class="card bg-warning">
          <div class="card-body">
            <h5 class="card-title text-center">Kalung Nama</h5>
            <img src="assets/gambar2.png" class="object-fit-contain rounded mx-auto d-block" alt="..." height="180">
            <p class="card-text">Kami menyediakan jasa asah buat kalung nama yang  tahan lama</p>
          </div>
        </div>
      </div>
      <div class="col-sm-4 g-4 p-4">
        <div class="card bg-warning">
          <div class="card-body">
            <h5 class="card-title text-center">Cincin Nikah</h5>
            <img src="assets/gambar3.png" class="object-fit-contain rounded mx-auto d-block" alt="..." height="180">
            <p class="card-text">Kami menyediakan jasa asah buat cincin nikah yang  simple tapi berkesan</p>
          </div>
        </div>
      </div>
    </div>
    
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

