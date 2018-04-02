<?php
require 'connect.php';
$cari_jenis = $_GET["cari_jenis"];
$querysearch	="SELECT distinct id, nama_industri,id_jenis_industri, st_x(st_centroid(geom)) as longitude, 
st_y(st_centroid(geom)) as latitude from industri_kecil_region where id_jenis_industri='$cari_jenis'"; 
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id=$row['id'];
		  $nama_industri=$row['nama_industri'];
		  $id_jenis_industri=$row['id_jenis_industri'];
		  
		  $longitude=$row['longitude'];
		  $latitude=$row['latitude'];
		  $dataarray[]=array('id'=>$id,'nama_industri'=>$nama_industri,'id_jenis_industri'=>$id_jenis_industri,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>