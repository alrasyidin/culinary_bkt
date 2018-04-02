<?php
include ('../inc/connect.php');

$id_kuliner	= $_POST['id_kuliner'];
$nama_kuliner = $_POST['nama_kuliner'];

$sql  = "update kuliner set nama_kuliner='$nama_kuliner' where id_kuliner=$id_kuliner";
$insert = pg_query($sql);

if ($insert){
	header("location:../?page=jenisculinary");
}else{
	echo 'error';
}
?>