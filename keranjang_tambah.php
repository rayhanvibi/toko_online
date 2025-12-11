<?php  
include "koneksi.php";

$id_produk = $_GET['id'];

if (empty($id_produk)) {
    echo "<script>alert('data produk tidak ditemukan')</script>";
    echo "<script>location='produk.php'</script>";
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

if (empty($id_pelanggan)) {
    echo "<script>alert('data pelanggan tidak ditemukan')</script>";
    echo "<script>location='index.php'</script>";
}

$cek_keranjang = $koneksi->query("SELECT * FROM keranjang WHERE id_pelanggan='$id_pelanggan' AND id_produk='$id_produk'");

if ($cek_keranjang->num_rows == 1) {
    // update keranjang ++
    $keranjang = $cek_keranjang->fetch_assoc();
    $jml = $keranjang['jumlah'] + 1;
    $koneksi->query("UPDATE keranjang SET jumlah='$jml' WHERE id_keranjang");
} 
else {
    // buat keranjang baru
    $jumlah = 1;
    $koneksi->query("INSERT keranjang (id_pelanggan,id_produk,jumlah) VALUES('$id_pelanggan', '$id_produk', '$jumlah')");
}

echo "<script>alert('Produk telah ditambahkan pada keranjang')</script>";
echo "<script>location='keranjang.php'</script>";
?>