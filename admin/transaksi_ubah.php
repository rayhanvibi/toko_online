<?php include "header.php"; ?>

<?php
$id_transaksi = $_GET['id_transaksi'];

// Ambil transaksi
$t = $koneksi->query("
    SELECT t.*, p.nama AS nama_pelanggan, p.telpon, p.alamat,
           b.nominal_bayar, b.status_bayar, b.bukti_bayar, b.tanggal_bayar,
           k.resi_kirim, k.ongkos_kirim, k.estimasi_kirim, k.ekspedisi_kirim, k.status_kirim
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    LEFT JOIN bayar b ON t.id_transaksi = b.id_transaksi
    LEFT JOIN kirim k ON t.id_transaksi = k.id_transaksi
    WHERE t.id_transaksi = '$id_transaksi'
")->fetch_assoc();

// Ambil produk transaksi
$produk = $koneksi->query("
    SELECT tp.*, p.nama_produk, p.foto_produk
    FROM transaksi_produk tp
    JOIN produk p ON tp.id_produk = p.id_produk
    WHERE tp.id_transaksi = '$id_transaksi'
");
?>

<div class="container mt-4">
    <h4>Ubah Transaksi #<?php echo $id_transaksi; ?></h4>
    <hr>

    <div class="row">
        <!-- LEFT -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Informasi Transaksi
                </div>
                <div class="card-body">
                    <p><b>Pelanggan:</b> <?php echo $t['nama_pelanggan']; ?></p>
                    <p><b>Telepon:</b> <?php echo $t['telpon']; ?></p>
                    <p><b>Alamat:</b> <?php echo $t['alamat']; ?></p>
                    <p><b>Tanggal Transaksi:</b> <?php echo $t['tanggal_transaksi']; ?></p>
                    <p><b>Status Transaksi:</b> <?php echo $t['status_transaksi']; ?></p>
                    <p><b>Nominal Bayar:</b> Rp<?php echo number_format($t['nominal_bayar']); ?></p>
                    <p><b>Status Bayar:</b> <?php echo $t['status_bayar']; ?></p>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    Bukti Pembayaran
                </div>
                <div class="card-body text-center">
                    <?php if (!empty($t['bukti_bayar'])): ?>
                        <img src="../assets/img/<?php echo $t['bukti_bayar']; ?>" width="100%">
                    <?php else: ?>
                        <p class="text-muted">Tidak Ada Bukti</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- PRODUK -->
    <div class="card mb-3">
        <div class="card-header bg-secondary text-white">
            Produk yang Dibeli
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $total = 0;
                    while($p = $produk->fetch_assoc()):
                        $sub = $p['harga'] * $p['jumlah'];
                        $total += $sub;
                    ?>
                    <tr>
                        <td><img src="../assets/img/<?php echo $p['foto_produk']; ?>" width="70"></td>
                        <td><?php echo $p['nama_produk']; ?></td>
                        <td>Rp<?php echo number_format($p['harga']); ?></td>
                        <td><?php echo $p['jumlah']; ?></td>
                        <td>Rp<?php echo number_format($sub); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>Rp<?php echo number_format($total); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- FORM UPDATE -->
    <div class="card">
        <div class="card-header bg-warning">
            Ubah Status Transaksi
        </div>

        <div class="card-body">
            <form method="post">

                <div class="row">
                    <div class="col-md-4">
                        <label>Status Bayar</label>
                        <select name="status_bayar" class="form-control">
                            <option value="pending" <?= $t['status_bayar']=='pending'?'selected':'' ?>>Pending</option>
                            <option value="sukses" <?= $t['status_bayar']=='sukses'?'selected':'' ?>>Sukses</option>
                            <option value="gagal" <?= $t['status_bayar']=='gagal'?'selected':'' ?>>Gagal</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Status Transaksi</label>
                        <select name="status_transaksi" class="form-control">
                            <option value="menunggu konfirmasi" <?= $t['status_transaksi']=='menunggu konfirmasi'?'selected':'' ?>>Menunggu Konfirmasi</option>
                            <option value="sukses" <?= $t['status_transaksi']=='sukses'?'selected':'' ?>>Sukses</option>
                            <option value="gagal" <?= $t['status_transaksi']=='gagal'?'selected':'' ?>>Gagal</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Status Kirim</label>
                        <select name="status_kirim" class="form-control">
                            <option value="proses" <?= $t['status_kirim']=='proses'?'selected':'' ?>>Proses</option>
                            <option value="delay" <?= $t['status_kirim']=='delay'?'selected':'' ?>>Delay</option>
                            <option value="selesai" <?= $t['status_kirim']=='selesai'?'selected':'' ?>>Selesai</option>
                            <option value="gagal" <?= $t['status_kirim']=='gagal'?'selected':'' ?>>Gagal</option>
                        </select>
                    </div>
                </div>

                <hr>

                <h6>Input Pengiriman</h6>

                <div class="row">
                    <div class="col-md-4">
                        <label>Resi</label>
                        <input type="text" name="resi_kirim" class="form-control"
                               value="<?= $t['resi_kirim']; ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Ekspedisi</label>
                        <input type="text" name="ekspedisi_kirim" class="form-control"
                               value="<?= $t['ekspedisi_kirim']; ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Ongkos Kirim</label>
                        <input type="number" name="ongkos_kirim" class="form-control"
                               value="<?= $t['ongkos_kirim']; ?>">
                    </div>
                </div>

                <div class="mt-3">
                    <label>Estimasi Kirim</label>
                    <input type="text" name="estimasi_kirim" class="form-control"
                           value="<?= $t['estimasi_kirim']; ?>">
                </div>

                <button class="btn btn-primary mt-3" name="simpan">Simpan Perubahan</button>

            </form>
        </div>
    </div>

</div>

<?php
// UPDATE DATABASE
if (isset($_POST['simpan'])){

    $koneksi->query("
        UPDATE bayar SET 
        status_bayar = '{$_POST['status_bayar']}'
        WHERE id_transaksi = '$id_transaksi'
    ");

    $koneksi->query("
        UPDATE transaksi SET 
        status_transaksi = '{$_POST['status_transaksi']}'
        WHERE id_transaksi = '$id_transaksi'
    ");

    $koneksi->query("
        UPDATE kirim SET 
        status_kirim = '{$_POST['status_kirim']}',
        resi_kirim = '{$_POST['resi_kirim']}',
        ongkos_kirim = '{$_POST['ongkos_kirim']}',
        estimasi_kirim = '{$_POST['estimasi_kirim']}',
        ekspedisi_kirim = '{$_POST['ekspedisi_kirim']}'
        WHERE id_transaksi = '$id_transaksi'
    ");

    echo "<script>alert('Data berhasil diperbarui!')</script>";
    echo "<script>location='transaksi_bayar.php'</script>";
}
?>

<?php include "footer.php"; ?>
