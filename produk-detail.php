<?php 
require "./koneksi/koneksi.php";

// ambil kategori
    $namaKategori = htmlspecialchars($_GET['nama']);
   //echo $namaKategori;
   $queryProduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama='$namaKategori' ");
   $Produk = mysqli_fetch_array($queryProduk);
   //var_dump($Produk);
   //echo $Produk['kategori_id'];

   //!ambil kategori terkait
   //$queryProdukTerkait = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori_id='$Produk[kategori_id]' LIMIT 4");
   $queryProdukTerkait = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori_id='$Produk[kategori_id]' AND id!='$Produk[id]'"); //(id!= agar produk tidak muncul lagi)

   //$produkTerkait = mysqli_fetch_array($queryProdukTerkait);
   //var_dump($produkTerkait);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/produk.css">
    <title>Document</title>
</head>
<body>

    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5">
        <div class="contaniner">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <img src="./image/<?php echo $Produk['foto']; ?>" alt="" class="w-100" >
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $Produk['nama'] ?></h1>
                    <p class="fs-5" ><?php echo $Produk['detail'] ?></p>
                    <p class="text-harga" >
                        Rp. <?php  echo $Produk['harga'];?>
                    </p>
                    <p class='fs-5'> Status Ketersediaan : <strong><?php echo $Produk['ketersedian_stok'] ?></strong> </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk terkait -->
        <div class="container-fluid py-5 warna3">
            <div class="container">
                <h2 class="text-center text-white mb-5" >Produk Terkait</h2>

                <div class="row">
                    <?php while ($data = mysqli_fetch_array($queryProdukTerkait)) {
                        
                    ?>
                    <div class=" col-md-6 col-lg-3 mb-3">
                        <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" >
                            <img src="image/<?php echo $data['foto'] ?>" class="img-fluid img-thumbnail produk-terkait-img" alt="">   
                        </a>
                    </div>
                    
                    <?php } ?>
                </div>
            </div>
        </div>


    <?php require"footer.php"; ?>
    









    <script src="bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>