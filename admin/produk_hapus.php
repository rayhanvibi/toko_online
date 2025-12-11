<?php 
include '../koneksi.php';

$id_produk = $_GET['id'];

$produk = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id_produk' ")->fetch_assoc();

unlink('../assets/img/'.$produk['foto_produk']);

$koneksi->query("DELETE FROM produk WHERE id_produk='$id_produk'");

echo "<script>alert('Berhasil Terhapus')</script>";
	echo "<script>location='produk.php'</script>";
	
 ?>