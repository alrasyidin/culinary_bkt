<div class="row">
<form role="form" action="act/digitkulprocess.php" enctype="multipart/form-data" method="post">
               <div class="col-sm-8" id="hide2"> <!-- menampilkan peta-->
                  <section class="panel">
                      <header class="panel-heading">
                          <h3>       
                          <center>            
          <input id="latlng" type="text" class="form-control" style="width:200px" value="" placeholder="Latitude, Longitude">
          <button class="btn btn-default my-btn" style="margin-top:10px" id="btnlatlng" type="button" title="Geocode"><i class="fa fa-search"></i></button>
          <button class="btn btn-default my-btn" style="margin-top:10px" id="delete-button" type="button" title="Remove shape"><i class="fa fa-trash"></i></button></center>  </h3>
              
                      </header>
                      <div class="panel-body">
                          <div id="map" style="width:100%;height:420px; z-index:50"></div>
                      </div>
                  </section>
              </div>




                    <div class="col-lg-4 ds" id="hide3">
                     <?php
          $query = pg_query("SELECT MAX(id_tempat_kuliner) AS id_tempat_kuliner FROM tempat_kuliner");
          $result = pg_fetch_array($query);
          $idmax = $result['id_tempat_kuliner'];
          if ($idmax==null) {$idmax=1;}
          else {$idmax++;}
        ?>
            <h3>Please Add The Data</h3>
                      <div class="desc" >
                        <!-- <form role="form" action="insertik.php" method="post"> -->
         <input type="text" class="form-control hidden" id="id_tempat_kuliner" name="id_tempat_kuliner" value="<?php echo $idmax;?>">
        <div class="form-group">
          <label for="geom"><span style="color:red">*</span> Coordinate</label>
          <textarea class="form-control" id="geom" name="geom" readonly required></textarea>
        </div>
        <div class="form-group">
          <label for="nama_tempat_kuliner"><span style="color:red">*</span>Name of Culinary</label>
          <input type="text" class="form-control" name="nama_tempat_kuliner" value="" required>
        </div>
         <div class="form-group">
          <label for="alamat"><span style="color:red">*</span>Address</label>
          <input type="text" class="form-control" name="alamat" value="" required>
        </div>
         <div class="form-group">
          <label for="cp"><span style="color:red">*</span> Contact Person</label>
          <input type="number" class="form-control" name="cp" value="" min="0" required>
        </div>
        <div class="form-group">
          <label for="menu_spesial"><span style="color:red">*</span>Special Menu</label>
          <input type="text" class="form-control" name="menu_spesial" value="" required>
        </div>
        <div class="form-group">
          <label for="jam_buka"><span style="color:red">*</span>Opened</label>
          <input type="time" class="form-control" name="jam_buka" value="" required>
        </div>
        <div class="form-group">
          <label for="jam_tutup"><span style="color:red">*</span>Closed</label>
          <input type="time" class="form-control" name="jam_tutup" value="" required>
        </div>
         <div class="form-group">
          <label for="kapasitas"><span style="color:red">*</span>Capasity</label>
          <input type="number" class="form-control" name="kapasitas" value="" min="0" required>
        </div>
        <div class="form-group">
          <label for="fasilitas"><span style="color:red">*</span>Fasility</label>
          <input type="text" class="form-control" name="fasilitas" value="" required>
        </div>
        <div class="form-group">
          <label for="harga"><span style="color:red">*</span>Price</label>
          <br>
          <input type="number" class="form-control" name="hargastart" value="" min="0" required placeholder="mulai" style="width:49% ;float:left">-
          <input type="number" class="form-control" name="hargaend" value="" min="0" required placeholder="sampai" style="width:49% ;float:right">
        </div>
        
         <!-- <div class="form-group">
          <label for="stat"><span style="color:red">*</span>Status of Place</label>
          <select required name="stat" id="stat" class="form-control">
          <option value="">-Choose-</option>
             <?php
                                
              // $stat=pg_query("select * from status_tempat ");
              // while($rowstat = pg_fetch_assoc($stat))
              // {
              // echo"<option value=".$rowstat['id_status_tempat'].">".$rowstat['status']."</option>";
              //}
              ?>
                              
          </select>
        </div>  -->
        <div class="form-group">
          <label for="jumlah_karyawan"><span style="color:red">*</span>Number of Employees</label>
          <input type="number" class="form-control" name="jumlah_karyawan" value="" min="0" required>
        </div>
        <!-- <div class="form-group">
          <label for="jns"><span style="color:red">*</span>Type of Souvenirs</label>
          <select required name="jns" id="jns" class="form-control">
          <option value="">-Choose-</option>
             <?php
                                
              // $jns=pg_query("select * from jenis_oleh_oleh ");
              // while($rowjns = pg_fetch_assoc($jns))
              // {
              // echo"<option value=".$rowjns['id_jenis_oleh'].">".$rowjns['jenis_oleh']."</option>";
              // }
              ?>
                              
          </select>
        </div>   -->
         

         <div class="form-group">
                  <label for="file">Upload Foto</label>
                  <input type="file" class="" style="background:none;border:none; width:1000px; " name="image" required>
                </div>
                <span style="color:red;">*Ukuran gambar maksimal 500kb</span>
                <br><br>
    
        <button type="submit" class="btn btn-primary pull-right">Next <i class="fa fa-chevron-right"></i></button> 
        <a href="?page=culinary" class="btn btn-primary pull-left"><i class="fa fa-chevron-left"></i> Kembali</a>  
<!-- </form> -->

                      </div>
                                            
                  </div>
                  </form>
                  </div>
<script src="inc/mapedit2.js" type="text/javascript"></script>
        