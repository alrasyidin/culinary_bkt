<?php
    include("connect.php");
    $id_oleh_oleh = $_GET['id_oleh_oleh'];

    $result=  pg_query("SELECT detail_oleh_oleh.id_oleh_oleh,angkot.no_angkot, detail_oleh_oleh.id_angkot,oleh_oleh.nama_oleh_oleh, ST_X(ST_Centroid(oleh_oleh.geom)) AS lng, ST_Y(ST_CENTROID(oleh_oleh.geom)) As lat FROM detail_oleh_oleh left join angkot on detail_oleh_oleh.id_angkot=angkot.id_angkot left join oleh_oleh on detail_oleh_oleh.id_oleh_oleh=oleh_oleh.id_oleh_oleh where detail_oleh_oleh.id_oleh_oleh='$id_oleh_oleh' ");

        while($baris = pg_fetch_array($result))
            {
                $id_angkot=$baris['id_angkot'];
                $id_oleh_oleh=$baris['id_oleh_oleh'];
                $no_angkot=$baris['no_angkot'];
                $nama_oleh_oleh=$baris['nama_oleh_oleh'];
                
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_angkot'=>$id_angkot,'id_oleh_oleh'=>$id_oleh_oleh,'no_angkot'=>$no_angkot,'nama_oleh_oleh'=>$nama_oleh_oleh,"latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>