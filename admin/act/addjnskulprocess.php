<?php
include ('../inc/connect.php');
$id_kuliner = $_POST['id_kuliner'];
$nama_kuliner = $_POST['nama_kuliner'];


$sql = pg_query("insert into kuliner (id_kuliner, nama_kuliner) values ('$id_kuliner', '$nama_kuliner')");


if ($sql){
	header("location:../?page=jenisculinary");
}else{
	echo 'error';
}

?>