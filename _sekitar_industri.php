<?php

	include('connect.php');
    $latit = $_GET['lat'];
    $longi = $_GET['long'];
	$rad=$_GET['rad'];

	$querysearch="SELECT id, nama_industri, alamat, cp, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat, st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) as jarak FROM industri_kecil_region where st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) <= ".$rad.""; 

	$hasil=pg_query($querysearch);
        while($baris = pg_fetch_array($hasil))
            {
                $id=$baris['id'];
                $nama_industri=$baris['nama_industri'];
                $alamat=$baris['alamat'];
                $cp=$baris['cp'];
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id'=>$id,'cp'=>$cp,'alamat'=>$alamat, 'nama_industri'=>$nama_industri,"latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>