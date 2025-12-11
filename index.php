<?php include "header.php"; ?>
<?php 
$produk = [];
$ambil = $koneksi->query("SELECT * FROM produk");
while ($detail = $ambil->fetch_assoc()) {
 	$produk[]= $detail;
 } 
// echo "<pre>";
// print_r($produk);
// echo "</pre>";
 ?>
 <section class="container mt-4">
 	<div class="row">
 		<?php foreach ($produk as $key => $value): ?>
 		<div class="col-md-4">
 			<div class="card">
 				<img src="assets/img/<?php echo $value['foto_produk'] ?>" class="card-img-top">
 				<div class="card-body">
 					<h6 class="card-title"><?php echo $value['nama_produk'] ?></h6>
 					<p class="card-text"><?php echo $value['harga_produk'] ?></p>
 					<a href="produk_detail.php?id=<?php echo $value['id_produk'] ?>" class="btn btn-outline-primary btn-sm">Detail</a>
 					<a href="" class="btn btn-outline-warning btn-sm">Beli</a>
 				</div>
 			</div>
 		</div>
 	<?php endforeach ?>
 	</div>
 </section>

<?php include "footer.php"; ?>