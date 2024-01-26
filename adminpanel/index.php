<?php 
    require "session.php";
    require "../koneksi/koneksi.php";

    //database category
    $queryKatergori = mysqli_query($koneksi, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKatergori);

    //database produk
    $queryProduk = mysqli_query($koneksi, "SELECT * from produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/adminPanel.css">
    <title>Home</title>
</head>

    

    
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                <i class="fa-solid fa-house fa-2x " style="color: #FFD43B;"></i>   
                 Home</li>
            </ol>
        </nav>
            <h1>Haaii <?php echo $_SESSION['username'] ?> </h1>

            <div class="container mt-5">
                <div class="row">

                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="summary-kategori p-5">
                            <div class="row">
                                <div class="col-6">
                                <i class="fa-solid fa-layer-group fa-6x" style="color: #FFD43B;"></i>
                                </div>
                                <div class="col-6 text-white">
                                    <h3 class="fs-2">Kategori</h3>
                                    <p class="fs-4"> <?= $jumlahKategori ?> Kategori</p>
                                    <p><a href="kategori.php" class="text-warning no-decoration">Lihat Detail</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="summary-produk p-5">
                            <div class="row">
                                <div class="col-6">
                                <i class="fa-solid fa-boxes-packing fa-6x" style="color: #FFD43B;"></i>
                                </div>
                                <div class="col-6 text-white">
                                    <h3 class="fs-2">Produk</h3>
                                    <p class="fs-4"> <?= $jumlahProduk ?> Produk</p>
                                    <p><a href="produk.php" class="text-warning no-decoration">Lihat Detail</a></p>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <script src="../bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>