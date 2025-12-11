<?php include "header.php"; ?>

<?php
$pelanggan = [];
$ambil = $koneksi->query("SELECT * FROM pelanggan");
while ($p = $ambil->fetch_assoc()) {
    $pelanggan[] = $p;
}
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle"><h6>Data Pelanggan</h6></div>

        <div class="card-body table-responsive">
            <a href="pelanggan_tambah.php" class="btn btn-primary btn-sm mb-3">+ Tambah Pelanggan</a>

            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Telpon</th>
                        <th>Alamat</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($pelanggan as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><img src="../assets/img/<?= $p['foto'] ?>" width="60"></td>
                        <td><?= $p['username'] ?></td>
                        <td><?= $p['nama'] ?></td>
                        <td><?= $p['telpon'] ?></td>
                        <td><?= $p['alamat'] ?></td>
                        <td>
                            <a href="pelanggan_ubah.php?id=<?= $p['id_pelanggan'] ?>" class="btn btn-warning btn-sm">Ubah</a>
                            <a href="pelanggan_hapus.php?id=<?= $p['id_pelanggan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include "footer.php"; ?>