<?php 
include '../koneksi.php';

$id_kategori = $_GET['id'];

// Ambil data kategori
$kategori = $koneksi->query("SELECT * FROM kategori WHERE id_kategori = '$id_kategori' ")->fetch_assoc();

// Hapus foto kategori jika ada
if (!empty($kategori['foto_kategori'])) {
    unlink('../assets/img/' . $kategori['foto_kategori']);
}

// Hapus data kategori dari database
$koneksi->query("DELETE FROM kategori WHERE id_kategori='$id_kategori'");

echo "<script>alert('Berhasil Terhapus')</script>";
echo "<script>location='kategori.php'</script>";

?>