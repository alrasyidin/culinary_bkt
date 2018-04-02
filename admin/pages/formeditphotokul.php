<div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Upload Foto</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="act/uploadphotokul.php" enctype="multipart/form-data" method="post">
	  <div class="box-body">
		<?php $id_kuliner=$_GET['id_kuliner'] ?>
		<input type="text" class="form-control hidden" name="id_kuliner" value="<?php echo $id_kuliner ?>">
		<div class="form-group">
		  <label for="file">Upload Foto</label>
		  <input type="file" class="" style="background:none;border:none; width:1000px; " name="image" required>
		</div>
		<span style="color:red;">*Ukuran gambar maksimal 500kb</span>
	  </div><!-- /.box-body -->

	  <div class="box-footer">
	   <a href="?page=detailculinary&id_kuliner=<?php echo $id_kuliner ?>" class="btn btn-primary pull-left"><i class="fa fa-chevron-left"></i> Kembali</a>
	  &nbsp&nbsp
		<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
	  </div>
	</form>
</div>