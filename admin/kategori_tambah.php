<?php include "header.php"; ?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle">
            <h6>Tambah Kategori</h6>
        </div>

        <div class="card-body table-responsive">
            <form method="post" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Foto Kategori</label>
                    <input type="file" name="foto_kategori" class="form-control">
                </div>

                <button class="btn btn-primary" name="simpan">Simpan</button>

            </form>
        </div>
    </div>
</div>

<?php  
// PROSES SIMPAN
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama_kategori'];

    // Foto
    $namafoto = $_FILES['foto_kategori']['name'];
    $filefoto = $_FILES['foto_kategori']['tmp_name'];

    // Upload jika ada foto
    if (!empty($namafoto)) {
        move_uploaded_file($filefoto, "../assets/img/" . $namafoto);
    } else {
        $namafoto = ""; // jika tidak upload foto
    }

    // Simpan ke database
    $koneksi->query("INSERT INTO kategori(nama_kategori, foto_kategori)
                     VALUES('$nama', '$namafoto')");

    echo "<script>alert('Kategori berhasil disimpan');</script>";
    echo "<script>location='kategori.php';</script>";
}
?>

<?php include "footer.php"; ?>