<?php
require 'connect.php';
$info = $_GET["info"];
$querysearch ="select id_masjid, nama_masjid, alamat, kapasitas, ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat from masjid where id_masjid='$info'";	   
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_masjid=$row['id_masjid'];
		  $nama_masjid=$row['nama_masjid'];
		  $alamat=$row['alamat'];
		  $kapasitas=$row['kapasitas'];
		   //$foto=$row['foto'];
		  $longitude=$row['lng'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id_masjid'=>$id_masjid,'nama_masjid'=>$nama_masjid,'alamat'=>$alamat,'kapasitas'=>$kapasitas,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>
