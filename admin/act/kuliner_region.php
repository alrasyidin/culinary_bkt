<?php
require '../inc/connect.php';
$id_tempat_kuliner=$_GET['id_tempat_kuliner'];
$querysearch="	SELECT row_to_json(fc) 
				FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features 
				FROM (SELECT 'Feature' As type , ST_AsGeoJSON(a.geom)::json As geometry , row_to_json((SELECT l 
				FROM (SELECT id_tempat_kuliner, nama_tempat_kuliner) As l )) As properties 
				FROM tempat_kuliner As a where id_tempat_kuliner=$id_tempat_kuliner 
				) As f ) As fc
			  ";

$hasil=pg_query($querysearch);
while($data=pg_fetch_array($hasil))
	{
		$load=$data['row_to_json'];
	}
	echo $load;
?>