<?php
include ('../inc/connect.php');
$id_tempat_kuliner = $_POST['id_tempat_kuliner'];
$geom = $_POST['geom'];
$sql = pg_query("update tempat_kuliner set geom=ST_GeomFromText('$geom', 4326) where id_tempat_kuliner='$id_tempat_kuliner'");
if ($sql){
	header("location:../?page=detailculinary&id_tempat_kuliner=$id_tempat_kuliner");
}else {
	echo 'error';
}
?>