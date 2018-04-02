<?php
include ('../inc/connect.php');
$id_tempat_kuliner = $_POST['id_tempat_kuliner'];
$nama_tempat_kuliner = $_POST['nama_tempat_kuliner'];
$alamat = $_POST['alamat'];
$cp = $_POST['cp'];
$menu_spesial = $_POST['menu_spesial'];
$jam_buka = $_POST['jam_buka'];
$jam_tutup = $_POST['jam_tutup'];
$kapasitas = $_POST['kapasitas'];
$fasilitas = $_POST['fasilitas'];

$harga = $_POST['harga'];
$jumlah_karyawan = $_POST['jumlah_karyawan'];
$sql = pg_query("update tempat_kuliner set nama_tempat_kuliner='$nama_tempat_kuliner', alamat='$alamat', cp='$cp', menu_spesial='$menu_spesial', jam_buka='$jam_buka', jam_tutup='$jam_tutup', kapasitas='$kapasitas',fasilitas='$fasilitas',  harga='$harga', jumlah_karyawan='$jumlah_karyawan' where id_tempat_kuliner=$id_tempat_kuliner");
if ($sql){
	echo "Success Updated!<br>";
	echo "Back to <a href='../?page=culinary'>Dashboard</a>";
}else {
	echo 'error';
}
?>