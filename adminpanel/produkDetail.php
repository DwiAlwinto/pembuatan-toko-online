<?php 
    require "session.php";
    require "../koneksi/koneksi.php";
   
    $id = $_GET['p']; //ini tampung ambil id ya 
    $query = mysqli_query($koneksi, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");  
    $data = mysqli_fetch_array($query);
    //var_dump($data);

    $queryKatergori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");
  


     //! fungsi untuk random string di file image untuk mengganti nama setiap image di upload.
     function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

   



    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/adminPanel.css">
    <title>Produk Detail</title>
</head>

<style>
    form div{
        margin-bottom: 10px;
    }
</style>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
           <h2>Edit Produk Detail</h2>

           <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" value="<?php echo $data['nama']; ?>" class="form-control" autocomplete="off">
                    
                <div>
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control">
                         
                            <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
                             <?php
                                    // Assuming $queryKatergori is a valid MySQLi result set
                                    $jumlah_kategori = mysqli_num_rows($queryKatergori); //ini itu yang diatas
                                    var_dump($jumlah_kategori);
                                    for ($i = 0; $i < $jumlah_kategori; $i++) {
                                        $dataKategori = mysqli_fetch_array($queryKatergori);

                                    ?>
                                        <option value="<?php echo $dataKategori['id']; ?>"> <?php echo $dataKategori['nama']; ?> </option>
                                    <?php
                                    }
                                    ?>
                        </select>
                    </div>
                    <div>
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="<?php echo $data['harga']; ?>">
                    </div>
                    <div>
                        <label for="currentFoto">Foto Produk</label>
                        <img src="../image/<?php echo $data['foto'] ?>" alt="" style="width: 500px;" >
                    </div>
                    <div>
                        <label for="foto">Upload Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" >
                    </div>

                    <div>
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                            <?php echo $data['detail']; ?>
                        </textarea>
                    </div>

                    <div>
                        <label for="ketersedian_stok">Ketersediaan Stok</label>
                        <select name="ketersedian_stok" id="ketersedian_stok" class="form-control" >
                            <option value="<?php echo $data['ketersedian_stok'] ?>">
                            <?php echo $data['ketersedian_stok'] ?>
                        </option>
                            <?php
                                if ($data['ketersedian_stok'] == 'tersedia' ) {
                                    ?>
                                        <option value="habis">habis</option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="habis">tersedia</option>
                                    <?php
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary mt-2" name="update">Update Produk</button>
                        <button type="submit" class="btn btn-danger mt-2" name="hapus">Hapus Produk</button>
                    </div>
            </form>

            <!-- fungsi btn simpan (sebaiknya harus menggunak database transcetion) --> 
            <?php 
                if(isset($_POST['update'])) {
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $nama = htmlspecialchars($_POST['nama']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $ketersedian_stok = htmlspecialchars($_POST['ketersedian_stok']);

                    //syarat untuk foto
                    $target_dir = "../image/"; //lokasi yang akan disimpan
                    $nama_file = basename($_FILES['foto']['name']);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES['foto']['size'];

                    $random_name = generateRandomString(20); //20 caracter saja
                    //buat nama variabel foto yang baru
                    $new_nama_images = $random_name . ".".$imageFileType;


                    if ($nama=='' || $kategori=='' || $harga=='') { //! validasi backend
                        ?>
                             <div class="alert alert-danger mt-3 ">
                                Nama, Kategori dan harga tidak boleh Kosong.
                             </div>
                        <?php
                    } 
                    else {
                        $queryUpdate = mysqli_query($koneksi, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersedian_stok='$ketersedian_stok', foto='$new_nama_images' WHERE id='$id'"); //harus ati2 disini win ID ya
                        
                        if ($nama_file!= '') { //untuk urus update foto baru
                            if ($image_size > 1000000) { //500kb
                                ?>
                                    <div class="alert alert-danger mt-3">
                                        Foto tidak lebih dari 500kb
                                    </div>
                                <?php
                            }
                            else {
                                if ($imageFileType != 'jpg' and $imageFileType != 'png') { //karena disini belum ada .png/jpg
                                    ?>
                                    <div class="alert alert-danger mt-3">
                                        Foto harus png and jpg
                                    </div>
                                    <?php
                                }
                                else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], 
                                    $target_dir . $new_nama_images ); //. ini untuk .jpg/.png

                                    $queryUpdateFoto = mysqli_query($koneksi, "UPDATE produk SET foto='$new_nama_images' WHERE id='$id' ");

                                    if ($queryUpdateFoto) {
                                        ?>
                                        <div class="alert alert-success mt-3" role="alert">
                                                   Produk baru berhasil di UPDATE.
                                       </div>
                                           <meta http-equiv="refresh" content="2; url=produk.php">
                                       <?php
                                    }
                                    else {
                                        echo mysqli_error($koneksi);
                                    }

                                }
                            }
                        }
                    }  
                }

                //! fungsi tombol hapus
                if (isset($_POST['hapus'])) {
                    $queryHapusProduk = mysqli_query($koneksi, "DELETE FROM produk WHERE id='$id'");
                    if ($queryHapusProduk) {
                        ?>
                                        <div class="alert alert-success mt-3 container" role="alert">
                                            Produk berhasil di HAPUS.
                                        </div>
                                        <meta http-equiv="refresh" content="3; url=produk.php">
                        <?php
                    } else {
                        echo mysqli_error($koneksi);
                    }
                }
                
            ?>
            
           </div>
    </div>



    <script src="../bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>