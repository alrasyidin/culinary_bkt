<?php

	include('connect.php');
    $latit = $_GET['lat'];
    $longi = $_GET['long'];
	$rad=$_GET['rad'];

	$querysearch="SELECT id_tempat_kuliner, nama_tempat_kuliner, alamat, cp, menu_spesial, jam_buka, jam_tutup, kapasitas, fasilitas, harga, jumlah_karyawan, status_ser, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat, st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) as jarak FROM tempat_kuliner where st_distance_sphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) <= ".$rad.""; 

	$hasil=pg_query($querysearch);

        while($baris = pg_fetch_array($hasil))
            {
                $id_tempat_kuliner=$baris['id_tempat_kuliner'];
                $nama_tempat_kuliner=$baris['nama_tempat_kuliner'];
                $alamat=$baris['alamat'];
                $cp=$baris['cp'];
                $menu_spesial=$baris['menu_spesial'];
                $jam_buka=$baris['jam_buka'];
                $jam_tutup=$baris['jam_tutup'];
                $kapasitas=$baris['kapasitas'];
                $fasilitas=$baris['fasilitas'];
                $harga=$baris['harga'];
                $jumlah_karyawan=$baris['jumlah_karyawan'];
                $status_ser=$baris['status_ser'];
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_tempat_kuliner'=>$id_tempat_kuliner,'nama_tempat_kuliner'=>$nama_tempat_kuliner,'alamat'=>$alamat,'cp'=>$cp, 'menu_spesial'=>$menu_spesial, 'jam_buka'=>$jam_buka, 'jam_tutup'=>$jam_tutup, 'kapasitas'=>$kapasitas, 'fasilitas'=>$fasilitas, 'harga'=>$harga, 'jumlah_karyawan'=>$jumlah_karyawan, 'status_ser'=>$status_ser, 'harga'=>$harga,  "latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>