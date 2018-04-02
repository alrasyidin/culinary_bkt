<div class="row">
<div class="col-xs-12">
	<div class="box">
		<div class="box-body">
			<div id="form">
			<?php if (isset($_GET['id_tempat_kuliner'])){
				$id_tempat_kuliner=$_GET['id_tempat_kuliner'];
				$sql = pg_query("SELECT * FROM tempat_kuliner where id_tempat_kuliner=$id_tempat_kuliner");
				$data =  pg_fetch_array($sql);
			?>
				<h4 style="text-transform:capitalize;">Ubah Data Atribut <?php echo $data['nama_tempat_kuliner'] ?></h4>
				<form role="form" action="act/editatributkulprocess.php" method="post">
				<a href="?page=detailculinary&id_tempat_kuliner=<?php echo $id_tempat_kuliner ?>" class="btn btn-primary pull-left"><i class="fa fa-chevron-left"></i> Kembali</a>
				<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
				<br><br><br>
					<input type="text" class="form-control hidden" name="id_tempat_kuliner" value="<?php echo $id_tempat_kuliner ?>">
					<div class="form-group" style="clear:both">
						<label for="nama_tempat_kuliner">Nama Kuliner</label>
						<input type="text" class="form-control" name="nama_tempat_kuliner" value="<?php echo $data['nama_tempat_kuliner'] ?>">
					</div>
					<div class="form-group" style="clear:both">
						<label for="alamat">Alamat</label>
						<input type="text" class="form-control" name="alamat" value="<?php echo $data['alamat'] ?>">
					</div>
					<div class="form-group">
						<label for="cp">Telepon</label>
						<input type="text" class="form-control" name="cp" value="<?php echo $data['cp'] ?>">
					</div>
					<div class="form-group">
						<label for="menu_spesial">Menu Spesial</label>
						<input type="text" class="form-control" name="menu_spesial" value="<?php echo $data['menu_spesial'] ?>">
					</div>
					<div class="form-group">
						<label for="jam_buka">Jam Buka</label>
						<input type="time" class="form-control" name="jam_buka" value="<?php echo $data['jam_buka'] ?>">
					</div>
					<div class="form-group">
						<label for="jam_tutup">Jam Tutup</label>
						<input type="time" class="form-control" name="jam_tutup" value="<?php echo $data['jam_tutup'] ?>">
					</div>
					<div class="form-group">
						<label for="kapasitas">Kapasitas</label>
						<input type="text" class="form-control" name="kapasitas" value="<?php echo $data['kapasitas'] ?>">
					</div>
					<div class="form-group">
						<label for="fasilitas">Fasilitas</label>
						<input type="text" class="form-control" name="fasilitas" value="<?php echo $data['fasilitas'] ?>">
					</div>
					
				<div class="form-group">
						<label for="harga">Harga</label>
						<input type="text" class="form-control" name="harga" value="<?php echo $data['harga'] ?>">
					</div>
					<div class="form-group">
						<label for="jumlah_karyawan">Jumlah Karyawan</label>
						<input type="text" class="form-control" name="jumlah_karyawan" value="<?php echo $data['jumlah_karyawan'] ?>">
					</div>
				</form>
			<?php }	?>
			</div>
		</div>
	</div><!-- /.box -->
</div><!-- /.col -->
</div>