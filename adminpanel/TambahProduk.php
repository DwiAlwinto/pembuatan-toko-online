<?php 
    require "session.php";
    require "../koneksi/koneksi.php";


    //database produk
    // $queryProduk = mysqli_query($koneksi, "SELECT * from produk"); //ini akan join with kategori
    $queryProduk = mysqli_query($koneksi, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id"); //ini kita join dengan ketegori table
    $jumlahProduk = mysqli_num_rows($queryProduk);
    // echo $jumlahProduk;

    //database kategori
    $queryKatergori = mysqli_query($koneksi, "SELECT * FROM kategori"); //ini akan di looping
  


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
    <!-- link -->
    <link rel="stylesheet" href="../bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/adminPanel.css">
    <title>Product</title>

</head>
<body>
        <?php require "navbar.php"; ?>

        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="../adminpanel" class="no-decoration" >
                        <i class="fa-solid fa-house-chimney text-muted" style="color: #FFD43B;"></i>
                        </a>   
                        Home
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Produk
                    </li>
                </ol>    
            </nav>

            <!-- tambah produk -->
            <div class="my-5 col-12 col-md-6">
                <h3>Tambah Produk</h3>

                <form action="" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off"  >
                    </div>
                    <div>
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control">
                         
                            <option value="">Pilih Salah Satu</option>
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
                        <input type="number" name="harga" id="harga" class="form-control">
                    </div>
                    <div>
                        <label for="foto">Upload Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" >
                    </div>

                    <div>
                        <label for="detail"></label>
                        <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div>
                        <label for="ketersedian_stok">Ketersediaan Stok</label>
                        <select name="ketersedian_stok" id="ketersedian_stok" class="form-control" >
                            <option value="tersedia">tersedia</option>
                            <option value="habis">habis</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary mt-2" name="btnSimpan">Simpan Produk</button>
                    </div>
                </form>
               
                <?php 
                //! list validasi di backend juga
                    

                   if (isset($_POST['btnSimpan'])) {
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

                    //untuk random name
                    $random_name = generateRandomString(20); //20 caracter saja
                    //buat nama variabel foto yang baru
                    $new_nama_images = $random_name . ".".$imageFileType;

                    // echo $target_dir . "<br>";
                    // echo $nama_file . "<br>";
                    // echo $target_file . "<br>";
                    // echo $imageFileType . "<br>";
                    // echo $image_size . "<br>";
                

                    //ini cek dari backend atau dari php ya
                        if ($nama=='' || $kategori=='' || $harga=='') { //! validasi backend
                            ?>
                                 <div class="alert alert-danger mt-3 ">
                                    Nama, Kategori dan harga tidak boleh Kosong.
                                 </div>
                            <?php
                        } 
                        else {
                            if ($nama_file!='') {
                                if ($image_size > 10000000) { //10mb
                                    ?>
                                    <div class="alert alert-danger mt-3">
                                        Foto tidak lebih dari 100kb
                                    </div>
                                    <?php
                                }
                                else {
                                    if ($imageFileType != 'jpg' and $imageFileType != 'png' and $imageFileType != 'jpeg') { //karena disini belum ada .png/jpg
                                        ?>
                                        <div class="alert alert-danger mt-3">
                                            Foto harus png and jpg
                                        </div>
                                        <?php
                                    }
                                    else {
                                        move_uploaded_file($_FILES["foto"]["tmp_name"], 
                                        $target_dir . $new_nama_images ); //. ini untuk .jpg/.png
                                    }
                                }
                            }
                        }

                        //query insert ke database product table
                        $queryTambahProduk = mysqli_query($koneksi, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersedian_stok) VALUES ('$kategori', '$nama', '$harga', '$new_nama_images', '$detail', '$ketersedian_stok') " );
                        if ($queryTambahProduk) {
                            ?>
                             <div class="alert alert-success mt-3" role="alert">
                                        Produk baru berhasil di simpan.
                            </div>
                                <meta http-equiv="refresh" content="0; url=produk.php">
                            <?php
                        } else {
                            echo mysqli_error($koneksi);
                        }
                   }
                ?>
            </div>

        </div>


<!-- link  -->
<script src="../bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>