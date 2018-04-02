<div class="row">
<div class="col-xs-12">
<div class="box">
    <div class="box-body">
<form role="form" action="act/addjnskulprocess.php" method="post">
             <!--menampilkan map-->
    <?php
          $query = pg_query("SELECT MAX(id_kuliner) AS id_kuliner FROM kuliner");
          $result = pg_fetch_array($query);
          $idmax = $result['id_kuliner'];
          if ($idmax==null) {$idmax=1;}
          else {$idmax++;}
        ?>
           <!-- menampilkan form tambah mesjid-->
            <h4>Please Add The Data</h4>
                      <div class="desc" >

       <!-- <div class="form-group">
          <label for="id"><span style="color:red">*</span>ID</label>
          <input type="text" class="form-control" name="id" value="" required>
        </div> -->
      <input type="text" class="form-control hidden" id="id_kuliner" name="id_kuliner" value="<?php echo $idmax;?>">

        <div class="form-group">
          <label for="nama_kuliner"><span style="color:red">*</span>Type of Culinary</label>
          <input type="text" class="form-control" name="nama_kuliner" value="" required>
        </div>
   
    
        <button type="submit" class="btn btn-primary pull-right">Save <i class="fa fa-floppy-o"></i></button>   
        <a href="?page=jenissouvenirs" class="btn btn-primary pull-left"><i class="fa fa-chevron-left"></i> Kembali</a>

                      </div>
                                           
                  
                  </form>
                  </div>
                  </div>
                  </div>
                  </div>

        