<?php
include 'connect.php';
$id_tempat_kuliner = $_GET['id_tempat_kuliner'];
$querysearch	="SELECT tempat_kuliner.id_tempat_kuliner, tempat_kuliner.nama_tempat_kuliner, tempat_kuliner.alamat, tempat_kuliner.cp,tempat_kuliner.menu_spesial,tempat_kuliner.jam_buka,tempat_kuliner.jam_tutup,tempat_kuliner.kapasitas, tempat_kuliner.fasilitas, tempat_kuliner.harga, ST_X(ST_Centroid(tempat_kuliner.geom)) AS lng, ST_Y(ST_CENTROID(tempat_kuliner.geom)) 
            As lat FROM tempat_kuliner";
			   
$hasil=pg_query($querysearch);
while($baris = pg_fetch_array($hasil))
	{
		$id_tempat_kuliner=$baris['id_tempat_kuliner'];
        $nama_tempat_kuliner=$baris['nama_tempat_kuliner'];
        $alamat=$baris['alamat'];
        $cp=$baris['cp'];
        $menu_spesial=$baris['menu_spesial'];
        $jam_tutup=$baris['jam_tutup'];
        $jam_buka=$baris['jam_buka'];
        $kapasitas=$baris['kapasitas'];
        $fasilitas=$baris['fasilitas'];
        $harga=$baris['harga'];
        $longitude=$baris['lng'];
		$latitude=$baris['lat'];
        $dataarray[]=array('id_tempat_kuliner'=>$id_tempat_kuliner,'nama_tempat_kuliner'=>$nama_tempat_kuliner,'alamat'=>$alamat,'cp'=>$cp,'menu_spesial'=>$menu_spesial,'jam_buka'=>$jam_buka,'jam_tutup'=>$jam_tutup,'kapasitas'=>$kapasitas,'fasilitas'=>$fasilitas,'harga'=>$harga, 'lng'=>$longitude,'lat'=>$latitude);
    }
echo json_encode ($dataarray);
?>

