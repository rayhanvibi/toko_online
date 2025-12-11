<?php include "header.php"; ?>
<?php 
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
// menampilkan data keranjang berdasarkan user yang dimasukkan
$keranjang = [];
$ambil = $koneksi->query("SELECT * FROM keranjang 
	LEFT JOIN produk ON produk.id_produk = keranjang.id_produk
	WHERE id_pelanggan='$id_pelanggan'");
while ($detail = $ambil->fetch_assoc()) 
{
	$keranjang[] = $detail;
}

 
 ?>
 
 <div class="container">
 	<div class="row">
 		<div class="col-md-10 offset-md-1 shadow rounded bg-white p-3 border-top border-3 border-primary">
 			<table class="table table-bordered table-striped">
 				<thead>
 					<tr>
 						<th>No</th>
 						<th>Produk</th>
 						<th>Jumlah</th>
 						<th>Aksi</th>
 					</tr>
 				</thead>
 				<tbody>
 					<?php foreach ($keranjang as $key => $value): ?>
 					<tr>
 						<td><?php echo $key+1;?></td>
 						<td><?php echo $value['nama_produk']; ?> <span><?php echo $value['nama_produk']; ?></span></td>
 						<td><?php echo $value['jumlah']; ?></td>
 						<td>
 							<div class="btn-grup">
 								<a href="keranjang_tambah.php?id_produk=<?php echo $value['id_produk'] ?>" class="btn btn-outline-primary">+</a>

 								<a href="keranjang_kurang.php?id_produk=<?php echo $value['id_produk'] ?>" class="btn btn-outline-primary">-</a>
 								<a href="transaksi_prabeli.php?id_keranjang= <?php echo $value['id_keranjang'] ?>" class="btn btn-warning btn-sm">Checkout</a>
 							</div>
 						</td>
 					</tr>
 				<?php endforeach ?>
 				</tbody>
 			</table>
 		</div>
 	</div>
 </div>
<?php include "footer.php"; ?> 
