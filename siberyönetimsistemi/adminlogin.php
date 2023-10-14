<?php
session_start();
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="sweetalert2/sweetalert2.all.min.js"></script>
    <title>SİBER VATAN YETKİNLİK MERKEZİ</title>
    <link rel="icon" href="Resimler/yavuzlar.png">
</head>
<body class="bg-dark">
<h1 class="fixed-top text-center text-light mt-3">SİBER VATAN YETKİNLİK MERKEZİ BİLGİ SİSTEMİ</h1>
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <img src="Resimler/yavuzlar.png" class=" arkaplan">
    <div class="row">
        <div class=" p-5 rounded-5 bg-gradient">
            <form action="#" method="post">
                <h3 class=" text-center text-light mt-3">ADMİN</h3>
                <div class="form-floating mb-3 mt-5">
                    <input type="text" class="form-control form-control-lg bg-secondary" id="kullaniciadi" name="kullaniciadi" placeholder="Kullanıcı Adınız">
                    <label for="text">Kullanıcı Adınız</label>
                </div>
                <div class="form-floating mb-5">
                    <input type="password" class="form-control form-control-lg bg-secondary" id="password" name="password" placeholder="Şifreniz">
                    <label for="Password">Şifreniz</label>
                    <div class="d-grid gap-3 mt-3">
                        <input type="submit" class="btn btn-outline-danger form-control-lg" name="buton" value="giriş yap">
                    </div>
                </div>
                <div class="form-floating">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"  class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                        <a href="sorumlu-login.php" class="text-decoration-none text-black">Sorumlu Giriş Sistemi</a>
                    </div>
            </form>
            <?php
            if($_POST){
                try {
                    $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                    $kadi=strip_tags($_POST['kullaniciadi']);
                    $sifre = $_POST['password'];
                    $getir=$db->prepare("SELECT password FROM t_users WHERE username=? and role=?");
                    $getir->execute([$kadi,'Admin']);
                    $login = $getir->fetch(PDO::FETCH_ASSOC);
                    if(isset($login['password']) and password_verify($sifre,$login['password'])){
                        $yeni=$db->prepare("SELECT id FROM t_users WHERE username=?");
                        $yeni->execute([$kadi]);
                        $session = $yeni->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['kullanici']=$session['id'];
                        $_SESSION['rol']='Admin';
                        echo "<script>window.location.href = 'anasayfa.php';</script>";

                    }else{
                        echo "<script>Swal.fire({title: 'Error!',text: 'Hatalı kullanıcı adı veya şifre',icon: 'error',confirmButtonText: 'Tekrar dene'})</script>";
                    }

                }catch(PDOException $par){
                    echo $par->getMessage();
                }
                $db=null;
            }
            ?>
        </div>
    </div>
</div>

<footer class="container-fluid clearfix text-light">
    <hr>
    <div class=" text-center mt-4 mb-3">
        © Yavuzlar Web Güvenliği Takımı
    </div>
</footer>
</body>
</html>