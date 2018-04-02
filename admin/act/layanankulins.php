<?php
include ('../inc/connect.php');

$query = pg_query("SELECT MAX(id_kuliner) AS id_kuliner FROM kuliner");
$result = pg_fetch_array($query);
$idmax = $result['id_kuliner'];
if ($idmax==null) {$idmax=1;}
else {$idmax++;}
					
$nama_kuliner = $_POST['nama_kuliner'];


$count = count($nama_kuliner);
$sql  = "insert into kuliner (id_kuliner, nama_kuliner) VALUES ";
 
for( $i=0; $i < $count; $i++ ){
	$sql .= "('{$idmax}','{$nama_kuliner[$i]}')";
	$sql .= ",";
	$idmax++;
}
$sql = rtrim($sql,",");
$insert = pg_query($sql);

if ($insert){
	header("location:../?page=jenisculinary");
}else{
	echo 'error';
}
?>