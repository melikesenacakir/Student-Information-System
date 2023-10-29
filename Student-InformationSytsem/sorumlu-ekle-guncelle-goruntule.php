<?php
include 'sessioncontrol.php';
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="sweetalert2/sweetalert2.all.min.js"></script>
    <title>SİBER VATAN YETKİNLİK MERKEZİ</title>
    <link rel="icon" href="Resimler/yavuzlar.png">
</head>
<body class="bg-dark">
<nav class="navbar navbar-dark bg-gradient fixed-top">
    <div class="container-fluid">
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="navbar-link text-light" href="#">ADMIN PANEL</a>
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="cikis.php">Çıkış Yap</a></li>
            </ul>
            </li>
        </div>
        <?php
        include "navbar.php";
        ?>
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <img src="Resimler/yavuzlar.png" class=" arkaplan">
    <div class="row">
        <div class=" p-5 rounded-5 bg-light">
            <?php
            try{
                if(!isset($_GET['name'])) {
                    echo " <form action='#' method='post'>
                    <h3 class=' text-center mt-3'>Sorumlu ekleme</h3>
                <div class='row g-3'>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='text' class='form-control form-control-lg bg-gradient' name='ad' placeholder='Ad' >
                        <label for='text'>Ad</label>
                    </div>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='text' class='form-control form-control-lg bg-gradient' name='soyad' placeholder='Soyad' >
                        <label for='text'>Soyad</label>
                    </div>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='text' class='form-control form-control-lg bg-gradient' name='kullaniciadi' placeholder='Kullanıcı Adınız' >
                        <label for='text'>Kullanıcı Adı</label>
                    </div>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='password' class='form-control form-control-lg bg-gradient' id='password' name='password' placeholder='Şifreniz'>
                        <label for='Password'>Şifre</label>
                    </div>
                    <div class='d-grid gap-3 form-floating'>
                    <input type='submit' class='btn btn-outline-success form-control-lg' name='buton' value='kaydet'>
                </div>
                </div>
            </form>";
                    if (isset($_POST['password'])) {
                        $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                        $sql = "INSERT INTO t_users(name,surname,username,password,role,created_at) VALUES (?,?,?,?,?,current_timestamp());";
                        $sonuc = $db->prepare($sql);
                        $sifre = $_POST['password'];
                        $kadi = $_POST['kullaniciadi'];
                        $ad = $_POST['ad'];
                        $soyad = $_POST['soyad'];
                        $rol = 'Öğretmen';
                        $hash = password_hash($sifre, PASSWORD_ARGON2ID);
                        $ekle = $sonuc->execute([$ad, $soyad, $kadi, $hash, $rol]);
                        echo "<script>Swal.fire({
                                text: 'Yeni sorumlu başarıyla eklenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
                    }
                }else{
                    $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                    $name=htmlspecialchars($_GET['name']);
                    $surname=htmlspecialchars($_GET['surname']);
                    $username=htmlspecialchars($_GET['username']);
                    $pass=htmlspecialchars($_GET['password']);
                    echo " <form action='#' method='post'>
                    <h3 class=' text-center mt-3'>Sorumlu Güncelleme</h3>
                <div class='row g-3'>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='text' class='form-control form-control-lg bg-gradient' name='ad' placeholder='Ad' value='{$name}'>
                        <label for='text'>Ad</label>
                    </div>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='text' class='form-control form-control-lg bg-gradient' name='soyad' placeholder='Soyad' value='{$surname}'>
                        <label for='text'>Soyad</label>
                    </div>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='text' class='form-control form-control-lg bg-gradient' name='kadi' placeholder='Kullanıcı Adınız' value='{$username}'>
                        <label for='text'>Kullanıcı Adı</label>
                    </div>
                    <div class='form-floating mb-3 col-md-6'>
                        <input type='password' class='form-control form-control-lg bg-gradient' id='password' name='sifre' placeholder='Şifreniz' value='{$pass}'>
                        <label for='Password'>Şifre</label>
                    </div>
                    <div class='d-grid gap-3 form-floating'>
                    <input type='submit' class='btn btn-outline-success form-control-lg' name='buton' value='kaydet'>
                </div>
                </div>
            </form>";
                    if (isset($_POST['ad'])) {
                        $sifre = $_POST['sifre'];
                        $kadi = $_POST['kadi'];
                        $ad = $_POST['ad'];
                        $soyad = $_POST['soyad'];

                        $sql = "UPDATE t_users SET name=?,surname=?,username=?,password=? WHERE name=? and surname=? and username=? and password=?;";
                        $sonuc = $db->prepare($sql);
                        $hash = password_hash($sifre, PASSWORD_ARGON2ID);
                        $sonuc->execute([$ad, $soyad, $kadi, $hash,htmlspecialchars($_GET['name']),htmlspecialchars($_GET['surname']),htmlspecialchars($_GET['username']),htmlspecialchars($_GET['password'])]);
                        echo "<script>Swal.fire({
                                text: 'sorumlu başarıyla güncellenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
                    }
                }
            }catch(Exception $e) {
                echo "<script>Swal.fire({
                                text: 'kullanıcı adı kullanılmakta',
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            });</script>";
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