<?php include "header.php"; ?>

<?php
// Ambil transaksi menunggu konfirmasi
$ambil = $koneksi->query("
    SELECT t.*, p.nama AS nama_pelanggan, b.nominal_bayar, b.status_bayar, b.bukti_bayar
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    LEFT JOIN bayar b ON t.id_transaksi = b.id_transaksi
    WHERE t.status_transaksi = 'menunggu konfirmasi'
    ORDER BY t.id_transaksi DESC
");
?>

<div class="container mt-4">
    <h4>Transaksi Menunggu Konfirmasi</h4>
    <hr>

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Nominal Bayar</th>
                <th>Status Bayar</th>
                <th>Bukti Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = $ambil->fetch_assoc()): ?>

                <?php
                // Ambil total harga dari transaksi_produk
                $id_transaksi = $row['id_transaksi'];
                $total = 0;

                $ambilProduk = $koneksi->query("
                    SELECT harga, jumlah FROM transaksi_produk
                    WHERE id_transaksi = '$id_transaksi'
                ");

                while($produk = $ambilProduk->fetch_assoc()){
                    $total += $produk['harga'] * $produk['jumlah'];
                }
                ?>

                <tr>
                    <td>#<?php echo $id_transaksi; ?></td>
                    <td><?php echo $row['tanggal_transaksi']; ?></td>
                    <td><?php echo $row['nama_pelanggan']; ?></td>
                    <td>Rp<?php echo number_format($total); ?></td>
                    <td>Rp<?php echo number_format($row['nominal_bayar']); ?></td>
                    <td>
                        <?php if ($row['status_bayar'] == 'pending'): ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php elseif ($row['status_bayar'] == 'sukses'): ?>
                            <span class="badge bg-success">Sukses</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Gagal</span>
                        <?php endif; ?>
                    </td>

                    <!-- Bukti Bayar -->
                    <td>
                        <?php if (!empty($row['bukti_bayar'])): ?>
                            <img src="../assets/img/<?php echo $row['bukti_bayar']; ?>" 
                                 style="width:80px; border-radius:6px;">
                        <?php else: ?>
                            <small class="text-muted">-</small>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="transaksi_ubah.php?id_transaksi=<?php echo $id_transaksi; ?>"
                           class="btn btn-primary btn-sm">
                           Ubah
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>
        </tbody>
    </table>

</div>

<?php include "footer.php"; ?>
