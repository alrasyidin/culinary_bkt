<?php

	include('connect.php');
    $latit = $_GET['lat'];
    $longi = $_GET['long'];
	$rad=$_GET['rad'];

	$querysearch="SELECT id_masjid, nama_masjid, alamat, kapasitas, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat, st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) as jarak FROM masjid where st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) <= ".$rad.""; 

	$hasil=pg_query($querysearch);

    while($baris = pg_fetch_array($hasil))
        {
            $id_masjid=$baris['id_masjid'];
            $nama_masjid=$baris['nama_masjid'];
            $alamat=$baris['alamat'];
            $kapasitas=$baris['kapasitas'];
            $latitude=$baris['lat'];
            $longitude=$baris['lng'];
            $dataarray[]=array('id_masjid'=>$id_masjid,'nama_masjid'=>$nama_masjid,'alamat'=>$alamat,'kapasitas'=>$kapasitas,  "latitude"=>$latitude,"longitude"=>$longitude);
        }
        echo json_encode ($dataarray);
?>