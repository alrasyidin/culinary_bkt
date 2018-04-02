<?php
require 'connect.php';


$lay=$_GET['lay'];
$lay = explode(",", $lay);
$c = "";
for($i=0;$i<count($lay);$i++){
	if($i == count($lay)-1){
		$c .= "'".$lay[$i]."'";
	}else{
		$c .= "'".$lay[$i]."',";
	}
}
$querysearch="select tempat_kuliner.id_tempat_kuliner,nama_tempat_kuliner,ST_X(ST_Centroid(tempat_kuliner.geom)) AS lng, ST_Y(ST_CENTROID(tempat_kuliner.geom)) As lat from tempat_kuliner join detail_kuliner on tempat_kuliner.id_tempat_kuliner=detail_kuliner.id_tempat_kuliner where detail_kuliner.id_kuliner in ($c)";
$hasil=pg_query($querysearch);
while($row = pg_fetch_array($hasil))
	{
		$id_tempat_kuliner=$row['id_tempat_kuliner'];
		$nama_tempat_kuliner=$row['nama_tempat_kuliner'];
		$nama_tempat_kuliner=$row['nama_tempat_kuliner'];
		$longitude=$row['lng'];
		$latitude=$row['lat'];

		$dataarray[]=array('id_tempat_kuliner'=>$id_tempat_kuliner,'nama_tempat_kuliner'=>$nama_tempat_kuliner,'nama_tempat_kuliner'=>$nama_tempat_kuliner,'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>