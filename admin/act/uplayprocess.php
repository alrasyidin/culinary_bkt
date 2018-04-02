<?php
include ('../inc/connect.php');
$id_tempat_kuliner = $_POST['id_tempat_kuliner'];
$kuliner = $_POST['kuliner'];

$sqldel = "delete from detail_kuliner where id_tempat_kuliner=$id_tempat_kuliner";
$delete = pg_query($sqldel);

$countl = count($kuliner);
$sqll   = "insert into detail_kuliner (id_tempat_kuliner, id_kuliner) VALUES ";
for( $i=0; $i < $countl; $i++ ){
	$sqll .= "('{$id_tempat_kuliner}','{$kuliner[$i]}')";
	$sqll .= ",";
}
$sqll = rtrim($sqll,",");
$insert = pg_query($sqll);
if ($insert && $delete){
	header("location:../?page=detailculinary&id_tempat_kuliner=$id_tempat_kuliner");
}
else{
	echo 'error';
	header("location:../?page=detailculinary&id_tempat_kuliner=$id_tempat_kuliner");
}

?>