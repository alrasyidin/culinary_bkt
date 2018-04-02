<?php
require 'connect.php';
$info = $_GET["info"];
$querysearch ="select id_oleh_oleh, nama_oleh_oleh, pemilik, produk, harga_barang, alamat, foto, cp,ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat from oleh_oleh where id_oleh_oleh='$info'";	   
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id_oleh_oleh=$row['id_oleh_oleh'];
		  $nama_oleh_oleh=$row['nama_oleh_oleh'];
		  $alamat=$row['alamat'];
		  $cp=$row['cp'];
		  $pemilik=$row['pemilik'];
		  $produk=$row['produk'];
		  $harga_barang=$row['harga_barang'];
		   $foto=$row['foto'];
		  $longitude=$row['lng'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id_oleh_oleh'=>$id_oleh_oleh,'nama_oleh_oleh'=>$nama_oleh_oleh,'alamat'=>$alamat,'pemilik'=>$pemilik,'produk'=>$produk,'harga_barang'=>$harga_barang,'foto'=>$foto,'cp'=>$cp,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>
