<?php
require 'connect.php';
$cari_nama = $_GET["cari_nama"];
$querysearch	="SELECT distinct id, nama_industri,pemilik, alamat, st_x(st_centroid(geom)) as longitude, 
st_y(st_centroid(geom)) as latitude from industri_kecil_region where lower(nama_industri)like lower('%$cari_nama%')"; 
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id=$row['id'];
		  $nama_industri=$row['nama_industri'];
		  $pemilik=$row['pemilik'];
		  $alamat=$row['alamat'];
		  $longitude=$row['longitude'];
		  $latitude=$row['latitude'];
		  $dataarray[]=array('id'=>$id,'nama_industri'=>$nama_industri,'pemilik'=>$pemilik,'alamat'=>$alamat,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>