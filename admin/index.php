<?php include "header.php"; ?>
	<!-- Konten  -->
	<?php 
	$jp = $koneksi->query("SELECT COUNT('id_pelanggan') AS jumlah FROM pelanggan")->fetch_assoc();
	$jk = $koneksi->query("SELECT COUNT('id_kategori') AS jumlah FROM kategori")->fetch_assoc();

	//echo "<pre>";
	//print_r ($jp);
	//echo "</pre>";


	 ?>
	<div class="container mt-3"> 
		<div class="row">
			<div class="col-md-3">
				<div class="bg-white shadow-sm roundes border-top border-primary border-3 d-flex justify-content-center">
					<span class="pt-3">
					<i class="bi bi-box display-5"></i>
					</span>
					<h1 class="display-1 fw-bold"><?php echo number_format($jp['jumlah']); ?></h1>

				</div>
				<div class="bg-white shadow-sm roundes border-bottom border-primary border-3 d-flex justify-content-center">
					<a href="" class="text-decoration-none"><h6 class="text-center text-dark">Jumlah Pelanggan</h6></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="bg-white shadow-sm roundes border-top border-warning border-3 d-flex justify-content-center">
					<span class="pt-3">
					<i class="bi bi-tags display-5"></i>
					</span>
					<h1 class="display-1 fw-bold"><?php echo number_format($jk['jumlah']); ?></h1>

				</div>
				<div class="bg-white shadow-sm roundes border-bottom border-warning border-3 d-flex justify-content-center">
					<a href="" class="text-decoration-none"><h6 class="text-center text-dark">Jumlah Kategori</h6></a>
				</div>
			</div>
		</div>
	</div>
	<!-- End Konten -->
<?php include "footer.php"; ?>
	