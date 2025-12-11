<?php include "koneksi.php";
 ?>
<!DOCTYPE html>
<html>
<head>

	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-secondary">

	<div class="container mt-5">
		<div class="row mt-4">
			<div class="col-md-4 offset-md-4 shadow rounded bg-white p-3">
				<form method="post">
					<div>
						<h6 class="text-center">Login</h6>
					</div>
					<div class="mb-3">
						<label>Username</label>
							<input type="text" name="username" class="form-control" required>
					</div>
					<!--  -->
					<div class="mb-3">
						<label>Password</label>
						<input type="password" name="password" class="form-control" required>
						
					</div>
					<button name="masuk" class="btn btn-primary">Masuk</button>

					<p class="text-center">- Atau - </p>

					<p class="text-center">Belum punya akun? <a href="daftar.php">Daftar</a></p>
				</form>
			</div>
		</div>
	</div>

</body>
</html>
<?php 
   if (isset($_POST['masuk'])) {
	  $us = $_POST['username'];
	  $pw = sha1($_POST['password']);

	
	  $aa = $koneksi->query("SELECT * FROM admin WHERE username='$us' AND password ='$pw'");
	  $ap = $koneksi->query("SELECT * FROM pelanggan WHERE username='$us' AND password ='$pw'");


	  //validasi login
	  if ($aa->num_rows==1) {
	  	$_SESSION['admin'] = $aa->fetch_assoc();
	  	echo "<script>alert('Berhasil Login')</script>";
	  	echo "<script>location='admin/index.php'</script>";
	  	
	  }
	  elseif ($ap->num_rows==1) {
	  	$_SESSION['pelanggan'] = $ap->fetch_assoc();
	  	echo "<script>alert('Berhasil Login')</script>";
	  	echo "<script>location='index.php'</script>";
	  	
	  }
	  else{
	  	echo "<script>alert('Gagal Login')</script>";
	  	echo "<script>location='login.php'</script>";
	  	
	  	
	  	}
	  }
?>