<?php
    include("connect.php");
    $id = $_GET['id'];

    $result=  pg_query("SELECT detail_industri.id,angkot.no_angkot, detail_industri.id_angkot,industri_kecil_region.nama_industri, ST_X(ST_Centroid(industri_kecil_region.geom)) AS lng, ST_Y(ST_CENTROID(industri_kecil_region.geom)) As lat FROM detail_industri left join angkot on detail_industri.id_angkot=angkot.id_angkot left join industri_kecil_region on detail_industri.id=industri_kecil_region.id where detail_industri.id='$id' ");

        while($baris = pg_fetch_array($result))
            {
                $id_angkot=$baris['id_angkot'];
                $id=$baris['id'];
                $no_angkot=$baris['no_angkot'];
                $nama_industri=$baris['nama_industri'];
                
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_angkot'=>$id_angkot,'id'=>$id,'no_angkot'=>$no_angkot,'nama_industri'=>$nama_industri,"latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>