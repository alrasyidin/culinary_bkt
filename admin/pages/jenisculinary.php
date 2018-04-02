     <?php
if(isset($_GET['id_kuliner']))
  {
  $id_kuliner=$_GET["id_kuliner"];

  $sql="DELETE from kuliner where id_kuliner=$id_kuliner";

  if(pg_query($sql)){
      echo"<script>alert ('Data Berhasil Dihapus');</script>";
      //header("location:./?page=jenissouvenirs");
    }else
    {
      echo"<script>alert ('Data Gagal Dihapus');</script>";
    }
  }

      ?>       

              <div class="col-lg-15 ds" id="hide2"> 
                       
          
              <div class="box-body">
              
            <a href="?page=culinary<?php echo $id ?>" class="btn btn-primary pull-left"><i class="fa fa-chevron-left"></i> Kembali</a>    
    <div class="btn-group pull-right">
    <a href="?page=formjnskul" class="btn btn-default">Tambah <i class="fa fa-plus"></i></a><br><br><br>
    </div>
    </div>
              <table id="" class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
     <!--  <th>ID Jenis Industri</th> -->
      <th>Jenis Souvenir</th>
      <th>Aksi</th>

      </tr>
    </thead>
    <tbody>
    
<?php
    include '../connect.php';
    $id_kuliner = $_GET['id_kuliner'];
    $querysearch  ="SELECT kuliner.id_kuliner, kuliner.nama_kuliner FROM kuliner order by id_kuliner ASC ";
             
    $result=pg_query($querysearch);
    while($baris = pg_fetch_array($result))
    {
          $id_kuliner=$baris['id_kuliner'];
          $nama_kuliner=$baris['nama_kuliner'];
          
          
          $dataarray[]=array('id_kuliner'=>$id_kuliner,'nama_kuliner'=>$nama_kuliner);
?>
    <tr>
      
      <td><?php echo "$nama_kuliner" ?></td>
       <td><div class="btn-group">

      
      <a href="?page=editjnskul&id_kuliner=<?php echo $id_kuliner; ?>" class="btn btn-sm btn-default" title='Edit'><i class="fa fa-edit"></i> Edit</a>
      </div>
      <div class="btn-group">
        <a href="?page=jenisculinary&id_kuliner=<?php echo $id_kuliner; ?>" onclick="return confirm('Are You Sure To Delete?')" class="btn btn-sm btn-default" title='Delete'><i class="fa fa-trash"></i></a>
       </div>
    </tr>
<?php
    }
//echo json_encode ($dataarray);
?>

    </tbody>
    </table>


  </div><!-- /.box-body -->
              </div>
              

