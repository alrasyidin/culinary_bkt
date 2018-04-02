<?php
include('Connect.php');
$latit=$_GET["lat"];
$longi=$_GET["lng"];
$rad=$_GET["rad"];


$querysearch="SELECT id_tempat_wisata, nama_tempat_wisata,lokasi, st_x(st_centroid(geom)) as lon,st_y(st_centroid(geom)) as lat,
	st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), tempat_wisata.geom) as jarak 
	FROM tempat_wisata where st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1),
	 tempat_wisata.geom) <= ".$rad."	
			 "; 
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_tempat_wisata=$row['id_tempat_wisata'];
		  $nama_tempat_wisata=$row['nama_tempat_wisata'];
		  $lokasi=$row['lokasi'];
		  $longitude=$row['lon'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id_tempat_wisata'=>$id_tempat_wisata,'nama_tempat_wisata'=>$nama_tempat_wisata,'lokasi'=>$lokasi,
		  'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>