<?php
    include("connect.php");
    $id_tempat_kuliner = $_GET['id_tempat_kuliner'];

    $result=  pg_query("SELECT detail_tempat_kuliner.id_tempat_kuliner,angkot.no_angkot, detail_tempat_kuliner.id_angkot,tempat_kuliner.nama_tempat_kuliner, ST_X(ST_Centroid(tempat_kuliner.geom)) AS lng, ST_Y(ST_CENTROID(tempat_kuliner.geom)) As lat FROM detail_tempat_kuliner left join angkot on detail_tempat_kuliner.id_angkot=angkot.id_angkot left join tempat_kuliner on detail_tempat_kuliner.id_tempat_kuliner=tempat_kuliner.id_tempat_kuliner where detail_tempat_kuliner.id_tempat_kuliner='$id_tempat_kuliner' ");

        while($baris = pg_fetch_array($result))
            {
                $id_angkot=$baris['id_angkot'];
                $id_tempat_kuliner=$baris['id_tempat_kuliner'];
                $no_angkot=$baris['no_angkot'];
                $nama_tempat_kuliner=$baris['nama_tempat_kuliner'];
                
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_angkot'=>$id_angkot,'id_tempat_kuliner'=>$id_tempat_kuliner,'no_angkot'=>$no_angkot,'nama_tempat_kuliner'=>$nama_tempat_kuliner,"latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>