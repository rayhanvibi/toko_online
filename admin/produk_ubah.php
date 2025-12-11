<?php include "header.php"; ?>
<?php  

$id_produk = $_GET['id'];

$produk = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'")->fetch_assoc();

$kategori = [];
$ambil = $koneksi->query("SELECT * FROM kategori");

while ($detail = $ambil->fetch_assoc()) {
    $kategori[] = $detail;
}

echo "<pre>";
print_r($kategori);
print_r($produk);
echo "</pre>";
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle"><h6>Ubah Produk</h6></div>
        <div class="card-body table-responsive">
        <form method="post" enctype="multipart/form-data">
        	<div class="mb-3">
        		<label>Kategori</label>
        		<select class="form-control" name="id_kategori">
        			<option value="">pilih</option>
        			<?php foreach ($kategori as $value): ?>
        			<option value="<?php echo $value['id_kategori'] ?>"
                        <?php if ($value['id_kategori']==$produk['id_kategori']) {
                            echo 'selected';
                        } ?>
                        ><?php echo $value['nama_kategori'] ?></option>
        		<?php endforeach ?>
        		</select>
        	</div>
        	<div class="mb-3">
        		<label>Nama Produk</label>
        		<input type="text" name="nama_produk" value="<?php echo $produk['nama_produk'] ?>" class="form-control">
        	</div>
        	<div class="mb-3">
        		<label>Harga Produk</label>
        		<input type="number" name="harga_produk" class="form-control" value="<?php echo $produk['harga_produk'] ?>">
        	</div>
        	<div class="mb-3">
        		<label>Stok Produk</label>
        		<input type="number" name="stok_produk" class="form-control " value="<?php echo $produk['stok_produk'] ?>">
        	</div>
        	<div class="mb-3">
        		<label>Deskripsi</label>
        		<textarea class="form-control" name="deskripsi_produk"><?php echo $produk['deskripsi_produk'] ?></textarea>
        	</div>
        	<div class="mb-3">
                <img src="../assets/img/<?php echo $produk['foto_produk'] ?>" width="100">
                <br>
        		<label>Foto</label>
        		<input type="file" name="foto_produk" class="form-control">
        	    <span class="text-danger">*) Jika tidak diubah maka kosongkan</span>   
            </div>
        	<button class="btn btn-primary" name="simpan">Simpan</button>
        </form>
        </div>
    </div>
</div>

<?php if (isset($_POST['simpan'])) {
	
	$id_kategori = $_POST['id_kategori'];
	$nama = $_POST['nama_produk'];
	$stok = $_POST['stok_produk'];
	$harga = $_POST['harga_produk'];
	$deskripsi = $_POST['deskripsi_produk'];

	$namafoto = $_FILES['foto_produk']['name'];
	$filefoto = $_FILES['foto_produk']['tmp_name'];

	
    if (empty($filefoto)) {
        $koneksi->query("UPDATE produk SET id_kategori='$id_kategori',
            nama_produk='$nama',
            stok_produk='$stok',
            harga_produk='$harga',
            deskripsi_produk='$deskripsi' WHERE id_produk='$id_produk'");
    }
    else{
        move_uploaded_file($filefoto, "../assets/img/".$namafoto);

        $koneksi->query("UPDATE produk SET id_kategori='$id_kategori',
            nama_produk='$nama',
            stok_produk='$stok',
            harga_produk='$harga',
            foto_produk='$namafoto' WHERE id_produk='$id_produk'");
    }

	echo "<script>alert('Berhasil Terubah')</script>";
	echo "<script>location='produk.php'</script>";
}
 ?>
<?php include "footer.php"; ?>
