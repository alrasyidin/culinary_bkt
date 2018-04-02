<?php
require 'inc/connect.php';
$id_tempat_kuliner=$_GET["id_tempat_kuliner"];
// date_default_timezone_set('Asia/Jakarta');
// $day=date("w");
// $query="SELECT distinct a.id_kecamatan, a.id,a.nama_industri, a.pemilik,a.cp,a.alamat,a.produk,a.harga_barang,a.foto,a.jumlah_karyawan, b.status, c.nama_jenis_industri, ,ST_X(ST_Centroid(a.geom)) AS lng, ST_Y(ST_CENTROID(a.geom)) As lat

//  FROM industri_kecil_region as a left join status_tempat as b on a.id_status_tempat=b.id_status_tempat left join jenis_industri as c on a.id_jenis_industri=c.id_jenis_industri, kecamatan where st_contains(kecamatan.geom, a.geom) and kecamatan.id_kecamatan='$id2' and c.id_jenis_industri='$' and b.id_status_tempat = '$cari' order by a.nama_industri ASC";


$query="SELECT tempat_kuliner.id_tempat_kuliner,nama_tempat_kuliner,alamat,cp,menu_spesial,jam_buka,jam_tutup,foto,kapasitas, fasilitas,  harga,jumlah_karyawan, ST_X(ST_Centroid(tempat_kuliner.geom)) AS lng, ST_Y(ST_CENTROID(tempat_kuliner.geom)) As lat FROM tempat_kuliner  where tempat_kuliner.id_tempat_kuliner=$id_tempat_kuliner ";


$hasil=pg_query($query);
while($row = pg_fetch_array($hasil)){
	$id_tempat_kuliner=$row['id_tempat_kuliner'];
	$nama_tempat_kuliner=$row['nama_tempat_kuliner'];
	$alamat=$row['alamat'];
	$cp=$row['cp'];
	$menu_spesial=$row['menu_spesial'];
	$jam_buka=$row['jam_buka'];
	$jam_tutup=$row['jam_tutup'];
	$foto=$row['foto'];
	$kapasitas=$row['kapasitas'];
	$fasilitas=$row['fasilitas'];
	
	$harga=$row['harga'];
	$jumlah_karyawan=$row['jumlah_karyawan'];
	 $lat=$row['lat'];
	$lng=$row['lng'];
	if ($lat=='' || $lat==''){
		$lat='<span style="color:red">Kosong</span>';
		$lng='<span style="color:red">Kosong</span>';
	}
	
if ($foto=='null' || $foto=='' || $foto==null){
		$foto='foto.jpg';
	}

}
?>
<!-- Default box -->
<div class="row">
	<div class="col-lg-7 col-xs-7 col-r-0">
		<div class="box">
			<div class="box-header with-border">
			  <h2 class="box-title" style="text-transform:capitalize;"><b> <?php echo $nama_tempat_kuliner ?></b></h2>
			</div>
			<div class="box-body">
				<table>
					<tbody  style='vertical-align:top;'>
						<tr><td><b>Alamat</b></td><td> :&nbsp; </td><td style='text-transform:capitalize;'><?php echo $alamat ?></td></tr>
						<tr><td><b>Telepon</b></td><td>:</td><td><?php echo $cp ?></td></tr>
						<tr><td><b>Menu Spesial</b></td> <td> :</td><td><?php echo $menu_spesial ?></td></tr>

						<tr><td><b>Culinary<b> </td><td>: </td><td><ul style="padding-left:20px;"><?php 
							$queryl = "select * from detail_kuliner join kuliner on detail_kuliner.id_kuliner=kuliner.id_kuliner where id_tempat_kuliner=$id_tempat_kuliner order by detail_kuliner.id_kuliner";
							$hasill=pg_query($queryl);
							while($rowl = pg_fetch_array($hasill)){
								echo '<li>'.$rowl['nama_kuliner'].'</li>';
							}
						?></ul><a href="?page=forml&id_tempat_kuliner=<?php echo $id_tempat_kuliner ?>" class="btn btn-success btn-sm btn-flat"><i class="fa fa-edit"></i> Set Nama Kuliner</a></td></tr>
						
						<tr><td><b>Harga<b> </td><td>: </td><td><?php echo $harga ?></td></tr>
						<tr><td><b>Jam Buka<b> </td><td>: </td><td><?php echo $jam_buka ?></td></tr>
						<tr><td><b>Jam Tutup<b> </td><td>: </td><td><?php echo $jam_tutup ?></td></tr>
						<tr><td><b>Kapasitas<b> </td><td>: </td><td><?php echo $kapasitas ?></td></tr>
						<tr><td><b>Fasilitas<b> </td><td>: </td><td><?php echo $fasilitas ?></td></tr>
						
						<tr><td><b>Jumlah Karyawan<b> </td><td>: </td><td><?php echo $jumlah_karyawan ?></td></tr>
						<tr><td><b>Data Spasial<b> </td><td>: </td><td><b>Latitude</b> : <?php echo $lat ?> <b>Longitude</b> : <?php echo $lng ?></td></tr>

						

					</tbody>
				</table>
			</div>
			<br><!-- /.box-body -->
			<div class="box-footer">
				<div class="btn-group">
					<a href="?page=formeditatributkul&id_tempat_kuliner=<?php echo $id_tempat_kuliner ?>" class="btn btn-default"><i class="fa fa-edit"></i> Data atribut</a>
					<a href="?page=formeditspasialkul&id_tempat_kuliner=<?php echo $id_tempat_kuliner ?>" class="btn btn-default"><i class="fa fa-edit"></i> Data spasial</a>
				</div>
				<br><br>
				<div class="btn-group">
				 <a href="?page=culinary" class="btn btn-primary pull-left"><i class="fa fa-chevron-left"></i> Kembali</a>
				 </div>
			</div><!-- /.box-footer-->
		</div><!-- /.box -->
	</div>
	<div class="col-lg-5 col-xs-5">
		<div class="box">
			<div class="box-header with-border">
			  <h2 class="box-title">Foto</h2>
			</div>
			<div class="box-body">
				<image src="../image/<?php echo "$foto"; ?>" style="width:100%;;">
			</div>
			<br>
			<div class="box-footer">
				<div class="btn-group">
					<a href="?page=formeditphotokul&id_tempat_kuliner=<?php echo $id_tempat_kuliner ?>" class="btn btn-default"><i class="fa fa-picture-o"></i> Ganti Foto</a>
				</div>
			</div><!-- /.box-footer-->
		</div>
	</div>
</div>
<script>
	
</script>