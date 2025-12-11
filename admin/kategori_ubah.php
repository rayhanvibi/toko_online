<?php include "header.php"; ?>

<?php  

$id_kategori = $_GET['id'];

// Ambil data kategori yang akan diubah
$kategori = $koneksi->query("SELECT * FROM kategori WHERE id_kategori='$id_kategori'")->fetch_assoc();

echo "<pre>";
print_r($kategori);
echo "</pre>";

?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle">
            <h6>Ubah Kategori</h6>
        </div>

        <div class="card-body table-responsive">
            <form method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" 
                           value="<?php echo $kategori['nama_kategori']; ?>" 
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Foto Kategori Saat Ini:</label><br>

                    <?php if (!empty($kategori['foto_kategori'])): ?>
                        <img src="../assets/img/<?php echo $kategori['foto_kategori']; ?>" width="120" class="mb-2 rounded">
                    <?php else: ?>
                        <p class="text-muted">Tidak ada foto</p>
                    <?php endif; ?>

                    <br>
                    <label>Ubah Foto</label>
                    <input type="file" name="foto_kategori" class="form-control">
                    <span class="text-danger">*) Kosongkan jika tidak ingin mengubah foto</span>   
                </div>

                <button class="btn btn-primary" name="simpan">Simpan</button>

            </form>
        </div>
    </div>
</div>

<?php  

// PROSES UBAH
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama_kategori'];

    $namafoto = $_FILES['foto_kategori']['name'];
    $filefoto = $_FILES['foto_kategori']['tmp_name'];

    // Jika tidak upload foto → hanya update nama
    if (empty($namafoto)) {

        $koneksi->query("UPDATE kategori SET 
                        nama_kategori='$nama' 
                        WHERE id_kategori='$id_kategori'");
    } 
    else {

        // Upload foto baru
        move_uploaded_file($filefoto, "../assets/img/".$namafoto);

        // Update dengan foto baru
        $koneksi->query("UPDATE kategori SET 
                        nama_kategori='$nama',
                        foto_kategori='$namafoto' 
                        WHERE id_kategori='$id_kategori'");
    }

    echo "<script>alert('Berhasil Terubah')</script>";
    echo "<script>location='kategori.php'</script>";
}

?>

<?php include "footer.php"; ?>