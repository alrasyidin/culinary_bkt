<?php

	include('connect.php');
    $latit = $_GET['lat'];
    $longi = $_GET['long'];
	$rad=$_GET['rad'];

	$querysearch="SELECT id_tempat_wisata, nama_tempat_wisata, lokasi, jam_buka, jam_tutup, biaya, fasilitas, keterangan, st_x(st_centroid_tempat_wisata(geom)) as lng, st_y(st_centroid_tempat_wisata(geom)) as lat, st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) as jarak FROM tempat_wisata where st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) <= ".$rad.""; 

	$hasil=pg_query($querysearch);

        while($baris = pg_fetch_array($hasil))
            {
                $id_tempat_wisata_tempat_wisata=$baris['id_tempat_wisata'];
                $nama_tempat_wisata=$baris['nama_tempat_wisata'];
                $lokasi=$baris['lokasi'];
                $jam_buka=$baris['jam_buka'];
                $jam_tutup=$baris['jam_tutup'];
                $biaya=$baris['biaya'];
                $fasilitas=$baris['fasilitas'];
                $keterangan=$baris['keterangan'];
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_tempat_wisata_tempat_wisata'=>$id_tempat_wisata_tempat_wisata,'nama_tempat_wisata'=>$nama_tempat_wisata,'lokasi'=>$lokasi,'jam_buka'=>$jam_buka,'jam_tutup'=>$jam_tutup,'biaya'=>$biaya,'fasilitas'=>$fasilitas,'keterangan'=>$keterangan, "latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>