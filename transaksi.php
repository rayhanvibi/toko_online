<?php include "header.php"; ?>

<?php  
// Pastikan pelanggan sudah login
if (!isset($_SESSION['pelanggan'])) {
    echo "<script>alert('Silakan login terlebih dahulu!');</script>";
    echo "<script>location='login.php';</script>";
    exit;
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

$transaksi = [];
$ambil = $koneksi->query("
    SELECT * FROM transaksi 
    WHERE id_pelanggan = '$id_pelanggan' 
    ORDER BY id_transaksi DESC
");
while ($detail = $ambil->fetch_assoc()) {
    $transaksi[] = $detail;
}
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle">
            <h5>Data Transaksi Saya</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status Bayar</th>
                        <th>Status Kirim</th>
                        <th>Bukti Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($transaksi) == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($transaksi as $no => $t): ?>
                        <tr>
                            <td><?php echo $no + 1; ?></td>
                            <td><?php echo $t['tanggal_transaksi']; ?></td>
                            <td>Rp<?php echo number_format($t['total_transaksi']); ?></td>

                            <!-- Status Bayar -->
                            <td>
                                <?php 
                                    if ($t['status_bayar'] == "belum") {
                                        echo "<span class='badge bg-danger'>Belum Bayar</span>";
                                    } elseif ($t['status_bayar'] == "menunggu") {
                                        echo "<span class='badge bg-warning text-dark'>Menunggu Verifikasi</span>";
                                    } else {
                                        echo "<span class='badge bg-success'>Sudah Bayar</span>";
                                    }
                                ?>
                            </td>

                            <!-- Status Kirim -->
                            <td>
                                <?php 
                                    if ($t['status_kirim'] == "proses") {
                                        echo "<span class='badge bg-warning text-dark'>Diproses</span>";
                                    } elseif ($t['status_kirim'] == "kirim") {
                                        echo "<span class='badge bg-info'>Dikirim</span>";
                                    } elseif ($t['status_kirim'] == "selesai") {
                                        echo "<span class='badge bg-success'>Selesai</span>";
                                    } else {
                                        echo "<span class='badge bg-secondary'>-</span>";
                                    }
                                ?>
                            </td>

                            <!-- Cek bukti bayar -->
                            <td>
                                <?php if (!empty($t['bukti_bayar'])): ?>
                                    <img src="assets/bukti/<?php echo $t['bukti_bayar']; ?>" 
                                         width="70" class="rounded">
                                <?php else: ?>
                                    <span class="text-muted">Belum Upload</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">

                                <a href="transaksi_detail.php?id_transaksi=<?php echo $t['id_transaksi']; ?>" 
                                   class="btn btn-sm btn-secondary mb-1">
                                    Detail
                                </a>

                                <a href="transaksi_preview.php?id_transaksi=<?php echo $t['id_transaksi']; ?>" 
                                   class="btn btn-sm btn-info mb-1">
                                    Preview
                                </a>

                                <?php if ($t['status_bayar'] == "belum"): ?>
                                    <a href="transaksi_bayar.php?id_transaksi=<?php echo $t['id_transaksi']; ?>" 
                                       class="btn btn-sm btn-primary">
                                        Upload Bukti Bayar
                                    </a>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
