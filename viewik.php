<?php
include 'connect.php';
$id = $_GET['id'];
$querysearch	="SELECT industri_kecil_region.id, industri_kecil_region.nama_industri, industri_kecil_region.pemilik, industri_kecil_region.cp,industri_kecil_region.alamat, ST_X(ST_Centroid(industri_kecil_region.geom)) AS lng, ST_Y(ST_CENTROID(industri_kecil_region.geom)) 
            As lat FROM industri_kecil_region";
			   
$hasil=pg_query($querysearch);
while($baris = pg_fetch_array($hasil))
	{
		$id=$baris['id'];
        $nama_industri=$baris['nama_industri'];
        $pemilik=$baris['pemilik'];
        $cp=$baris['cp'];
        $alamat=$baris['alamat'];
        $longitude=$baris['lng'];
		$latitude=$baris['lat'];
        $dataarray[]=array('id'=>$id,'nama_industri'=>$nama_industri,'pemilik'=>$pemilik,'cp'=>$cp,'alamat'=>$alamat, 'lng'=>$longitude,'lat'=>$latitude);
    }
echo json_encode ($dataarray);
?>

