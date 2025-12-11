<?php include "header.php"; ?>

<?php  
// pastikan pelanggan sudah login
if (empty($_SESSION['pelanggan'])){
    echo "<script>alert('Anda Harus Login')</script>";
    echo "<script>location='index.php'</script>";
    exit();
}

// ambil id pelanggan
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// ambil transaksi milik pelanggan dengan status menunggu pembayaran / menunggu konfirmasi
$ambilTransaksi = $koneksi->query("
    SELECT * FROM transaksi 
    WHERE id_pelanggan='$id_pelanggan' 
    AND (status_transaksi='menunggu pembayaran' OR status_transaksi='menunggu konfirmasi')
    ORDER BY id_transaksi DESC
");
?>

<section class="container my-3">

    <h4 class="mb-3">Menunggu Pembayaran / Konfirmasi</h4>

    <?php if ($ambilTransaksi->num_rows == 0): ?>
        <div class="alert alert-info">Tidak ada transaksi yang perlu pembayaran atau konfirmasi.</div>
    <?php endif; ?>

    <?php while($transaksi = $ambilTransaksi->fetch_assoc()): ?>

        <?php  
        $id_transaksi = $transaksi['id_transaksi'];

        // Ambil produk yang dibeli dalam transaksi ini
        $ambilProduk = $koneksi->query("
            SELECT tp.*, p.nama_produk, p.foto_produk 
            FROM transaksi_produk tp
            JOIN produk p ON tp.id_produk = p.id_produk
            WHERE tp.id_transaksi='$id_transaksi'
        ");
        ?>

        <!-- CARD TRANSAKSI -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <!-- BARIS 1 : Nomor + Status -->
                <div class="d-flex justify-content-between">
                    <h6 class="mb-1">ID Transaksi: <b>#<?php echo $id_transaksi; ?></b></h6>

                    <!-- BADGE STATUS -->
                    <?php if ($transaksi['status_transaksi'] == 'menunggu pembayaran'): ?>
                        <span class="badge bg-danger">Menunggu Pembayaran</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                    <?php endif; ?>
                </div>

                <small class="text-muted">Tanggal: <?php echo $transaksi['tanggal_transaksi']; ?></small>

                <hr class="my-2">

                <!-- BARIS 2 : Daftar Produk -->
                <?php  
                $total_harga = 0;
                while($produk = $ambilProduk->fetch_assoc()):
                    $sub = $produk['harga'] * $produk['jumlah'];
                    $total_harga += $sub;
                ?>
                    <div class="d-flex mb-2">

                        <img src="assets/img/<?php echo $produk['foto_produk']; ?>" 
                             class="me-3" style="width:70px; height:70px; object-fit:cover; border-radius:8px;">

                        <div>
                            <b><?php echo $produk['nama_produk']; ?></b><br>
                            <small>Jumlah: <?php echo $produk['jumlah']; ?></small><br>
                            <small>Subtotal: Rp<?php echo number_format($sub); ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>

                <hr class="my-2">

                <!-- BARIS 3 : Total + Tombol -->
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Total : <b>Rp<?php echo number_format($total_harga); ?></b></h6>

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
