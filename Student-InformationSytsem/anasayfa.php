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
<nav class="navbar navbar-dark bg-gradient fixed-top position-relative">
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
        if($_SESSION['rol']=='Admin'){
            include "navbar.php";
        ?>
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <img src="Resimler/yavuzlar.png" class=" arkaplan">
    <div class="row">
    <div class="card col-md-4 mx-3" style="width: 18rem;">
        <img class="card-img-top" src="Resimler/ogretmen.png" alt="Card image cap">
        <div class="card-body">
            <p class="card-text">
                <?php
                $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                $getir=$db->prepare("SELECT COUNT(*) FROM t_users WHERE role='Öğretmen'");
                $getir->execute();
                $sonuc = $getir->fetch(PDO::FETCH_ASSOC);
                echo "Mevcut Öğretmen Sayısı : ".$sonuc['COUNT(*)'];
                ?>
            </p>
        </div>
    </div>
    <div class="card col-md-4 mx-3" style="width: 18rem;">
        <img class="card-img-top" src="Resimler/ogrenci.png" alt="Card image cap">
        <div class="card-body">
            <p class="card-text">
                <?php
                $getir=$db->prepare("SELECT COUNT(*) FROM t_users WHERE role='Öğrenci'");
                $getir->execute();
                $sonuc = $getir->fetch(PDO::FETCH_ASSOC);
                echo "Mevcut Öğrenci Sayısı : ".$sonuc['COUNT(*)'];
                ?>
            </p>
        </div>
    </div>
    <div class="card col-md-4 mx-3" style="width: 18rem;">
        <img class="card-img-top" src="Resimler/sınıf.png" alt="Card image cap">
        <div class="card-body">
            <p class="card-text">
                <?php
                $getir=$db->prepare("SELECT COUNT(*) FROM t_classes");
                $getir->execute();
                $sonuc = $getir->fetch(PDO::FETCH_ASSOC);
                echo "Mevcut Sınıf Sayısı : ".$sonuc['COUNT(*)'];
                ?>
            </p>
        </div>
    </div>
    </div>
</div>
<?php
}
?>
<?php
if($_SESSION['rol']=='Öğretmen'){
    include "navbar.php";
?>
<div class="container vh-100 d-flex justify-content-center align-items-center flex-wrap">
    <img src="Resimler/yavuzlar.png" class=" arkaplan">
    <div class="row">
        <div class="card col-md-4 mx-3" style="width: 18rem;">
            <img class="card-img-top" src="Resimler/sinif.png" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">
                    <?php

                    $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                    $session=$_SESSION['kullanici'];
                    $yeni=$db->prepare("SELECT * FROM t_classes WHERE class_teacher_id=?");
                    $yeni->execute([$session]);
                    $sinif=$yeni->fetchAll(PDO::FETCH_ASSOC);

                    $ilksql = "SELECT t_users.name,t_users.id,t_classes.class_teacher_id, t_exams.exam_score, t_classes.class_name
                           FROM t_exams
                           INNER JOIN t_classes ON t_classes.class_teacher_id= ?
                           INNER JOIN t_users ON t_exams.student_id = t_users.id ORDER BY t_users.id ";
                    $sonuc = $db->prepare($ilksql);
                    $sonuc->execute([$session]);
                    $ekle = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                    $dizi=[];
                    if ($sinif!=null){
                        $sql = "SELECT COUNT(*) as ogrsayi FROM t_classes_students 
                                  INNER JOIN t_classes ON t_classes.class_teacher_id=? and t_classes.id=t_classes_students.class_id";
                        $getir = $db->prepare($sql);
                        $getir->execute([$session]);
                        $sonuc = $getir->fetch(PDO::FETCH_ASSOC);
                        echo "Mevcut Öğrenci Sayısı : ".$sonuc['ogrsayi'];
                        echo "<br>";
                        $onceki=-1;
                        $ort=0;
                        foreach ($ekle as $i) {
                            if($i['id']!=$onceki) {
                                $getir = $db->prepare("SELECT COUNT(DISTINCT lesson_id) as sayac FROM t_exams WHERE student_id=?");
                                $getir->execute([$i['id']]);
                                $derssayi = $getir->fetch(PDO::FETCH_ASSOC);


                                $getir = $db->prepare("SELECT COUNT(*) as sayac FROM t_exams WHERE student_id=?");
                                $getir->execute([$i['id']]);
                                $sinavsayi = $getir->fetch(PDO::FETCH_ASSOC);

                                $ort = 0;
                                foreach ($ekle as $s) {
                                    if ($i['id']==$s['id']) {
                                        $ort += $s['exam_score'];
                                    }
                                }
                                if ($sinavsayi['sayac'] != null and $derssayi['sayac'] != null) {
                                    $skor = ($ort / $sinavsayi['sayac']) / $derssayi['sayac'];
                                }
                                array_push($dizi, $skor);
                            }
                            $onceki=$i['id'];
                        }
                        $ort=0;
                        foreach ($dizi as $d) {
                            $ort += $d;
                        }
                        $sinifort=$ort/$sonuc['ogrsayi'];
                        echo "Sınıf başarı ortalaması : " . number_format($sinifort,2);
                    }else{
                        echo "Görüntülenecek sınıfınız bulunmamaktadır";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
    <?php
     }
    ?>
<?php
if($_SESSION['rol']=='Öğrenci'){
    include 'navbar.php';
?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <img src="Resimler/yavuzlar.png" class=" arkaplan">
    <div class="row">
        <div class="card col-md-4 mx-3" style="width: 18rem;">
            <img class="card-img-top" src="Resimler/sinif.png" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">
                    <?php
                    $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                    $getir=$db->prepare("SELECT t_classes.class_name FROM t_classes INNER JOIN t_classes_students ON t_classes_students.student_id=?");
                    $getir->execute([$_SESSION['kullanici']]);
                    $sinifadi = $getir->fetch(PDO::FETCH_ASSOC);
                    if($sinifadi!=null){
                        echo "Bulunduğu sınıf: ".$sinifadi['class_name'];
                        echo "<br>";
                    }else{
                        echo "Sınıfı Bulunmamaktadır";
                        echo "<br>";
                    }
                    $getir=$db->prepare("SELECT COUNT(*) FROM t_exams WHERE student_id=?");
                    $getir->execute([$_SESSION['kullanici']]);
                    $satir = $getir->fetch(PDO::FETCH_ASSOC);
                    echo "Sınav Sayısı: ".$satir['COUNT(*)'];
                    echo "<br>";
                    $getir=$db->prepare("SELECT * FROM t_exams WHERE student_id=?");
                    $getir->execute([$_SESSION['kullanici']]);
                    $skorsonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
                    $getir=$db->prepare("SELECT COUNT(DISTINCT lesson_id) as sayac FROM t_exams WHERE student_id=?");
                    $getir->execute([$_SESSION['kullanici']]);
                    $sonuc = $getir->fetch(PDO::FETCH_ASSOC);
                    $ort=0;
                    if($skorsonuc!=null and $sonuc['sayac']!=0) {
                        foreach ($skorsonuc as $i) {
                            $ort += $i['exam_score'];
                        }
                        $ort = $ort / $satir['COUNT(*)'];
                        $ogrenci=$ort/$sonuc['sayac'];
                        echo "Genel başarı ortalaması : " . number_format($ogrenci,2);
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
        <footer class="container-fluid clearfix text-light">
            <hr>
            <div class=" text-center mt-4 mb-3">
                © Yavuzlar Web Güvenliği Takımı
            </div>
        </footer>
</body>
</html>