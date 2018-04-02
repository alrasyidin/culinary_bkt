<?php
require 'connect.php';
$info = $_GET["info"];
$querysearch ="select id_hotel, nama_hotel, alamat, fasilitas, tipe_kamar, harga, ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat from hotel where id_hotel='$info'";	   
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_hotel=$row['id_hotel'];
		  $nama_hotel=$row['nama_hotel'];
		  $alamat=$row['alamat'];
		  $fasilitas=$row['fasilitas'];
		  $tipe_kamar=$row['tipe_kamar'];
		  $harga=$row['harga'];
		   //$foto=$row['foto'];
		  $longitude=$row['lng'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id_hotel'=>$id_hotel,'nama_hotel'=>$nama_hotel,'alamat'=>$alamat,'fasilitas'=>$fasilitas,'tipe_kamar'=>$tipe_kamar,'harga'=>$harga,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>
