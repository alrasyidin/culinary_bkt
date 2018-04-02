<?php
require 'connect.php';
$cari_nama = $_GET["cari_nama"];
$querysearch	="SELECT distinct id_oleh_oleh, nama_oleh_oleh,pemilik, alamat, st_x(st_centroid(geom)) as longitude, 
st_y(st_centroid(geom)) as latitude from oleh_oleh where lower(nama_oleh_oleh)like lower('%$cari_nama%')"; 
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_oleh_oleh=$row['id_oleh_oleh'];
		  $nama_oleh_oleh=$row['nama_oleh_oleh'];
		  $pemilik=$row['pemilik'];
		  $alamat=$row['alamat'];
		  $longitude=$row['longitude'];
		  $latitude=$row['latitude'];
		  $dataarray[]=array('id_oleh_oleh'=>$id_oleh_oleh,'nama_oleh_oleh'=>$nama_oleh_oleh,'pemilik'=>$pemilik,'alamat'=>$alamat,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>