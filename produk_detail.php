<?php include "header.php"; ?>

<?php 
// Pastikan parameter id tersedia
if (!isset($_GET['id'])) {
    echo "<script>alert('Produk tidak ditemukan!'); location='produk.php';</script>";
    exit();
}

$id_produk = $_GET['id'];

// Ambil data produk
$produk = $koneksi->query("
    SELECT produk.*, kategori.nama_kategori 
    FROM produk 
    LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori
    WHERE id_produk='$id_produk'
")->fetch_assoc();

// Jika produk tidak ditemukan
if (!$produk) {
    echo "<script>alert('Produk tidak tersedia!'); location='produk.php';</script>";
    exit();
}
?>

<div class="container mt-4">

    <div class="row">

        <!-- FOTO PRODUK -->
        <div class="col-md-5 col-12 mb-3">
            <div class="card shadow-sm">
                <?php if (!empty($produk['foto_produk'])): ?>
                    <img src="assets/img/<?php echo $produk['foto_produk']; ?>" 
                         class="card-img-top" 
                         style="max-height:350px; object-fit:cover;">
                <?php else: ?>
                    <div class="text-center p-5 text-muted">Tidak ada foto</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- DETAIL PRODUK -->
        <div class="col-md-7 col-12">
            <h3><?php echo $produk['nama_produk']; ?></h3>

            <p class="text-muted mb-1">
                Kategori: <?php echo $produk['nama_kategori']; ?>
            </p>

            <h4 class="text-primary">
                Rp<?php echo number_format($produk['harga_produk']); ?>
            </h4>

            <p>
                Stok: 
                <span class="<?php echo ($produk['stok_produk'] > 0 ? 'text-success' : 'text-danger'); ?>">
                    <?php echo $produk['stok_produk']; ?>
                </span>
            </p>

            <p class="mt-3">
                <?php echo nl2br($produk['deskripsi_produk']); ?>
            </p>

            <div class="mt-4 d-flex gap-2">

                <!-- tombol beli -->
                <a href="transaksi_beli.php?id=<?php echo $produk['id_produk']; ?>" 
                   class="btn btn-warning w-50">
                    Beli
                </a>

                <!-- tombol keranjang -->
                <a href="keranjang_tambah.php?id=<?php echo $produk['id_produk']; ?>"
                   onclick="return confirm('Tambahkan ke keranjang?')"
                   class="btn btn-primary w-50">
                    + Keranjang
                </a>

            </div>
        </div>
    </div>

</div>

<?php include "footer.php"; ?>
