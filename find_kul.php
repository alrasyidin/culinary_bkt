<?php
require 'connect.php';
$cari_nama = $_GET["cari_nama"];
$querysearch	="SELECT distinct id_tempat_kuliner, nama_tempat_kuliner,alamat, st_x(st_centroid(geom)) as longitude, 
st_y(st_centroid(geom)) as latitude from tempat_kuliner where lower(nama_tempat_kuliner)like lower('%$cari_nama%')"; 
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_tempat_kuliner=$row['id_tempat_kuliner'];
		  $nama_tempat_kuliner=$row['nama_tempat_kuliner'];
		  
		  $alamat=$row['alamat'];
		  $longitude=$row['longitude'];
		  $latitude=$row['latitude'];
		  $dataarray[]=array('id_tempat_kuliner'=>$id_tempat_kuliner,'nama_tempat_kuliner'=>$nama_tempat_kuliner,'alamat'=>$alamat,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>