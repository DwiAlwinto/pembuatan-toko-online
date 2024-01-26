<?php 
    session_start();
    ob_start(); //!penting ini win error modifier
    require "../koneksi/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.2/css/bootstrap.min.css">
    <title>login</title>
    <style>
        .main{
            height: 100vh;
        }
        .login-box{
            width: 500px;
            height: 300px;
            box-sizing: border-box;
            border-radius: 15px;
            
        }
    </style>
</head>
<body>
    <div class="main d-flex justify-content-center align-items-center flex-column">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div>
                    <h3 class="text-warning text-center">Login Admin</h3>
                </div>
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" require>
                </div>
                <div>
                    <label for="password" >Password</label>
                    <input type="password" class="form-control" name="password" id="password" require>
                </div>
                <div>
                    <button type="submit" class="btn btn-warning form-control mt-4 text-white" name="btnLogin">Login</button>
                </div>
            </form>
        </div>

        <div class="mt-3" style="width: 500px;" >

            <?php 
                if (isset($_POST['btnLogin'])) {
                    //echo "Tombol di klik";
                    $username = htmlspecialchars($_POST['username']); //! htmlspecialchars(agar user tidak ketik yang aneh2)
                    $password = htmlspecialchars($_POST['password']);

                    //kita akan cek bener atau tidak
                    $cekLogin = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' ");
                    $hasilCek = mysqli_num_rows($cekLogin); //! (mysqli_num_rows = untuk cek jumlah yang ada di tables users admin :echo $hasilCek;)
                    //kita tampung data login user
                    // $dataLogin = mysqli_fetch_array($cekLogin);

                    if ($hasilCek > 0) {
                        //echo $dataLogin['password'];
                        $dataLogin = mysqli_fetch_array($cekLogin);
                       if (password_verify($password, $dataLogin['password'])) {
                            //echo "bener broo";
                            $_SESSION['login'] = true; //ini yang disesion.php
                            $_SESSION['username'] = $dataLogin['username'];
                            header('location: index.php');

                       } else {
                        ?>
                        <div class="alert alert-danger text-center" role="alert">
                            Password Salah
                        </div>
                        <?php
                       }
                    } else {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Akun tidak tersedia
                        </div>
                        <?php
                    }
                }
            ?>
        </div>

    </div>
</body>
</html>