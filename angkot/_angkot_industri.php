<?php
    include("connect.php");
    $id_angkot = $_GET['id_angkot'];

    $result=  pg_query("SELECT detail_industri.id,industri_kecil_region.nama_industri, detail_industri.id_angkot, ST_X(ST_Centroid(industri_kecil_region.geom)) AS lng, ST_Y(ST_CENTROID(industri_kecil_region.geom)) As lat FROM detail_industri left join industri_kecil_region on detail_industri.id=industri_kecil_region.id where detail_industri.id_angkot='$id_angkot' ");

        while($baris = pg_fetch_array($result))
            {
                $id_angkot=$baris['id_angkot'];
                $id=$baris['id'];
                $nama_industri=$baris['nama_industri'];
                
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_angkot'=>$id_angkot,'id'=>$id,'nama_industri'=>$nama_industri,"latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>