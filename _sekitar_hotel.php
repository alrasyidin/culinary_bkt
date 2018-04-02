<?php

	include('connect.php');
    $latit = $_GET['lat'];
    $longi = $_GET['long'];
	$rad=$_GET['rad'];

	$querysearch="SELECT id_hotel, nama_hotel, alamat, cp, fasilitas, tipe_kamar, harga, syarat_menginap, keterangan, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat, st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")'), geom) as jarak FROM hotel where st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")'), geom) <= ".$rad.""; 

	$hasil=pg_query($querysearch);

        while($baris = pg_fetch_array($hasil))
            {
                $id_hotel=$baris['id_hotel'];
                $nama_hotel=$baris['nama_hotel'];
                $alamat=$baris['alamat'];
                $cp=$baris['cp'];
                $fasilitas=$baris['fasilitas'];
                $tipe_kamar=$baris['tipe_kamar'];
                $harga=$baris['harga'];
                $syarat_menginap=$baris['syarat_menginap'];
                $keterangan=$baris['keterangan'];
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_hotel'=>$id_hotel,'nama_hotel'=>$nama_hotel,'alamat'=>$alamat,'cp'=>$cp, 'fasilitas'=>$fasilitas, 'tipe_kamar'=>$tipe_kamar, 'harga'=>$harga, 'syarat_menginap'=>$syarat_menginap, 'keterangan'=>$keterangan,  "latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>