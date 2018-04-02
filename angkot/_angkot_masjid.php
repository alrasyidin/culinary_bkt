<?php
    include("connect.php");
    $id_angkot = $_GET['id_angkot'];

    $result=  pg_query("SELECT detail_angkot_masjid.id_masjid,_masjid.nama_masjid,_masjid.alamat, _masjid.kapasitas, ST_X(ST_Centroid(_masjid.geom)) AS lng, ST_Y(ST_CENTROID(_masjid.geom)) As lat FROM detail_angkot_masjid left join _masjid on detail_angkot_masjid.id_masjid=_masjid.id_masjid where detail_angkot_masjid.id_angkot='$id_angkot' ");

        while($baris = pg_fetch_array($result))
            {
                $id_angkot=$baris['id_angkot'];
                $id_masjid=$baris['id_masjid'];
                $nama=$baris['nama_masjid'];
                $alamat=$baris['alamat'];
                $kapasitas=$baris['kapasitas'];
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_angkot'=>$id_angkot,'id_masjid'=>$id_masjid,'nama'=>$nama,'alamat'=>$alamat,'kapasitas'=>$kapasitas,  "latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>