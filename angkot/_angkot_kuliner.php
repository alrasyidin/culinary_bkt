<?php
    include("connect.php");
    $id_angkot = $_GET['id_angkot'];

    $result=  pg_query("SELECT detail_angkot_kuliner.id_kuliner, _kuliner.nama_kuliner, _kuliner.alamat, _kuliner.cp, _kuliner.menu_spesial, _kuliner.jam_buka, _kuliner.jam_tutup, _kuliner.kapasitas, _kuliner.fasilitas, _kuliner.harga, _kuliner.jumlah_karyawan, _kuliner.status_ser, ST_X(ST_Centroid(_kuliner.geom)) AS lng, ST_Y(ST_CENTROID(_kuliner.geom)) As lat FROM detail_angkot_kuliner left join _kuliner on detail_angkot_kuliner.id_kuliner=_kuliner.id_kuliner where detail_angkot_kuliner.id_angkot='$id_angkot' ");

        while($baris = pg_fetch_array($result))
            {
                $id_angkot=$baris['id_angkot'];
                $id_masjid=$baris['id_kuliner'];
                $nama=$baris['nama_kuliner'];
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
                $dataarray[]=array('id_angkot'=>$id_angkot,'id_kuliner'=>$id_kuliner,'nama'=>$nama_kuliner,'alamat'=>$alamat,'cp'=>$cp, 'menu_spesial'=>$menu_spesial, 'jam_buka'=>$jam_buka, 'jam_tutup'=>$jam_tutup, 'kapasitas'=>$kapasitas, 'fasilitas'=>$fasilitas, 'harga'=>$harga, 'jumlah_karyawan'=>$jumlah_karyawan, 'status_ser'=>$status_ser, 'harga'=>$harga,  "latitude"=>$latitude,"longitude"=>$longitude);
            }
            echo json_encode ($dataarray);
?>