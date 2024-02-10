<?php 
    require "session.php";
    require "../koneksi/koneksi.php";
    //echo $_GET['p']; //(p ini adalah id kita hanya samarkan aja(tombol edit)).
    $id = $_GET['p']; //ini tampung ambil id ya 
    $getID = mysqli_query($koneksi, "SELECT * FROM kategori where id='$id' ");
    $dataID = mysqli_fetch_array($getID);
    //var_dump($dataID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Detail</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/adminPanel.css">
    
<body>
    <?php require "navbar.php"; ?>

        <div class="container mt-5">
           <h2>Edit Kategori Detail</h2> 
            <div class="col-12 col-md-6">
                <form action="" method="post">
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $dataID['nama'] ?>" >
                
                    <div class="mt-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-warning text-white" name="editBtn">Edit</button>
                        <button type="submit" class="btn btn-danger" name="deletBtn">Delete</button>

                    </div>
                </form>

            </div>
        </div>

        <!-- untuk fungsi edit ya -->
        <?php 
            if (isset($_POST['editBtn'])) {
                //echo "HAiin WIn";
                $kategori = htmlspecialchars($_POST['kategori']) ;

                if ($dataID['nama']==$kategori) { //ini kondisi tidak di edit hanya klik tombol edit
                    ?>
                    <meta http-equiv="refresh" content="0; url=kategori.php">
                    <?php
                } else {
                    $queryKatergori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama='$kategori' ") ;
                    $jumlahKategori = mysqli_num_rows($queryKatergori);
                    //echo $jumlahKategori;

                    if ($jumlahKategori > 0) {
                        ?>
                            <div class="alert alert-danger mt-3 container" role="alert" >
                                    Sorry, Nama kategori sudah ada.
                            </div>
                        <?php
                    } else {
                        $querySimpan = mysqli_query($koneksi, "UPDATE kategori SET nama='$kategori' WHERE id='$id' ");
                            if ($querySimpan) {
                                ?>
                                    <div class="alert alert-success mt-3 container" role="alert">
                                        Nama kategori berhasil di UPDATE.
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=kategori.php">
                                <?php
                            }else {
                                echo mysqli_error($koneksi);
                            }
                    }
                }
            }

            if (isset($_POST['deletBtn'])) {
                //pengecekan kategori ada tidak di database
                $queryCheckKategori = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori_id='$id' "); //ini menggunakan on delete restrick
                $jumlahDataKategori = mysqli_num_rows($queryCheckKategori);
                echo $jumlahDataKategori;
                //die(); //maksud ya sampai sini aja diproses.

                //pengecekan
                if ($jumlahDataKategori > 0) {
                    ?>
                    <div class="alert alert-warning mt-3 container ">
                        Nama Kategori ini tidak bisa di HAPUS karena sudah digunakan di PRODUK.
                    </div>
                    <?php
                    die();
                }

                $queryDelete = mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$id' ");
                if ($queryDelete) {
                    ?>
                                    <div class="alert alert-success mt-3 container" role="alert">
                                        Nama kategori berhasil di HAPUS.
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=kategori.php">
                    <?php
                } else {
                    echo mysqli_error($koneksi);
                }
            }
        ?>



        <script src="../bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
        <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>