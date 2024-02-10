<?php 
    require "session.php";
    require "../koneksi/koneksi.php";


    //database produk
    //$id = $_GET['p']; //ini tampung ambil id ya 
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
                        Produk
                    </li>
                </ol>    
            </nav>

            <div class="mt-3 mb-10">            
                <h2>List Produk</h2>
                <div>
                    <a href="TambahProduk.php" class="btn btn-primary">Tambah Produk</a>
                </div>

                <div class="table-responsive mt-5 mb-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Ketersedian Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="mb-10">
                            <?php 
                                // Looping through the data
                                $noProduk = 1;
                                if ($jumlahProduk == 0) {
                                    // Display a row indicating no products if the product count is 0
                                    ?>
                                    <tr>
                                        <td colspan="6" class="table-danger text-center">Data Produk Kosong</td>
                                    </tr>
                                    <?php
                                } else {

                                    // If there are products, fetch the data and display each product in a table row
                                    while ($dataProduk = mysqli_fetch_array($queryProduk)) {
                                    
                                        ?>
                                        <tr>
                                            <td><?php echo $noProduk; ?></td>
                                            <td><?php echo $dataProduk['nama']; ?></td>
                                            <td><?php echo $dataProduk['nama_kategori']; ?></td>
                                            <td><?php echo $dataProduk['harga']; ?></td>
                                            <td><?php echo $dataProduk['ketersedian_stok']; ?></td>
                                            <td>
                                                <a href="produkDetail.php?p=<?php echo $dataProduk['id']; ?>" class="btn btn-dark">
                                                    <i class="fa-solid fa-pen-nib" style="color: #FFD43B;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        // Increment the product number
                                        $noProduk++;
            }
        }
    ?>
</tbody>

                    </table>
                </div>
            </div>



        </div>


<!-- link  -->
<script src="../bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>