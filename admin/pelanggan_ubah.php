<?php include "header.php"; ?>
<?php  
$id = $_GET['id'];
$pel = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$id'")->fetch_assoc();
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle"><h6>Ubah Pelanggan</h6></div>

        <div class="card-body">
            <form method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" value="<?= $pel['username'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" value="<?= $pel['password'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" value="<?= $pel['nama'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Telpon</label>
                    <input type="text" name="telpon" value="<?= $pel['telpon'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"><?= $pel['alamat'] ?></textarea>
                </div>

                <div class="mb-3">
                    <img src="../assets/img/<?= $pel['foto'] ?>" width="80"><br>
                    <label>Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" class="form-control">
                    <small class="text-danger">Kosongkan jika tidak diganti</small>
                </div>

                <button class="btn btn-primary" name="ubah">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<?php  
if (isset($_POST['ubah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $telpon = $_POST['telpon'];
    $alamat = $_POST['alamat'];

    $foto = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];

    if (!empty($lokasi)) {
        move_uploaded_file($lokasi, "../assets/img/".$foto);

        $koneksi->query("UPDATE pelanggan SET 
            username='$username',
            password='$password',
            nama='$nama',
            telpon='$telpon',
            alamat='$alamat',
            foto='$foto'
            WHERE id_pelanggan='$id'
        ");
    } else {
        $koneksi->query("UPDATE pelanggan SET 
            username='$username',
            password='$password',
            nama='$nama',
            telpon='$telpon',
            alamat='$alamat'
            WHERE id_pelanggan='$id'
        ");
    }

    echo "<script>alert('Pelanggan berhasil diubah')</script>";
    echo "<script>location='pelanggan.php'</script>";
}
?>

<?php include "footer.php"; ?>