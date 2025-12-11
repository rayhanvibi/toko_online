<?php include "header.php"; ?>
<?php  

$id_admin = $_SESSION['admin']['id_admin'];

$admin = $koneksi->query("SELECT * FROM admin WHERE id_admin='$id_admin'")->fetch_assoc();

?>

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary-subtle"><h6>Ubah Akun</h6></div>
        <div class="card-body table-responsive">
        <form method="post" enctype="multipart/form-data">
        	
        	<div class="mb-3">
        		<label>Username</label>
        		<input type="text" name="username" value="<?php echo $admin['username'] ?>" class="form-control">
        	</div> 
            <div class="mb-3">
                <label>Password</label>
                <input type="text" name="password" value="" class="form-control">
                <span class="text-danger">*) Jika tidak diubah maka kosongkan</span>
            </div>
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" value="<?php echo $admin['nama'] ?>" class="form-control">
            </div> 
        	
        	<button class="btn btn-primary" name="simpan">Simpan</button>
        </form>
        </div>
    </div>
</div>

<?php if (isset($_POST['simpan'])) {
	
	$username = $_POST['username'];
	$nama = $_POST['nama'];
	$password = $_POST['password'];
	$pe = sha1('$password');


	
    if (empty($password)) {
        $koneksi->query("UPDATE admin SET username='$username',
            nama='$nama' WHERE id_admin='$id_admin'");
    }
    else{
  $koneksi->query("UPDATE admin SET username='$username',
            nama='$nama',
            password='$pe' WHERE id_admin='$id_admin'");
    }

	echo "<script>alert('Berhasil Terubah')</script>";
	echo "<script>location='akun.php'</script>";
}
 ?>
<?php include "footer.php"; ?>
