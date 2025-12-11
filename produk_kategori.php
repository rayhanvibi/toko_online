<?php include "header.php"; ?>

<?php  
// Ambil ID kategori dari URL
$id_kategori = $_GET['id_kategori'];

// Ambil data kategori
$kategori = $koneksi->query("SELECT * FROM kategori WHERE id_kategori='$id_kategori'")->fetch_assoc();

// Ambil semua produk berdasarkan kategori
$produk = [];
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_kategori='$id_kategori' ORDER BY id_produk DESC");
while ($data = $ambil->fetch_assoc()) {
    $produk[] = $data;
}
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle">
            <h6>Produk pada Kategori : <strong><?php echo $kategori['nama_kategori']; ?></strong></h6>
        </div>

        <div class="card-body table-responsive">

            <?php if (empty($produk)): ?>
                <div class="alert alert-warning">
                    Tidak ada produk dalam kategori ini.
                </div>
            <?php else: ?>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($produk as $pp => $p): ?>
                    <tr>
                        <td><?php echo $pp+1; ?></td>

                        <td>
                            <?php if (!empty($p['foto_produk'])): ?>
                                <img src="../assets/img/<?php echo $p['foto_produk']; ?>" 
                                     width="70" class="rounded">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>

                        <td><?php echo $p['nama_produk']; ?></td>

                        <td>Rp <?php echo number_format($p['harga_produk'], 0, ',', '.'); ?></td>

                        <td><?php echo $p['stok_produk']; ?></td>

                        <td>
                            <a href="produk_detail.php?id_produk=<?php echo $p['id_produk']; ?>" 
                               class="btn btn-primary btn-sm">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

            <?php endif; ?>

            <a href="kategori.php" class="btn btn-secondary mt-2">
                Kembali
            </a>

        </div>
    </div>
</div>

<?php include "footer.php"; ?>
