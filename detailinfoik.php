<?php
require 'connect.php';
$info = $_GET["info"];
$querysearch ="select id, nama_industri, alamat, produk, pemilik, harga_barang, foto, cp,ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat from industri_kecil_region where id='$info'";	   
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		  $id=$row['id'];
		  $nama_industri=$row['nama_industri'];
		  $alamat=$row['alamat'];
		  $cp=$row['cp'];
		  $produk=$row['produk'];
		  $harga_barang=$row['harga_barang'];
		  $pemilik=$row['pemilik'];
		   $foto=$row['foto'];
		  $longitude=$row['lng'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id'=>$id,'nama_industri'=>$nama_industri,'alamat'=>$alamat,'produk'=>$produk,'harga_barang'=>$harga_barang,'pemilik'=>$pemilik,'foto'=>$foto,'cp'=>$cp,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>
