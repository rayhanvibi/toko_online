<?php  
if (empty($_SESSION['pelanggan'])){
	echo "<script>alert('Anda Harus Login')</script>";
	echo "<script>location='index.php'</script>";
}
include "koneksi.php";
session_destroy();
unset($_SESSION);
	echo "<script>alert('Berhasil Log Out')</script>";
	echo "<script>location='index.php'</script>";

?>
