<?php
include 'connect.php';
$id_oleh_oleh = $_GET['id_oleh_oleh'];
$querysearch	="SELECT oleh_oleh.id_oleh_oleh, oleh_oleh.nama_oleh_oleh, oleh_oleh.pemilik, oleh_oleh.cp,oleh_oleh.alamat, ST_X(ST_Centroid(oleh_oleh.geom)) AS lng, ST_Y(ST_CENTROID(oleh_oleh.geom)) 
            As lat FROM oleh_oleh";
			   
$hasil=pg_query($querysearch);
while($baris = pg_fetch_array($hasil))
	{
		$id_oleh_oleh=$baris['id_oleh_oleh'];
        $nama_oleh_oleh=$baris['nama_oleh_oleh'];
        $pemilik=$baris['pemilik'];
        $cp=$baris['cp'];
        $alamat=$baris['alamat'];
        $longitude=$baris['lng'];
		$latitude=$baris['lat'];
        $dataarray[]=array('id_oleh_oleh'=>$id_oleh_oleh,'nama_oleh_oleh'=>$nama_oleh_oleh,'pemilik'=>$pemilik,'cp'=>$cp,'alamat'=>$alamat, 'lng'=>$longitude,'lat'=>$latitude);
    }
echo json_encode ($dataarray);
?>

