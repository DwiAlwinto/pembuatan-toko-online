<?php 
    //!koneksi database
    require "./koneksi/koneksi.php";

    //!ambil data produk 
    $queryProduk = mysqli_query($koneksi, "SELECT id, nama, harga, foto, detail FROM produk limit 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/toko.css">
    <title>Toko Online Azzahra</title>
</head>

    
<body>
    <?php require 'navbar.php'; ?>

<!-- to banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Toko Online Azzahra</h1>
            <h3>Mau Cari Apa?</h3>
            <div class="col-md-8 offset-md-2">
                <form action="produk.php" method="get">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari Produk Anda" aria-label="Cari Produk Anda" aria-describedby="basic-addon2">
                        <button type="submit" class="btn warna3 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- to banner -->

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Best Saller</h3>

            <div class="row mt-5">
                <div class="col-4" >
                    <div class="higlight-kategori kategori-baju-pria d-flex justify-content-center align-items-center ">
                        <h4 class="text-white"><a href="produk.php?kategori=Baju Pria">Baju Pria</a></h4>
                    </div>
                </div>
                <div class="col-4" >
                    <div class="higlight-kategori kategori-baju-wanita d-flex justify-content-center align-items-center ">
                        <h4 class="text-white"><a href="produk.php?kategori=Baju Wanita">Baju Wanita</a></h4>
                    </div>
                </div>
                <div class="col-4" >
                    <div class="higlight-kategori kategori-sepatu d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a href="produk.php?kategori=Sepatu Compass">Sepatu Compass</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tentang kami -->
    <div class="container-fluid warna2 py-5">
        <div class="container text-center">
            <h3>Toko Azzahra</h3>
            <p class="fs-5 mt-3" >Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae cumque beatae praesentium officia laboriosam sint esse velit consequatur vel natus tempora magnam corporis minus accusamus mollitia cum adipisci, harum atque necessitatibus! Consectetur tempore aspernatur quidem, excepturi iusto dignissimos consequatur. Consectetur facere ut error neque deserunt, doloremque similique provident aut omnis ad voluptatem hic ipsum commodi et laboriosam dolore sit quis nobis. Adipisci, iusto soluta cupiditate quas, iste modi tempora, ipsam nisi vero officiis sit? Ab nostrum unde velit voluptatibus illum!</p>
        </div>
    </div>

    <!-- Produk -->
    <div class="container-fluid py-5">
      <div class="container text-center">
        <h3>Produk</h3>
        <div class="row mt-5 ">
            <!-- looping data dari database -->
        <?php while ($dataProduk = mysqli_fetch_array($queryProduk)) {
            # code...
         ?>
            <div class="col-sm-6  col-md-4 mb-4">
                <div class="card h-100">
                    <div class="image-box" >
                        <img src="image/<?php echo $dataProduk['foto'] ?>" class="card-img-top"  alt="produk-img=database">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $dataProduk['nama'] ?></h5>
                        <p class="card-text text-truncate"><?php echo $dataProduk['detail'] ?></p>
                        <p class="card-text text-harga" >Rp. <?php echo $dataProduk['harga'] ?> </p>
                        <a href="produk-detail.php?nama=<?php echo $dataProduk['nama']; ?>" class="btn btn-dark " >Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php  } ?>
        </div>
        <a href="produk.php" class="btn btn-outline-dark">See More</a>
      </div>  
    </div>

   <!-- Footer -->
   <?php require "footer.php"; ?>

       





    <script src="bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>