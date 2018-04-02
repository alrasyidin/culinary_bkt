<?php
    include("connect.php");
    $id_angkot = $_GET['id_angkot'];

    $result=  pg_query("SELECT detail_angkot_oleh.id_oleh_oleh,_oleholeh.nama_oleh_oleh,_oleholeh.pemilik, _oleholeh.cp, _oleholeh.alamat, _oleholeh.produk, _oleholeh.harga_barang, ST_X(ST_Centroid(_oleholeh.geom)) AS lng, ST_Y(ST_CENTROID(_oleholeh.geom)) As lat FROM detail_angkot_oleh left join _oleholeh on detail_angkot_oleh.id_oleh_oleh=_oleholeh.id_oleh_oleh where detail_angkot_oleh.id_angkot='$id_angkot' ");

        while($baris = pg_fetch_array($result))
            {
                $id_angkot=$baris['id_angkot'];
                $id_oleh_oleh=$baris['id_oleh_oleh'];
                $nama_oleh_oleh=$baris['nama_oleh_oleh'];
                $pemilik=$baris['pemilik'];
                $cp=$baris['cp'];
                $alamat=$baris['alamat'];
                $produk=$baris['produk'];
                $harga_barang=$baris['harga_barang'];
                $latitude=$baris['lat'];
                $longitude=$baris['lng'];
                $dataarray[]=array('id_angkot'=>$id_angkot,'id_oleh_oleh'=>$id_oleh_oleh,'nama_oleh_oleh'=>$nama_oleh_oleh,'cp'=>$cp,'alamat'=>$alamat,'produk'=>$produk,'harga_barang'=>$harga_barang, "latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>