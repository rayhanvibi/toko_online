<?php include "header.php"; ?>
<?php  
$produk = [];
$ambil = $koneksi->query("SELECT * FROM produk LEFT JOIN kategori ON kategori.id_kategori = produk.id_kategori");
while ($detail = $ambil->fetch_assoc()) {
    $produk[] = $detail;
}
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle"><h6>Data Produk</h6></div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produk)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada data produk.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produk as $no => $p): ?>
                            <tr>
                                <td class="text-center"><?php echo $no + 1; ?></td>
                                <td><?php echo htmlspecialchars($p['nama_kategori']); ?></td>
                                <td><?php echo htmlspecialchars($p['nama_produk']); ?></td>
                                <td>Rp <?php echo number_format($p['harga_produk'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?php echo $p['stok_produk']; ?></td>
                                <td class="text-center">
                                    <?php if (!empty($p['foto_produk'])): ?>
                                        <img src="../assets/img/<?php echo htmlspecialchars($p['foto_produk']); ?>" width="80" class="rounded">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="produk_ubah.php?id=<?php echo $p['id_produk']; ?>" 
                                       class="btn btn-warning btn-sm">
                                        Ubah
                                    </a>
                                    <a href="produk_hapus.php?id=<?php echo $p['id_produk']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus produk ini?');">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="produk_tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Produk </a>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
