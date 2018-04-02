<?php
    include("connect.php");
$cari = $_GET["cari"];
$id11 = $_GET["id11"];
$id22 = $_GET["id22"];
        $querysearch= "SELECT distinct kecamatan.*,industri_kecil_region.*,jenis_industri.*,status_tempat.*, ST_X(ST_CENTROID(industri_kecil_region.geom)) as lon,ST_Y(ST_CENTROID(industri_kecil_region.geom)) as lat 
                            from kecamatan, industri_kecil_region join status_tempat on industri_kecil_region.id_status_tempat=status_tempat.id_status_tempat 
                            join jenis_industri on
                            industri_kecil_region.id_jenis_industri=jenis_industri.id_jenis_industri 
                            where ST_CONTAINS(kecamatan.geom, ST_CENTROID(industri_kecil_region.geom)) and kecamatan.id_kecamatan='$id22' and jenis_industri.id_jenis_industri='$id11' and status_tempat.id_status_tempat = '$cari' order by industri_kecil_region.nama_industri ASC";

                            

        $hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
    {
          $id=$row['id'];
          $nama_industri=$row['nama_industri'];
          
          $nama_jenis_industri=$row['nama_jenis_industri'];
          $id_kecamatan=$row['id_kecamatan'];
          $status=$row['status'];
          $longitude=$row['lon'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id,'nama_industri'=>$nama_industri,'nama_jenis_industri'=>$nama_jenis_industri,'id_kecamatan'=>$id_kecamatan,'status'=>$status,'lon'=>$longitude,'lat'=>$latitude);
    }
            echo json_encode ($dataarray);
?>
