<?php include "header.php"; ?>

<?php
// Cek apakah user sudah login
if (!isset($_SESSION['pelanggan'])) {
    echo "<script>alert('Silakan login terlebih dahulu!');</script>";
    echo "<script>location='login.php';</script>";
    exit;
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// Ambil data pelanggan
$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");
$pelanggan = $ambil->fetch_assoc();

// Jika pelanggan tidak ditemukan
if (!$pelanggan) {
    echo "<script>alert('Data akun tidak ditemukan!');</script>";
    echo "<script>location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary-subtle">
            <h4>Akun Saya</h4>
        </div>

        <div class="card-body">
            <div class="row">

                <!-- Foto Profil -->
                <div class="col-md-4 text-center mb-3">
                    <?php if (!empty($pelanggan['foto'])): ?>
                        <img src="assets/img/<?php echo $pelanggan['foto']; ?>" 
                             class="img-fluid rounded-circle mb-3"
                             width="150">
                    <?php else: ?>
                        <img src="assets/img/default.png" 
                             class="img-fluid rounded-circle mb-3"
                             width="150">
                    <?php endif; ?>

                    <p><b><?php echo $pelanggan['nama']; ?></b></p>
                </div>

                <!-- Data Profil -->
                <div class="col-md-8">

                    <form method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control"
                                   name="nama" 
                                   value="<?php echo $pelanggan['nama']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Username / Email</label>
                            <input type="text" class="form-control"
                                   name="username" 
                                   value="<?php echo $pelanggan['username']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Nomor HP</label>
                            <input type="text" class="form-control"
                                   name="telpon" 
                                   value="<?php echo $pelanggan['telpon']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea class="form-control" rows="3"
                                      name="alamat" required><?php echo $pelanggan['alamat']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Foto Profil</label>
                            <input type="file" class="form-control" name="foto">
                            <small class="text-danger">Kosongkan jika tidak ingin mengubah foto</small>
                        </div>

                        <button name="simpan" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="index.php" class="btn btn-secondary">
                Kembali ke Halaman Awal
            </a>
        </div>
    </div>
</div>

<?php
// Proses Update Data
if (isset($_POST['simpan'])) {

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $telpon   = $_POST['telpon'];
    $alamat   = $_POST['alamat'];

    // Cek upload foto baru atau tidak
    if (!empty($_FILES['foto']['name'])) {

        $nama_foto = time() . "_" . $_FILES['foto']['name'];
        $lokasi = $_FILES['foto']['tmp_name'];

        move_uploaded_file($lokasi, "assets/img/$nama_foto");

        $update = $koneksi->query("
            UPDATE pelanggan SET 
                nama='$nama',
                username='$username',
                telpon='$telpon',
                alamat='$alamat',
                foto='$nama_foto'
            WHERE id_pelanggan='$id_pelanggan'
        ");

    } else {

        $update = $koneksi->query("
            UPDATE pelanggan SET 
                nama='$nama',
                username='$username',
                telpon='$telpon',
                alamat='$alamat'
            WHERE id_pelanggan='$id_pelanggan'
        ");
    }

    echo "<script>alert('Data akun berhasil diupdate!');</script>";
    echo "<script>location='akun.php';</script>";
}
?>

<?php include "footer.php"; ?>
