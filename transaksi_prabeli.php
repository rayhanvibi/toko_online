<?php 
include "koneksi.php";

$id_keranjang = $_GET['id_keranjang'];

$keranjang = $koneksi->query("SELECT * FROM keranjang LEFT JOIN produk ON produk.id_produk = keranjang.id_produk WHERE id_keranjang='$id_keranjang'")->fetch_assoc();

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
$tanggal_transaksi = date ('y-m-d');
$status_transaksi = "menunggu pembayaran";

// simpan ke tabel transaksi 
$koneksi->query("INSERT transaksi(id_pelanggan,tanggal_transaksi,status_transaksi) VALUES('$id_pelanggan','$tanggal_transaksi','$status_transaksi')");

$id_transaksi = $koneksi->insert_id;
$id_produk = $keranjang['id_produk'];
$harga = $keranjang['harga_produk'];
$jumlah = $keranjang['jumlah'];

//simpan ke tabel transaksi_produk
$koneksi->query("INSERT INTO transaksi_produk(id_transaksi,id_produk,harga,jumlah) VALUES('$id_transaksi','$id_produk','$harga','$jumlah')");

//hapus tabel keranjang
$koneksi->query("DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'");

echo "<script>alert('sukses')</script>;";
echo "<script>location='transaksi_detail.php?id_transaksi=$id_transaksi'</script>";
 
 ?>
