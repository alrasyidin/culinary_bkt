<?php
require 'connect.php';
$info = $_GET["info"];
$querysearch ="select id_tempat_kuliner, nama_tempat_kuliner, alamat, cp, menu_spesial, jam_buka, jam_tutup,foto,harga, ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat from tempat_kuliner where id_tempat_kuliner='$info'";	   
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_tempat_kuliner=$row['id_tempat_kuliner'];
		  $nama_tempat_kuliner=$row['nama_tempat_kuliner'];
		  $alamat=$row['alamat'];
		  $cp=$row['cp'];
		  $menu_spesial=$row['menu_spesial'];
		  $jam_buka=$row['jam_buka'];
		  $jam_tutup=$row['jam_tutup'];
		  $harga=$row['harga'];
		  
		   $foto=$row['foto'];
		  $longitude=$row['lng'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id_tempat_kuliner'=>$id_tempat_kuliner,'nama_tempat_kuliner'=>$nama_tempat_kuliner,'alamat'=>$alamat,'cp'=>$cp,'menu_spesial'=>$menu_spesial,'jam_tutup'=>$jam_tutup,'jam_buka'=>$jam_buka,'harga'=>$harga,'foto'=>$foto,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>
