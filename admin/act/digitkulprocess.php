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
$harga1 = $_POST['hargastart'];
$harga2 = $_POST['hargaend'];
$jumlah_karyawan = $_POST['jumlah_karyawan'];

$geom = $_POST['geom'];
$jenis_gambar=$_FILES['image']['type'];
	if(($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif"  || $jenis_gambar=="image/png") && ($_FILES["image"]["size"] <= 500000)){
		$sourcename=$_FILES["image"]["name"];
		$name=$id_tempat_kuliner.'_'.$sourcename;
		$filepath="../../image/".$name;
		move_uploaded_file($_FILES["image"]["tmp_name"],$filepath);
	}
	else if ($foto=='null' || $foto=='' || $foto==null)
	{
		$foto = 'foto.jpg';
	}

$sql = pg_query("insert into tempat_kuliner (foto, id_tempat_kuliner, nama_tempat_kuliner, alamat, cp, menu_spesial,jam_buka, jam_tutup, kapasitas, fasilitas, harga, jumlah_karyawan,  geom) values ('$name','$id_tempat_kuliner', '$nama_tempat_kuliner', '$alamat', '$cp', '$menu_spesial', '$jam_buka', '$jam_tutup', '$kapasitas', '$fasilitas','$harga1 - $harga2', '$jumlah_karyawan',  ST_GeomFromText('$geom'))");


if ($sql){
	header("location:../?page=forml&id_tempat_kuliner=$id_tempat_kuliner");
	// echo "Success Create Data!<br>";
	// echo "Back to <a href='../?page=culinary'>Dashboard</a>";
}else{
	echo 'error';
}

?>