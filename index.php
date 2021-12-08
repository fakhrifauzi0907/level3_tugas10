<?php 
 
$koneksi = mysqli_connect("localhost","root","","dblatihan");
 
// Check connection
if (mysqli_connect_error()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
//jika tombol simpan diklik
if(isset($_POST['bsimpan']))
{
  //Pengujian Apakah data akan diedit atau disimpan baru
  if($_GET['hal'] == "edit")
  {
    //Data akan di edit
    $edit = mysqli_query($koneksi, "UPDATE tabel set
                       produk = '$_POST[produk]',
                       keterangan = '$_POST[keterangan]',
                      harga = '$_POST[harga]',
                       jumlah = '$_POST[total]'
                     WHERE ids = '$_GET[id]'
                     ");
    if($edit) //jika edit sukses
    {
      echo "<script>
          alert('Edit data suksess!');
          document.location='index.php';
           </script>";
    }
    else
    {
      echo "<script>
          alert('Edit data GAGAL!!');
          document.location='index.php';
           </script>";
    }
  }
  else
  {
    //Data akan disimpan Baru
    $simpan = mysqli_query($koneksi, "INSERT INTO tabel (produk, keterangan, harga, jumlah)
                    VALUES ('$_POST[produk]', 
                         '$_POST[keterangan]', 
                         '$_POST[harga]', 
                         '$_POST[jumlah]')
                   ");
    if($simpan) //jika simpan sukses
    {
      echo "<script>
          alert('Simpan data suksess!');
          document.location='index.php';
           </script>";
    }
    else
    {
      echo "<script>
          alert('Simpan data GAGAL!!');
          document.location='index.php';
           </script>";
    }
  }


  
}


//Pengujian jika tombol Edit / Hapus di klik
if(isset($_GET['hal']))
{
  //Pengujian jika edit Data
  if($_GET['hal'] == "edit")
  {
    //Tampilkan Data yang akan diedit
    $tampil = mysqli_query($koneksi, "SELECT * FROM tabel WHERE ids = '$_GET[id]' ");
    $data = mysqli_fetch_array($tampil);
    if($data)
    {
      //Jika data ditemukan, maka data ditampung ke dalam variabel
      $vproduk = $data['produk'];
      $vketerangan = $data['keterangan'];
      $vharga = $data['harga'];
      $vjumlah = $data['jumlah'];
    }
  }
  else if ($_GET['hal'] == "hapus")
  {
    //Persiapan hapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM tabel WHERE ids = '$_GET[id]' ");
    if($hapus){
      echo "<script>
          alert('Hapus Data Suksess!!');
          document.location='index.php';
           </script>";
    }
  }
}


?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>BELAJAR CRUD BOOTSTRAP4</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <!-- awalan card-->
    <div class="container">
<h1 class="text-center">Belajar CRUD & MySQL</h1>
<div class="card mt-3">
  <div class="card-header bg-primary text-white">
    PRODUK
  </div>
  <div class="card-body">
    <form method="post" action="">

<div class="form group">
<label> nama produk</label>
<input type="text" name="produk" value="<?=@$vproduk?>" class="form-control" placeholder="input nama produk disini" required>
</div>

<div class="form group">
<label> Keterangan</label>
<textarea  name="keterangan" class="form-control" placeholder="keterangan"  required><?=@$vketerangan?></textarea>
</div>

<div class="form group">
<label> harga</label>
<input  name="harga"  value="<?=@$vharga?>" class="form-control" placeholder="input harga" required>
</div>

<div class="form group">
<label> jumlah</label>
<input  name="jumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="input jumlah" required>
</div>


<button type="submit" class="btn btn-success" name="bsimpan">simpan</button>
<button type="reset" class="btn btn-danger" name="breset">kosongkan</button>

</div>


    </form>
  </div>
</div>
<!--akhir card-->

 <!-- awalan card-->
    

<div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Daftar produk
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
         <tr>
         <th>no.</th>
         <th>produk</th>
         <th>keterangan</th>
         <th>harga</th>
         <th>jumlah</th>
         <th>aksi</th>
        </tr>
		<?php
$no=1;
$tampil = mysqli_query($koneksi,"SELECT * FROM  tabel order by ids desc");
while($data= mysqli_fetch_array($tampil)):
?>

<tr>
         <th><?=$no++;?></th>
         <td><?php echo $data["produk"];?></td>
            <td><?php echo $data["keterangan"];?></td>
            <td><?php echo $data["harga"];?></td>
            <td><?php echo $data["jumlah"];?></td>
            <td>
                <a href="index.php?hal=edit&id=<?=$data['ids']?>" class="btn btn-warning">Edit</a>
                <a href="index.php?hal=hapus&id=<?=$data['ids']?>"
                onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>

            </td>
<?php endwhile;?>
    </table>
</form>



    </table>


    </form>
  </div>
<!--akhir card-->



    </div>


    <script type="text/javascript" src="js/bootstrap.min.js"
      ></script>
      
        </body>
</html>