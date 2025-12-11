<?php include "header.php"; ?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle"><h6>Tambah Pelanggan</h6></div>

        <div class="card-body">
            <form method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Telpon</label>
                    <input type="text" name="telpon" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <button class="btn btn-primary" name="simpan">Simpan</button>
            </form>
        </div>
    </div>
</div>

<?php  
if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $telpon = $_POST['telpon'];
    $alamat = $_POST['alamat'];

    $foto = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];

    if (!empty($lokasi)) {
        move_uploaded_file($lokasi, "../assets/img/".$foto);
    }

    $koneksi->query("INSERT INTO pelanggan (username, password, nama, telpon, alamat, foto)
    VALUES('$username','$password','$nama','$telpon','$alamat','$foto')");

    echo "<script>alert('Pelanggan berhasil ditambah')</script>";
    echo "<script>location='pelanggan.php'</script>";
}
?>

<?php include "footer.php"; ?>