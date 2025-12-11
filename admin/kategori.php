<?php include "header.php"; ?>
<?php  
$Kategori = [];
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($detail = $ambil->fetch_assoc()) {
	$kategori[] = $detail;
}
?>
<div class="container mt-3">
	<div class="card">
		<div class="card-header bg-primary-subtle "><h6>Data Kategori</h6></div>
		
		<div class="card-body table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Foto</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($kategori as $kk => $va): ?>
						<tr>
							<td><?php echo $kk+1; ?></td>
							<td><?php echo $va['nama_kategori']; ?></td>
							<td>
								<?php if (!empty($va['foto_kategori'])): ?>
									<img src="../assets/img/<?php echo $va['foto_kategori']; ?>" width="70" class="rounded">
								<?php else: ?>
									<span class="text-muted">Tidak ada foto</span>
								<?php endif; ?>
							</td>
							<td>
								<a href="kategori_ubah.php?id=<?php echo $va['id_kategori']; ?>" class="btn btn-warning btn-sm">Ubah</a>
								<a href="kategori_hapus.php?id=<?php echo $va['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a>
							</td>
						</tr>
						
					<?php endforeach ?>
				</tbody>
			</table>
			<a href="kategori_tambah.php" class="btn btn-primary">
				<i class="bi bi-plus-circle"></i> Tambah Kategori
			</a>

		</div>
	</div>
</div>
<?php include "footer.php"; ?>