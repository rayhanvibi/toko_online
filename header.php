	<?php include "koneksi.php"; ?>
  <!DOCTYPE html>
  <html>
  <head>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <title></title>
  </head>
  <body>

    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-primary bg-primary">
      <div class="container">
        <a class="navbar-brand text-white " href="index.php">Toko Vibi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-white active" aria-current="page" href="index.php"> <i class="bi bi-house"></i> Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="kategori.php"><i class="bi bi-tags"></i> Kategori</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="produk.php"><i class="bi bi-box"></i> Produk</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="keranjang.php"><i class="bi bi-people"></i> Keranjang</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-cash"></i> Transaksi
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="transaksi_bayar.php">Transaksi Pembayaran</a></li>
                <li><a class="dropdown-item" href="transaksi_kirim.php">Pengiriman </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="transaksi_selesai.php">Selesai</a></li>
                <li><a class="dropdown-item" href="transaksi_gagal.php">Gagal</a></li>
              </ul>

              <?php if (empty($_SESSION['pelanggan'])): ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="daftar.php"><i class="bi bi-person-circle"></i> Daftar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="login.php"><i class="bi bi-person-circle"></i> Login</a>
              </li>
              <?php else: ?>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="akun.php"><i class="bi bi-person-circle"></i> Akun</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="logout.php"><i class="bi bi-box-arrow-right"></i> Log Out</a>
              </li>
            <?php endif ?>
          </ul>

        </div>
      </div>
    </nav>