<!-- <div class="col-xs-8 col-sm-10 col-md-10 col-lg-5">
                            <div class="panel panel-bd " >
                                <div class="panel-heading" style="height:45px;"> -->


<?php if (isset($_GET['id_tempat_kuliner'])){
	$id_tempat_kuliner=$_GET['id_tempat_kuliner'];
?>
<form class="" role="form" action="act/uplayprocess.php" method="post">
<button type="submit" class="btn btn-primary" style="float:right"><i class="fa fa-floppy-o"></i> Simpan</button>
<div class="row" style="clear:both;">
<div class="col-xs-5">
	<div class="box">
		<div class="box-body">
		<h4 style="text-transform:capitalize;">Kuliner <?php echo $data1['nama_kuliner'] ?></h4>
			<div id="forml">
				<input type="text" class="form-control hidden" id="id_tempat_kulinerl" name="id_tempat_kuliner" value="<?php echo $id_tempat_kuliner ?>">
					<div class="form-group row col-xs-9" >
						<?php
							$sql2 = pg_query("select * from kuliner order by nama_kuliner");
							while($dt = pg_fetch_array($sql2)){
								$sql3 = pg_query("SELECT * FROM detail_kuliner where id_tempat_kuliner=$id_tempat_kuliner and id_kuliner=$dt[id_kuliner]");
								$data3 = pg_fetch_array($sql3);
								if ($dt['id_kuliner']==$data3['id_kuliner']){
									echo "<div class='checkbox'><label><input name='kuliner[]' value=\"$dt[id_kuliner]\" type='checkbox' checked style='width:25px'>$dt[nama_kuliner]</label></div><br>";
								}else{
									echo "<div class='checkbox'><label><input name='kuliner[]' value=\"$dt[id_kuliner]\" type='checkbox' style='width:25px'>$dt[nama_kuliner]</label></div><br>";
								}
							}
						?>
						
					</div>
			</div>
		</div>
	</div><!-- /.box -->
</div><!-- /.col -->
</div>
</form>
<?php } ?>
<!-- </div>
</div>
</div> -->
