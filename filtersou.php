<?php
    include("connect.php");
$carii = $_GET["carii"];
$id1111 = $_GET["id1111"];
$id2222 = $_GET["id2222"];
        $querysearch= "SELECT distinct kecamatan.*,oleh_oleh.*,jenis_oleh_oleh.*,status_tempat.*, ST_X(ST_CENTROID(oleh_oleh.geom)) as lon,ST_Y(ST_CENTROID(oleh_oleh.geom)) as lat 
                            from kecamatan, oleh_oleh join status_tempat on oleh_oleh.id_status_tempat=status_tempat.id_status_tempat 
                            join jenis_oleh_oleh on
                            oleh_oleh.id_jenis_oleh=jenis_oleh_oleh.id_jenis_oleh 
                            where ST_CONTAINS(kecamatan.geom, ST_CENTROID(oleh_oleh.geom)) and kecamatan.id_kecamatan='$id2222' and jenis_oleh_oleh.id_jenis_oleh='$id1111' and status_tempat.id_status_tempat = '$carii' order by oleh_oleh.nama_oleh_oleh ASC";


        $hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
    {
          $id_oleh_oleh=$row['id_oleh_oleh'];
          $nama_oleh_oleh=$row['nama_oleh_oleh'];
          
          $jenis_oleh=$row['jenis_oleh'];
          $id_kecamatan=$row['id_kecamatan'];
          $status=$row['status'];
          $longitude=$row['lon'];
          $latitude=$row['lat'];
          $dataarray[]=array('id_oleh_oleh'=>$id_oleh_oleh,'nama_oleh_oleh'=>$nama_oleh_oleh,'jenis_oleh'=>$jenis_oleh,'id_kecamatan'=>$id_kecamatan,'status'=>$status,'lon'=>$longitude,'lat'=>$latitude);
    }
            echo json_encode ($dataarray);
?>
