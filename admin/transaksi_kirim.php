<?php include "header.php"; ?>

<?php
// Query transaksi yang sudah dibayar dan sukses, tetapi kirim masih proses
$ambil = $koneksi->query("
    SELECT t.*, p.nama AS nama_pelanggan, b.nominal_bayar, 
           k.resi_kirim, k.ongkos_kirim, k.estimasi_kirim, k.ekspedisi_kirim, k.status_kirim
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN bayar b ON t.id_transaksi = b.id_transaksi
    JOIN kirim k ON t.id_transaksi = k.id_transaksi
    WHERE b.status_bayar = 'sukses'
      AND t.status_transaksi = 'sukses'
      AND k.status_kirim = 'proses'
    ORDER BY t.id_transaksi DESC
");
?>

<div class="container mt-4">
    <h4>Transaksi Dalam Proses Pengiriman</h4>
    <hr>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Nominal Bayar</th>
                <th>Ekspedisi</th>
                <th>Resi</th>
                <th>Status Kirim</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $ambil->fetch_assoc()): ?>

                <?php
                // Hitung total belanja dari transaksi_produk
                $id_transaksi = $row['id_transaksi'];
                $total = 0;

                $produk = $koneksi->query("
                    SELECT harga, jumlah 
                    FROM transaksi_produk 
                    WHERE id_transaksi = '$id_transaksi'
                ");

                while($p = $produk->fetch_assoc()){
                    $total += $p['harga'] * $p['jumlah'];
                }
                ?>

                <tr>
                    <td>#<?php echo $row['id_transaksi']; ?></td>
                    <td><?php echo $row['tanggal_transaksi']; ?></td>
                    <td><?php echo $row['nama_pelanggan']; ?></td>
                    <td>Rp<?php echo number_format($row['nominal_bayar']); ?></td>
                    <td><?php echo $row['ekspedisi_kirim']; ?></td>
                    <td><?php echo $row['resi_kirim']; ?></td>

                    <td>
                        <?php if ($row['status_kirim'] == 'proses'): ?>
                            <span class="badge bg-warning text-dark">Proses</span>
                        <?php elseif ($row['status_kirim'] == 'delay'): ?>
                            <span class="badge bg-danger">Delay</span>
                        <?php elseif ($row['status_kirim'] == 'selesai'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Gagal</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="transaksi_ubah.php?id_transaksi=<?php echo $id_transaksi; ?>" 
                           class="btn btn-primary btn-sm">
                           Ubah / Detail
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>
        </tbody>

    </table>
</div>

<?php include "footer.php"; ?>
