<?php
require 'connect.php';
$cari_jenis = $_GET["cari_jenis"];
$querysearch	="SELECT distinct id_oleh_oleh, nama_oleh_oleh,id_jenis_oleh, st_x(st_centroid(geom)) as longitude, 
st_y(st_centroid(geom)) as latitude from oleh_oleh where id_jenis_oleh='$cari_jenis'"; 
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_oleh_oleh=$row['id_oleh_oleh'];
		  $nama_oleh_oleh=$row['nama_oleh_oleh'];
		  $id_jenis_oleh=$row['id_jenis_oleh'];
		  
		  $longitude=$row['longitude'];
		  $latitude=$row['latitude'];
		  $dataarray[]=array('id_oleh_oleh'=>$id_oleh_oleh,'nama_oleh_oleh'=>$nama_oleh_oleh,'id_jenis_oleh'=>$id_jenis_oleh,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>