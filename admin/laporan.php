<?php include "header.php"; ?>


<div class="container mt-4">

    <form method="post" class="row mb-3">
        <div class="col-md-4">
            <label>Dari</label>
            <input type="date" name="tgl_mulai" class="form-control"
                   value="<?= isset($_POST['tgl_mulai']) ? $_POST['tgl_mulai'] : '' ?>">
        </div>
        <div class="col-md-4">
            <label>Sampai</label>
            <input type="date" name="tgl_selesai" class="form-control"
                   value="<?= isset($_POST['tgl_selesai']) ? $_POST['tgl_selesai'] : '' ?>">
        </div>
        <div class="col-md-4">
            <label>&nbsp;</label>
            <button class="btn btn-primary w-100" name="kirim">Filter</button>
        </div>
    </form>

    <button onclick="window.print()" class="btn btn-success mb-3">Cetak Laporan</button>

    <div class="row">
        <div class="col-md-12">

            <?php
            if (isset($_POST['kirim'])) {

                $mulai  = $_POST['tgl_mulai'];
                $selesai = $_POST['tgl_selesai'];

                $sql = "SELECT t.*, p.nama, b.nominal_bayar
                        FROM transaksi t
                        LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                        LEFT JOIN bayar b ON t.id_transaksi = b.id_transaksi
                        WHERE DATE(t.tanggal_transaksi) BETWEEN '$mulai' AND '$selesai'
                        ORDER BY t.id_transaksi DESC";

            } else {

                // tampil semua data jika tidak difilter
                $sql = "SELECT t.*, p.nama, b.nominal_bayar
                        FROM transaksi t
                        LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                        LEFT JOIN bayar b ON t.id_transaksi = b.id_transaksi
                        ORDER BY t.id_transaksi DESC";
            }

            $query = mysqli_query($koneksi, $sql);

            $total_bayar = 0;
            ?>

            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Status Transaksi</th>
                    <th>Nominal Bayar</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $no = 1;
                while ($d = mysqli_fetch_array($query)) {
                    $total_bayar += intval($d['nominal_bayar']);
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $d['id_transaksi']; ?></td>
                        <td><?= $d['nama']; ?></td>
                        <td><?= $d['tanggal_transaksi']; ?></td>
                        <td><?= $d['status_transaksi']; ?></td>
                        <td>Rp <?= number_format($d['nominal_bayar'],0,',','.'); ?></td>
                    </tr>
                <?php } ?>

                </tbody>

                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="5" class="text-end">Total Pembayaran:</th>
                        <th>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>