<?php
// database connection
$server = "localhost";
$user = "root";
$pass = "";
$database = "chickdata";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

//jika button simpan diklik
if(isset($_POST['bsimpan']))
{

    //data di edit atau disimpan baru?
    if($_GET['hal']== "edit"){
        //data akan diedit 
        $edit = mysqli_query($koneksi, "UPDATE chickinfo SET batch = '$_POST[tbatch]',
                                                             jumlah = '$_POST[tjumlah]',
                                                             tarikh = '$_POST[tdob]',
                                                             umur = '$_POST[tumur]',
                                                             WHERE id_chick = '$_GET[id]'
                                        ");

if($edit) //jika simpan berjaya
{
  echo "<script>
        alert('Edit data Berjaya !');
        document.location='index.php';
        </script>";
}
else{
    echo "<script>
    alert('Edit data Gagal !');
    document.location='index.php';
    </script>";
  }
    }
    else{
        //data akan disimpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO chickinfo (batch, jumlah_ayam, tarikh_lahir, umur)
                                  VALUES ('$_POST[tbatch]',
                                          '$_POST[tjumlah]',
                                          '$_POST[tdob]',
                                          '$_POST[tumur]')
                                  ");

if($simpan) //jika simpan berjaya
{
  echo "<script>
        alert('Simpan data Berjaya !');
        document.location='index.php';
        </script>";
}
else{
    echo "<script>
    alert('Simpan data Gagal !');
    document.location='index.php';
    </script>";
       }
    }
}
//test jika button edit@delete diklik
if (isset($_GET['hal'])){

    //test jika edit data
    if($_GET['hal']== "edit"){

//tambilkan data yg akan diedit

       $tampil = mysqli_query($koneksi, "SELECT * FROM chickinfo WHERE id_chick = '$_GET[id]' ");
       $data = mysqli_fetch_array($tampil);
       if($data){
           //jika data ditemukan, maka data ditampung ke dalam variable
           $vbatch = $data['batch'];
           $vjumlah = $data['jumlah_ayam'];
           $vdob = $data['tarikh_lahir'];
           $vumur = $data['umur'];
       }
    }
    else if ($_GET['hal'] == "delete")
    {
        //ready to delete
     $delete = mysqli_query($koneksi, "DELETE FROM chickinfo WHERE id_chick = '$_GET[id]' ");
         if($delete){
            echo "<script>
            alert('Delete data Berjaya !');
            document.location='index.php';
            </script>";
         }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
   <title>ChickData</title>
   <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>
<body>
<div class="container">
   <h1 class="text-center">Chick Data 2021</h1>
   <h2 class="text-center">Anuar & Family</h2>
<!-------card form start ------------>
<div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Form Input Chicken Data
  </div>

  <div class="card-body">
     <form method="post" action="">
       <div class="form-group">
          <label>Batch</label>
          <input type="text" name="tbatch" value="<?=@$vbatch?>" class="form-control" placeholder="Masukan Batch Ayam disini !" required>
       </div>
       <div class="form-group">
          <label>Jumlah Ayam</label>
          <input type="number" name="tjumlah" value="<?=$vjumlah?>" class="form-control" placeholder="contoh : 20" required>
       </div>
       <div class="form-group">
          <label>Tarikh Lahir</label>
          <input type="date" name="tdob" value="<?=$vdob?>" class="form-control" placeholder="12/02/2000" required>
       </div>
       <div class="form-group">
          <label>Umur</label>
          <input type="text" name="tumur" value="<?=@$vumur?>" class="form-control" placeholder="12 bulan" required>
       </div>
    <button type="submit" class="btn btn-success mt-3" name="bsimpan">Simpan</button>
    <button type="reset" class="btn btn-danger mt-3" name="breset">Kosongkan</button>
     </form>
  </div>
</div>
<!-----------card form end----------->

<!-------card Table start ------------>
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    List Ayam Kampung
  </div>

  <div class="card-body">
     <table class="table table-bordered table-striped">
        <tr>
           <th>No.</th>
           <th>Batch</th>
           <th>Jumlah Ayam</th>
           <th>Tarikh Lahir</th>
           <th>Umur</th>
           <th>Action</th>
        </tr>

        <?php
          $no = 1;
          $tampil = mysqli_query($koneksi, "SELECT * from chickinfo order  by id_chick desc");
          while($data = mysqli_fetch_array($tampil)) :
        ?>

        <tr>
           <td><?=$no++;?></td>
           <td><?=$data['batch']?></td>
           <td><?=$data['jumlah_ayam']?></td>
           <td><?=$data['tarikh_lahir']?></td>
           <td><?=$data['umur']?></td>
           <td>
              <a href="index.php?hal=edit&id=<?=$data['id_chick']?>" class="btn btn-warning">Edit</a>
              <a href="index.php?hal=delete&id=<?=$data['id_chick']?>" 
                    onclick="return confirm('Adakah anda yakin ingin delete data ini ?')" class="btn btn-danger">Delete</a>
           </td>
        </tr>
        <?php endwhile; //end looping while ?> 
     </table>
  </div>
</div>
<!-----------card Table end----------->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>