<?php
$id_tempat_kuliner=$_GET['id_tempat_kuliner'];
$sql = pg_query("SELECT nama_tempat_kuliner,ST_AsText(geom) as geom FROM tempat_kuliner where id_tempat_kuliner=$id_tempat_kuliner");
$data =  pg_fetch_array($sql);
?>
<div class="row">
<div class="col-lg-5 col-xs-5 col-0">
	<div class="">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title" style="text-transform:capitalize;">Ubah Data Spasial <?php echo $data['nama_oleh_oleh'] ?></h3>
			</div>
			<div class="box-body">
				<!-- <div class="pull-right" id="regedit">
					<button class="btn btn-default my-btn" id="hider" title="Hide region" onclick="hideReg()"><i class="fa fa-eye-slash"></i> Hide region</button>
				</div> -->
				<form role="form" action="act/editspasialkulprocess.php" method="post">
					<input type="text" class="hidden" id="id_tempat_kuliner" name="id_tempat_kuliner" value="<?php echo $id_tempat_kuliner ?>" hidden>
					<div class="form-group" style="clear:both">
						<label for="geom">Koordinat</label>
						<textarea rows="6" class="form-control" id="geom" name="geom" readonly required><?php echo $data['geom'] ?></textarea>
					</div>
					<a href="?page=detailculinary&id_tempat_kuliner=<?php echo $id_tempat_kuliner ?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-floppy-o"></i> Simpan</button>
				</form>
			</div>
		</div>
		
	</div>
</div>
<div class="col-lg-7 col-xs-7 col-0">
	<div class="box box-primary" style="margin-bottom:0px;">
		<div class="box-header">
			<h3 class="box-title" style="text-transform:capitalize;">Peta</h3>
		</div>

		      <div class="col-lg-12 ds" id="hide2"> <!--menampilkan map-->
               <h3>                    
          <input id="latlng" type="text" value="" placeholder="  latitude, longitude">
          <button class="btn btn-default my-btn" id="btnlatlng" type="button" title="Geocode"><i class="fa fa-search"></i></button>
          <button class="btn btn-default my-btn" id="delete-button" type="button" title="Remove shape"><i class="fa fa-trash"></i></button> </h3>
          <div class="desc">
                    <div id="map" style="width:100%;height:400px; z-index:50"></div>
                  </div>
             
              </div>
		<!-- <div class="box-body">
			<div id="map-canvas">
				<div id="map"></div>
				<div id="floating-panel">
					<button class="btn btn-default my-btn" id="delete-button" title="Remove shape"><i class="fa fa-trash"></i></button>
					<input id="latlng" type="text" value="" placeholder="latitude, longitude">
					<button class="btn btn-default my-btn" id="btnlatlng" type="button" title="Geocode"><i class="fa fa-search"></i></button>
				</div>
			</div>
		</div> -->
	</div>
</div><!-- ./col -->
</div>
<script src="inc/mapedit2.js" type="text/javascript"></script>