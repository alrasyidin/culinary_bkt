<?php
require 'connect.php';
$info = $_GET["info"];
$querysearch ="select id_tempat_wisata, nama_tempat_wisata, lokasi, jam_buka, jam_tutup, biaya, fasilitas, ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat from tempat_wisata where id_tempat_wisata='$info'";	   
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_tempat_wisata=$row['id_tempat_wisata'];
		  $nama_tempat_wisata=$row['nama_tempat_wisata'];
		  $lokasi=$row['lokasi'];
		  $jam_buka=$row['jam_buka'];
		  $jam_tutup=$row['jam_tutup'];
		  $biaya=$row['biaya'];
		  $fasilitas=$row['fasilitas'];
		   //$foto=$row['foto'];
		  $longitude=$row['lng'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id_tempat_wisata'=>$id_tempat_wisata,'nama_tempat_wisata'=>$nama_tempat_wisata,'lokasi'=>$lokasi,'jam_buka'=>$jam_buka,'jam_tutup'=>$jam_tutup,'biaya'=>$biaya,'fasilitas'=>$fasilitas,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>
