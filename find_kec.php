<?php
require 'connect.php';
$kecamatan_id = $_GET['kecamatan'];
$querysearch	= pg_query ("SELECT 
 industri_kecil_region.id, 
 industri_kecil_region.nama_industri,
 industri_kecil_region.geom, 
 st_x(st_centroid(industri_kecil_region.geom)) as longitude, 
 st_y(st_centroid(industri_kecil_region.geom)) as latitude 
 from industri_kecil_region, kecamatan 
 WHERE st_contains(kecamatan.geom, st_centroid(industri_kecil_region.geom)) and kecamatan.id_kecamatan= '$kecamatan_id'"); 

while($row = pg_fetch_assoc($querysearch))
	$data[]=$row;
echo $_GET['jsoncallback'].''.json_encode($data).'';

?>