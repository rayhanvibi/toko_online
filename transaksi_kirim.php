<?php include "header.php"; ?>

<?php  
// Cek login
if (empty($_SESSION['pelanggan'])){
    echo "<script>alert('Anda Harus Login')</script>";
    echo "<script>location='index.php'</script>";
    exit();
}

// ambil id_pelanggan
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// ambil transaksi yang sedang dalam proses pengiriman
$ambilTransaksi = $koneksi->query("
    SELECT t.*, b.status_bayar, k.status_kirim
    FROM transaksi t
    JOIN bayar b ON t.id_transaksi = b.id_transaksi
    JOIN kirim k ON t.id_transaksi = k.id_transaksi
    WHERE 
        t.id_pelanggan = '$id_pelanggan'
        AND b.status_bayar = 'sukses'
        AND t.status_transaksi = 'sukses'
        AND k.status_kirim = 'proses'
    ORDER BY t.id_transaksi DESC
");
?>

<section class="container my-3">

    <h4 class="mb-3">Status Pengiriman</h4>

    <?php if ($ambilTransaksi->num_rows == 0): ?>
        <div class="alert alert-info">Tidak ada pesanan yang sedang dikirim.</div>
    <?php endif; ?>

    <?php while($transaksi = $ambilTransaksi->fetch_assoc()): ?>

        <?php  
            $id_transaksi = $transaksi['id_transaksi'];

            // Ambil produk yang dibeli
            $ambilProduk = $koneksi->query("
                SELECT tp.*, p.nama_produk, p.foto_produk
                FROM transaksi_produk tp
                JOIN produk p ON tp.id_produk = p.id_produk
                WHERE tp.id_transaksi = '$id_transaksi'
            ");
        ?>

        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <!-- Baris 1 : ID + STATUS -->
                <div class="d-flex justify-content-between">
                    <h6 class="mb-1">ID Transaksi: <b>#<?php echo $id_transaksi; ?></b></h6>

                    <!-- Badge pengiriman -->
                    <span class="badge bg-primary">Sedang Diproses</span>
                </div>

                <small class="text-muted">Tanggal: <?php echo $transaksi['tanggal_transaksi']; ?></small>
                <br>
                <small class="text-muted">Status Bayar: <b class="text-success">Sukses</b></small>
                <br>
                <small class="text-muted">Status Transaksi: <b class="text-success">Sukses</b></small>

                <hr class="my-2">

                <!-- Produk -->
                <?php 
                $total = 0; 
                while($produk = $ambilProduk->fetch_assoc()):
                    $sub = $produk['harga'] * $produk['jumlah'];
                    $total += $sub;
                ?>
                    <div class="d-flex mb-2">

                        <img src="assets/img/<?php echo $produk['foto_produk']; ?>" 
                             style="width:70px; height:70px; object-fit:cover; border-radius:8px;"
                             class="me-3">

                        <div>
                            <b><?php echo $produk['nama_produk']; ?></b><br>
                            <small>Jumlah: <?php echo $produk['jumlah']; ?></small><br>
                            <small>Subtotal: Rp<?php echo number_format($sub); ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>

                <hr class="my-2">

                <!-- Total & Tombol -->
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Total Pembelian: <b>Rp<?php echo number_format($total); ?></b></h6>

                    <a href="transaksi_detail.php?id_transaksi=<?php echo $id_transaksi; ?>" 
                       class="btn btn-primary btn-sm">
                        Detail
                    </a>
                </div>

            </div>
        </div>

    <?php endwhile; ?>

</section>

<?php include "footer.php"; ?>
