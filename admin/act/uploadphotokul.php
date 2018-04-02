<?php 
	include ('../inc/connect.php');
	$id_kuliner = $_POST['id_kuliner'];
	$jenis_gambar=$_FILES['image']['type'];
	if(($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif"  || $jenis_gambar=="image/png") && ($_FILES["image"]["size"] <= 500000)){
		$sourcename=$_FILES["image"]["name"];
		$name=$id_kuliner.'_'.$sourcename;
		$filepath="../../image/".$name;
		move_uploaded_file($_FILES["image"]["tmp_name"],$filepath);
		$sql = pg_query("update kuliner set foto='$name' where id_kuliner='$id_kuliner'");
		if($sql){
			header("location:../?page=detailculinary&id_kuliner=$id_kuliner");
		}
	}
	else{
		echo "The Picture Isn't Valid!<br>";
		echo "Go Back To <a href='../?page=detailculinary&id_kuliner=$id_kuliner'>halaman detail</a>";
	}
?>