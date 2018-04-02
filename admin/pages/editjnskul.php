<div class="row">
<div class="col-xs-12">
	<div class="box">
		<div class="box-body">
				<h4 style="text-transform:capitalize;">Type of Culinary</h4>
				<?php if (!isset($_GET['id_kuliner'])){ ?>
				<form role="form" action="act/layanankulins.php" method="post">
					
					<button type="submit" class="btn btn-primary pull-right">Save <i class="fa fa-floppy-o"></i></button>
					<div class="form-group" style="clear:both" id="lsou_form" >
						<label for="nama_kuliner">Type of Culinary</label>
						<input type="text" class="form-control" name="" value="" style="margin-bottom:3px;" autofocus required>
					</div>
				</form>
				<?php } if (isset($_GET['id_kuliner'])){
					$id_kuliner=$_GET['id_kuliner'];
					$sql = pg_query("SELECT * FROM kuliner where id_kuliner=$id_kuliner");
					$data = pg_fetch_array($sql)
				?>
				<form role="form" action="act/layanankulupd.php" method="post">
					<button type="submit" class="btn btn-primary pull-right">Save <i class="fa fa-floppy-o"></i></button>
					<a href="?page=jenisCulinary" class="btn btn-primary pull-left"><i class="fa fa-chevron-left"></i> Kembali</a> <br><br><br>
					<input type="text" class="form-control hidden" name="id_kuliner" value="<?php echo $data['id_kuliner'] ?>">
					<div class="form-group" style="clear:both">
						<label for="nama_kuliner">Type of Culinary</label>
						<input type="text" class="form-control" name="nama_kuliner" value="<?php echo $data['nama_kuliner'] ?>" required>
					</div>
				</form>
				<?php } ?>
			</div>
		</div>
	</div><!-- /.box -->
</div><!-- /.col -->
</div>
<script>

</script>