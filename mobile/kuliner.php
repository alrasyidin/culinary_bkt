<?php
require 'connect.php';
$querysearch="	SELECT row_to_json(fc) 
				FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features 
				FROM (SELECT 'Feature' As type , ST_AsGeoJSON(tempat_kuliner.geom)::json As geometry , row_to_json((SELECT l 
				FROM (SELECT tempat_kuliner.nama_tempat_kuliner,ST_X(ST_Centroid(tempat_kuliner.geom)) 
				AS lon, ST_Y(ST_CENTROID(tempat_kuliner.geom)) As lat) As l )) As properties 
				FROM tempat_kuliner As tempat_kuliner  
				) As f ) As fc ";

$hasil=pg_query($querysearch);
while($data=pg_fetch_array($hasil))
	{
		$load=$data['row_to_json'];
	}
	echo $load;
?>