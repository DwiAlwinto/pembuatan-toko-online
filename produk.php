<?php 
    require "./koneksi/koneksi.php";

    //!ambil data di table kategori
    $dataKategori = mysqli_query($koneksi, "SELECT * FROM kategori");

    //ambil produk by nama produk/keyword 
        if (isset($_GET['keyword'])) {
            $queryProduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%' ");
        }
    //ambil produk by kategori
        else if(isset($_GET['kategori'])) {
            $queryGetKategoriID = mysqli_query($koneksi, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
            $kategoriID = mysqli_fetch_array($queryGetKategoriID);
            //var_dump($kategoriID['id']);

            $queryProduk = mysqli_query($koneksi, "SELECT  * FROM produk WHERE kategori_id='$kategoriID[id]'");
        }
    // ambil produk by default
    else{
        $queryProduk = mysqli_query($koneksi, "SELECT * FROM produk");
    }
    $jumlahDataProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/produk.css">
    <title>Produk</title>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner-produk d-flex align-items-center " >
        <div class="container">
            <h1 class="text-white text-center" >Produk Azzahra</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($dataKategori)) {
                    ?>  
                    <a href="produk.php?kategori=<?php echo $kategori['nama']; ?>">
                        <li class="list-group-item"><? echo $kategori['nama']; ?></li>
                    </a>
                    <?php } ?>
                </ul>
                </div>

            <div class="col-lg-9">
                <h3 class="text-center mb-3" >Produk</h3>
                <div class="row">
                    <?php if ($jumlahDataProduk < 1) {
                        ?>
                            <div class="alert alert-danger text-center container" role="alert">
                                    Produk yang anda cari tidak tersedia <a href="index.php" class="alert-link">Kembali ke Pencariaan</a>
                                    </div>
                        <?php
                    } ?>
                    <?php while ($dataProduk = mysqli_fetch_array($queryProduk)) {
                   ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="image-box" >
                                <img src="./image/<?php echo $dataProduk['foto']; ?>" class="card-img-top"  alt="produk-img=database">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $dataProduk['nama']; ?></h5>
                                <p class="card-text text-truncate"><?php echo $dataProduk['detail']; ?></p>
                                <p class="card-text text-harga" >Rp. <?php echo $dataProduk['harga'] ?></p>
                                <a href="produk-detail.php?nama=<?php echo $dataProduk['nama']; ?>" class="btn btn-dark " >Lihat Detail</a>
                            </div>
                         </div>
                    </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>



    <script src="bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>