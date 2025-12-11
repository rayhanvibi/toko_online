<?php  
include "../koneksi.php";

$id = $_GET['id'];

$data = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$id'")->fetch_assoc();

if (!empty($data['foto'])) {
    unlink("../assets/img/".$data['foto']);
}

$koneksi->query("DELETE FROM pelanggan WHERE id_pelanggan='$id'");

echo "<script>alert('Pelanggan berhasil dihapus')</script>";
echo "<script>location='pelanggan.php'</script>";
?>