<?php  
include "koneksi.php";

$id_produk = $_GET['id_produk'];

if (empty($id_produk)) {
    echo "<script>alert('data produk tidak ditemukan')</script>";
    echo "<script>location='produk.php'</script>";
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

if (empty($id_pelanggan)) {
    echo "<script>alert('data pelanggan tidak ditemukan')</script>";
    echo "<script>location='index.php'</script>";
}

$keranjang = $koneksi->query("SELECT * FROM keranjang WHERE id_pelanggan='$id_pelanggan' AND id_produk='$id_produk'")->fetch_assoc();

if (empty($keranjang) && $keranjang['jumlah']== 1) {
    // hapus keranjang
    $koneksi->query("DELETE FROM keranjang WHERE 'id_pelanggan' AND id_produk='id_produk'");   
} 
else {
    // kurangi keranjang
    $jml = $keranjang['jumlah']-1;
    $koneksi->query("UPDATE keranjang SET jumlah='$jml' WHERE id_keranjang");
}

echo "<script>alert('Produk berhasil dikurangi pada keranjang')</script>";
echo "<script>location='keranjang.php'</script>";
?>