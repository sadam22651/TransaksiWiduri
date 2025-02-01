<?php
session_start();

// Include file koneksi ke database
include "koneksi.php";

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password langsung
    $sql = "SELECT * FROM login WHERE username = ? AND password = ?";
    $stmt = $kon->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

// Logout jika diminta
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: ?page=login");
    exit();
}

// Menentukan halaman yang akan ditampilkan
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Tampilkan halaman sesuai kondisi
if ($page === 'home' && isset($_SESSION['username'])) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h1>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <a href="?action=logout" class="btn btn-danger mt-3">Logout</a>
        </div>
    </body>
    </html>
    <?php
} else {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 bg-warning" style="width: 22rem;">
            <h2 class="text-center">Login</h2>
            <?php if (isset($error)) { echo "<div class='alert alert-danger' role='alert'>$error</div>"; } ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
}
?>
