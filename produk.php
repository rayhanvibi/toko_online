<?php include "header.php"; ?>

<?php  
$produk = [];
$ambil = $koneksi->query("
    SELECT produk.*, kategori.nama_kategori 
    FROM produk 
    LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori
");

while ($detail = $ambil->fetch_assoc()) {
    $produk[] = $detail;
}
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle">
            <h6>Daftar Produk</h6>
        </div>

        <div class="card-body">
            <div class="row">

                <?php if (count($produk) > 0): ?>
                    <?php foreach ($produk as $pp): ?>

                        <div class="col-md-3 col-6 mb-4">
                            <div class="card h-100 shadow-sm">

                                <!-- FOTO PRODUK -->
                                <?php if (!empty($pp['foto_produk'])): ?>
                                    <img src="assets/img/<?php echo $pp['foto_produk']; ?>" 
                                         class="card-img-top" 
                                         style="height:180px; object-fit:cover;">
                                <?php else: ?>
                                    <div class="text-center p-5 text-muted">Tidak ada foto</div>
                                <?php endif; ?>

                                <div class="card-body">
                                    <h6 class="card-title">
                                        <?php echo $pp['nama_produk']; ?>
                                    </h6>

                                    <p class="text-primary fw-bold m-0">
                                        Rp<?php echo number_format($pp['harga_produk']); ?>
                                    </p>

                                    <p class="text-muted m-0 small">
                                        Kategori: <?php echo $pp['nama_kategori']; ?>
                                    </p>

                                    <p class="text-muted m-0 small">
                                        Stok: <?php echo $pp['stok_produk']; ?>
                                    </p>
                                </div>

                                <div class="card-footer bg-white">
                                    <a href="produk_detail.php?id=<?php echo $pp['id_produk']; ?>" 
                                       class="btn btn-outline-primary btn-sm w-100 mb-2">
                                        Detail
                                    </a>

                                    <a href="keranjang_tambah.php?id=<?php echo $pp['id_produk']; ?>" 
                                       onclick="return confirm('Tambahkan ke keranjang?')"
                                       class="btn btn-primary btn-sm w-100">
                                        + Keranjang
                                    </a>
                                </div>

                            </div>
                        </div>

                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <p>Tidak ada produk untuk ditampilkan.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
