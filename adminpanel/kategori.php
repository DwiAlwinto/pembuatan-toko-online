<?php 
    require "session.php";
    require "../koneksi/koneksi.php";

    //database category
    $queryKatergori = mysqli_query($koneksi, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKatergori);
    //var_dump($jumlahKategori);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/adminPanel.css">
    <title>Kategori</title>
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
                    Kategori
                </li>
            </ol>    
        </nav>

            <!-- form input -->
            <div class="my-5 col-12 col-md-6">
            <h2 class="text-warning">Tambah Kategori</h2>

            <form action="" method="post" >
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" id="kategori" placeholder="Input nama kategori" required >
                </div>
                <button type="submit" class="btn btn-dark text-white" name="bSimpan">Simpan Kategori</button>
                    <!-- <div class="alert alert-danger mt-3" role="alert">
                        A simple danger alert—check it out!
                    </div> -->
                </form>
                <?php 
                    if (isset($_POST['bSimpan'])) {
                        $kategori = htmlspecialchars($_POST['kategori']);

                        //agar nama categori tidak sama
                        $cekNamaKategori = mysqli_query($koneksi, "SELECT nama FROM kategori WHERE nama='$kategori' ");
                        $jumlahKategoriBaru = mysqli_num_rows($cekNamaKategori);
                        //echo $jumlahKategoriBaru;
                        if ($jumlahKategoriBaru > 0) {
                            ?>
                                <div class="alert alert-danger mt-3" role="alert" >
                                    Sorry, Nama kategori sudah ada.
                                </div>
                            <?php
                        } else {
                            $querySimpan = mysqli_query($koneksi, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                            if ($querySimpan) {
                                ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Nama kategori berhasil di simpan.
                                    </div>
                                    <meta http-equiv="refresh" content="0; url=kategori.php">
                                <?php
                            }else {
                                echo mysqli_error($koneksi);
                            }
                        }
                        
                    }
                ?>

        </div>
    <!-- form input -->


        <div class="mt-3">
            <h2 class="text-warning text-center" >List Kategori</h2>

            <div class="table-responsive mt-5">
                <table class="table table-dark table-striped ">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       <?php 
                        //cek dulu(untuk looping data)
                            $jumlah = 1;
                            if ($jumlahKategori == 0) {
                        ?>
                           <tr>
                           <td colspan="3" class="table-danger text-center">Data Produk Kosong</td>
                           </tr>
                        
                        <?php
                            } else {
                               
                                while($dataKategori = mysqli_fetch_array($queryKatergori)) {
                        ?>
                                <tr>
                                    <td> <?php echo $jumlah; ?> </td>
                                    <td> <?php echo $dataKategori['nama']; ?> </td>
                                    <td>
                                        <a href="kategori-detail.php?p=<?php echo $dataKategori['id']; ?>" class="btn btn-dark">
                                        <i class="fa-solid fa-pen-nib" style="color: #FFD43B;"></i>
                                        </a>
                                    </td>

                                </tr>
                        <?php
                                $jumlah++;
                                }
                            }
                       ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    <script src="../bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>