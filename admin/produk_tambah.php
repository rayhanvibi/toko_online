<?php include "header.php"; ?>
<?php  
$kategori = [];
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($detail = $ambil->fetch_assoc()) {
    $kategori[] = $detail;
}
// echo "<pre>";
// print_r($kategori);
// echo "</pre>";
?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle"><h6>Tambah Produk</h6></div>
        <div class="card-body table-responsive">
        <form method="post" enctype="multipart/form-data">
        	<div class="mb-3">
        		<label>Kategori</label>
        		<select class="form-control" name="id_kategori">
        			<option value="">pilih</option>
        			<?php foreach ($kategori as $value): ?>
        			<option value="<?php echo $value['id_kategori'] ?>"><?php echo $value['nama_kategori'] ?></option>
        		<?php endforeach ?>
        		</select>
        	</div>
        	<div class="mb-3">
        		<label>Nama Produk</label>
        		<input type="text" name="nama_produk" class="form-control">
        	</div>
        	<div class="mb-3">
        		<label>Harga Produk</label>
        		<input type="number" name="harga_produk" class="form-control">
        	</div>
        	<div class="mb-3">
        		<label>Stok Produk</label>
        		<input type="number" name="stok_produk" class="form-control">
        	</div>
        	<div class="mb-3">
        		<label>Deskripsi</label>
        		<textarea class="form-control" name="deskripsi_produk"></textarea>
        	</div>
        	<div class="mb-3">
        		<label>Foto</label>
        		<input type="file" name="foto_produk" class="form-control">
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

	move_uploaded_file($filefoto, "../assets/img/".$namafoto);

	$koneksi->query("INSERT INTO produk
		(id_kategori, nama_produk, harga_produk, stok_produk, deskripsi_produk, foto_produk)
		VALUES('$id_kategori','$nama','$harga' ,'$stok', '$deskripsi', '$namafoto')");

	echo "<script>alert('Berhasil tersimpan')</script>";
	echo "<script>location='produk.php'</script>";
}
 ?>
<?php include "footer.php"; ?>
