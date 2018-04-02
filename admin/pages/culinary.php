      <?php
      // include('../act/session.php');
      
if(isset($_GET['id_tempat_kuliner']))
  {
  $id_tempat_kuliner=$_GET["id_tempat_kuliner"];

  $sql=pg_query("DELETE from detail_kuliner where id_tempat_kuliner=$id_tempat_kuliner");
  $sql1=pg_query("DELETE from detail_tempat_kuliner where id_tempat_kuliner=$id_tempat_kuliner");
  $sql2=("DELETE from tempat_kuliner where id_tempat_kuliner=$id_tempat_kuliner");

  if(pg_query($sql2)){
      echo"<script>alert ('Data Berhasil Dihapus');</script>";
      //header("location:../admin");
    }else
    {
      echo"<script>alert ('Data Gagal Dihapus');</script>";
    }
  }

      ?>


                    <div class="col-lg-15 ds" id="hide2"> 
                       
          
              <div class="box-body">

       
    <div class="btn-group pull-right">
    <a href="?page=formkul" class="btn btn-default">Add Data <i class="fa fa-plus"></i></a>
    </div>
    <!-- <div class="col-xs-6">
    <div id=example_length" class"dataTables_length">
    <label>
    <select size="1" name="example1_length" aria-controls="example1">
    <option value="10">10</option>
    <option value="25">25</option>
    <option value="50">50</option>
    <option value="100">100</option>
    </select>
    "data per halaman"
    </label>
    </div>
    </div>
 -->
     

    </div>
    <br><br><br>

           
                        
          
           
              
              
              <table  id="dataTableExample2" class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
      <!-- <th>ID</th> -->
      <th  style="color:black">Nama</th>
      <th style="width:450px;color:black">Alamat</th>
      <th  style="color:black">Menu</th>
      <th  style="color:black">Aksi</th>
      
      </tr>
    </thead>
    <tbody>
    
<?php
    include("inc/connect.php");
    $id_tempat_kuliner = $_GET['id_tempat_kuliner'];
    $querysearch  ="SELECT tempat_kuliner.id_tempat_kuliner, tempat_kuliner.nama_tempat_kuliner, tempat_kuliner.alamat, tempat_kuliner.menu_spesial FROM tempat_kuliner order by id_tempat_kuliner ASC ";
             
    $hasil=pg_query($querysearch);
    while($baris = pg_fetch_array($hasil))
    {
      $id_tempat_kuliner=$baris['id_tempat_kuliner'];
          $nama_tempat_kuliner=$baris['nama_tempat_kuliner'];
          
          $alamat=$baris['alamat'];
          $menu_spesial=$baris['menu_spesial'];
          
          $dataarray[]=array('id_tempat_kuliner'=>$id_tempat_kuliner,'nama_tempat_kuliner'=>$nama_tempat_kuliner,'alamat'=>$alamat,'menu_spesial'=>$menu_spesial);
?>
    <tr>
     
      <td style="color:black"><?php echo "$nama_tempat_kuliner" ?></td>
      
      <td style="color:black"><?php echo "$alamat" ?></td>
      <td style="color:black"><?php echo "$menu_spesial" ?></td>

      <td><div class="btn-group">
        <a href="?page=detailculinary&id_tempat_kuliner=<?php echo $id_tempat_kuliner; ?>" class="btn btn-sm btn-default" title='Detail'><i class="fa fa-exclamation-circle"></i> Detail</a>
        <br><br>
        </div>
        <div class="btn-group">
        <a href="?page=culinary&id_tempat_kuliner=<?php echo $id_tempat_kuliner; ?>" onclick="return confirm('Are You Sure To Delete?')" class="btn btn-sm btn-default" title='Delete'><i class="fa fa-trash"></i> Delete</a>
        </div>
      </td>

    </tr>
<?php
    }
//echo json_encode ($dataarray);
?>

    </tbody>
    </table>


  </div><!-- /.box-body -->
            
           
             