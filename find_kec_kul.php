<?php
require 'connect.php';
$kecamatan_id = $_GET['kecamatan'];
$querysearch	= pg_query ("SELECT 
 tempat_kuliner.id_tempat_kuliner, 
 tempat_kuliner.nama_tempat_kuliner,
 tempat_kuliner.geom, 
 st_x(st_centroid(tempat_kuliner.geom)) as longitude, 
 st_y(st_centroid(tempat_kuliner.geom)) as latitude 
 from tempat_kuliner, kecamatan 
 WHERE st_contains(kecamatan.geom, st_centroid(tempat_kuliner.geom)) and kecamatan.id_kecamatan= '$kecamatan_id'"); 

while($row = pg_fetch_assoc($querysearch))
	$data[]=$row;
echo $_GET['jsoncallback'].''.json_encode($data).'';

?>