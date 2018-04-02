<?php
include('Connect.php');
$latit=$_GET["lat"];
$longi=$_GET["lng"];
$rad=$_GET["rad"];


$querysearch="SELECT id_masjid, nama_masjid,alamat, st_x(st_centroid(geom)) as lon,st_y(st_centroid(geom)) as lat,
	st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), masjid.geom) as jarak 
	FROM masjid where st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1),
	 masjid.geom) <= ".$rad."	
			 "; 
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_masjid=$row['id_masjid'];
		  $nama_masjid=$row['nama_masjid'];
		  $alamat=$row['alamat'];
		  $longitude=$row['lon'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id_masjid'=>$id_masjid,'nama_masjid'=>$nama_masjid,'alamat'=>$alamat,
		  'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>