<?php
require 'connect.php';
$kecamatan_id = $_GET['kecamatan'];
$querysearch	= pg_query ("SELECT 
 oleh_oleh.id_oleh_oleh, 
 oleh_oleh.nama_oleh_oleh,
 oleh_oleh.geom, 
 st_x(st_centroid(oleh_oleh.geom)) as longitude, 
 st_y(st_centroid(oleh_oleh.geom)) as latitude 
 from oleh_oleh, kecamatan 
 WHERE st_contains(kecamatan.geom, st_centroid(oleh_oleh.geom)) and kecamatan.id_kecamatan= '$kecamatan_id'"); 

while($row = pg_fetch_assoc($querysearch))
	$data[]=$row;
echo $_GET['jsoncallback'].''.json_encode($data).'';

?>