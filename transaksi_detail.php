<?php include "header.php"; ?>

<?php
$id_transaksi = $_GET['id_transaksi'];

// Data transaksi
$transaksi = $koneksi->query("
    SELECT transaksi.*, pelanggan.nama, pelanggan.alamat, pelanggan.telpon
    FROM transaksi 
    LEFT JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan
    WHERE transaksi.id_transaksi='$id_transaksi'
")->fetch_assoc();

// Data produk dalam transaksi
$tp = [];
$ambil = $koneksi->query("
    SELECT transaksi_produk.*, produk.nama_produk, produk.foto_produk
    FROM transaksi_produk 
    LEFT JOIN produk ON produk.id_produk = transaksi_produk.id_produk
    WHERE transaksi_produk.id_transaksi='$id_transaksi'
");
while($detail = $ambil->fetch_assoc()){
    $tp[] = $detail;
}

// Data pembayaran
$bayar = $koneksi->query("SELECT * FROM bayar WHERE id_transaksi='$id_transaksi'")->fetch_assoc();

// Data pengiriman
$kirim = $koneksi->query("SELECT * FROM kirim WHERE id_transaksi='$id_transaksi'")->fetch_assoc();
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary text-white"><b>Detail Transaksi</b></div>
        <div class="card-body">

            <!-- INFO TRANSAKSI -->
            <h6>Informasi Pelanggan</h6>
            <table class="table table-bordered">
                <tr><th>Nama</th><td><?php echo $transaksi['nama']; ?></td></tr>
                <tr><th>Telpon</th><td><?php echo $transaksi['telpon']; ?></td></tr>
                <tr><th>Alamat</th><td><?php echo $transaksi['alamat']; ?></td></tr>
                <tr><th>Status Transaksi</th><td><?php echo $transaksi['status_transaksi']; ?></td></tr>
            </table>

            <!-- PRODUK -->
            <h6>Produk yang Dibeli</h6>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach($tp as $p): 
                        $subtotal = $p['harga'] * $p['jumlah'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><img src="assets/img/<?php echo $p['foto_produk']; ?>" width="70"></td>
                        <td><?php echo $p['nama_produk']; ?></td>
                        <td>Rp <?php echo number_format($p['harga']); ?></td>
                        <td><?php echo $p['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($subtotal); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th colspan="4">TOTAL</th>
                        <th>Rp <?php echo number_format($total); ?></th>
                    </tr>
                </tbody>
            </table>

            <!-- UPLOAD BUKTI BAYAR -->
            <h6>Bukti Pembayaran</h6>

            <?php if($bayar == NULL): ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Nominal Bayar</label>
                        <input type="number" name="nominal_bayar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Upload Bukti Bayar</label>
                        <input type="file" name="bukti_bayar" class="form-control" required>
                    </div>
                    <button name="upload" class="btn btn-primary">Upload Bukti</button>
                </form>

                <?php 
                if(isset($_POST['upload']))
                {
                    $nominal = $_POST['nominal_bayar'];
                    $nama_file = time()."_".$_FILES['bukti_bayar']['name'];
                    $lokasi = $_FILES['bukti_bayar']['tmp_name'];
                    move_uploaded_file($lokasi, "assets/img/".$nama_file);

                    $koneksi->query("
                        INSERT INTO bayar (id_transaksi, nominal_bayar, bukti_bayar, tanggal_bayar, status_bayar) 
                        VALUES ('$id_transaksi','$nominal','$nama_file', NOW(),'pending')
                    ");

                    echo "<script>alert('Bukti bayar berhasil diupload!');location.href='transaksi_detail.php?id_transaksi=$id_transaksi';</script>";
                }
                ?>

            <?php else: ?>
                <p>Status Pembayaran: <b><?php echo $bayar['status_bayar']; ?></b></p>
                <p>Nominal: Rp <?php echo number_format($bayar['nominal_bayar']); ?></p>
                <img src="assets/img/<?php echo $bayar['bukti_bayar']; ?>" width="250">
            <?php endif; ?>

            <hr>

            <!-- DATA PENGIRIMAN -->
            <h6>Data Pengiriman</h6>

            <?php if($kirim == NULL): ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>Resi</label>
                        <input type="text" name="resi_kirim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Ongkos Kirim</label>
                        <input type="number" name="ongkos_kirim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Estimasi Kirim</label>
                        <input type="text" name="estimasi_kirim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Ekspedisi</label>
                        <input type="text" name="ekspedisi_kirim" class="form-control" required>
                    </div>
                    <button name="kirim" class="btn btn-success">Simpan Pengiriman</button>
                </form>

                <?php
                if(isset($_POST['kirim']))
                {
                    $resi = $_POST['resi_kirim'];
                    $ongkir = $_POST['ongkos_kirim'];
                    $estimasi = $_POST['estimasi_kirim'];
                    $ekspedisi = $_POST['ekspedisi_kirim'];

                    $koneksi->query("
                        INSERT INTO kirim (id_transaksi, resi_kirim, ongkos_kirim, estimasi_kirim, ekspedisi_kirim, status_kirim, alamat_kirim)
                        VALUES ('$id_transaksi','$resi','$ongkir','$estimasi','$ekspedisi','proses','".$transaksi['alamat']."')
                    ");

                    echo "<script>alert('Data pengiriman disimpan!');location.href='transaksi_detail.php?id_transaksi=$id_transaksi';</script>";
                }
                ?>

            <?php else: ?>
                <table class="table table-bordered">
                    <tr><th>Resi</th><td><?php echo $kirim['resi_kirim']; ?></td></tr>
                    <tr><th>Ekspedisi</th><td><?php echo $kirim['ekspedisi_kirim']; ?></td></tr>
                    <tr><th>Ongkir</th><td>Rp <?php echo number_format($kirim['ongkos_kirim']); ?></td></tr>
                    <tr><th>Estimasi</th><td><?php echo $kirim['estimasi_kirim']; ?></td></tr>
                    <tr><th>Status</th><td><?php echo $kirim['status_kirim']; ?></td></tr>
                </table>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include "footer.php"; ?>
