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
        </div>
        <?php
        include "navbar.php";
        ?>
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <img src="Resimler/yavuzlar.png" class=" arkaplan">
    <div class="row">
        <div class="p-5 rounded-5 bg-light-subtle">
            <?php
               include 'bilgigetir.php';
               $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
            $session=$_SESSION['kullanici'];
            $sql = "SELECT * FROM t_users WHERE id=?";
            $sonuc = $db->prepare($sql);
            $sonuc->execute([$session]);
            $data = $sonuc->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $i) {
                if(!isset($_GET['edit'])){
                 echo "Kullanıcı Adı: ".$i['username'];
                 echo "<br>";
                 echo "Kullanıcı Rolü: ".$i['role'];
                $sifre=$i['password'];
                echo '<div class="form-floating">';
                echo "<a class='p-4 text-danger text-decoration-none' href='profil.php?edit=1'>";
                echo "Şifreyi Değiştir";
                echo "</a>";
                echo "</div>";
                }else{
                    $sifre=$i['password'];
                    echo "<form action='#' method='post'>";
                    echo '<div class="form-floating">';
                    echo "<div class='d-flex justify-content-center align-items-center'>";
                    echo "<input type='text' class='rounded-4 col-10 m-3' name='deger'>";
                    echo "<br>";
                    echo "<input type=text name='sifre' value='$sifre' hidden>";
                    echo "<button class='btn btn-outline-danger rounded-5 col-3' id='alert' onclick=''>";
                    echo "Değiştir";
                    echo "</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";
                    if(isset($_POST['deger'])){
                        $t=$_POST['sifre'];
                        $sif = $_POST['deger'];
                        $hash = password_hash($sif, PASSWORD_ARGON2ID);
                        $edit = "UPDATE t_users SET password=? WHERE password=?";
                        $sonuc = $db->prepare($edit);
                        $sonuc->execute([$hash, $t]);
                        echo "<script>Swal.fire({
                                text: 'Şifreniz Başarıyla Değiştirilmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
                    }
                }
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
