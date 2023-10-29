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
        </div>
        <?php
        include "navbar.php";
        ?>
        <div class="container vh-100 d-flex justify-content-center align-items-center flex-wrap">
            <img src="Resimler/yavuzlar.png" class=" arkaplan">
            <div class=" p-5 rounded-5 bg-light">
            <div class="row">
                <h3 class="text-success">Öğrenci Bilgileri</h3>
                <?php
                $name=htmlspecialchars($_GET['ad']);
                $surname=htmlspecialchars($_GET['soyad']);
                $class=htmlspecialchars($_GET['sinif']);    
                echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5' name='isim' value='{$name}' disabled>
                    <label for='text'>İsim</label>
                </div>";
                echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5' name='soyisim' value='{$surname}' disabled>
                    <label for='text'>Soyisim</label>
                </div>";
                echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5' name='sinif' value='{$class}' disabled>
                    <label for='text'>Sınıf</label>
                </div>";
                ?>
                <h3 class="text-success">Sınav Bilgileri</h3>
                <?php
                $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                $sql = "SELECT t_exams.exam_score,t_lessons.lesson_name,t_exams.exam_date,t_lessons.id FROM t_exams INNER JOIN t_lessons ON t_lessons.id=t_exams.lesson_id and t_exams.student_id=? ORDER BY t_lessons.lesson_name";
                $getir = $db->prepare($sql);
                $getir->execute([htmlspecialchars($_GET['id'])]);
                $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
                $ort=0;
                $sonort=0;
                foreach ($sonuc as $i) {
                    $getir = $db->prepare("SELECT COUNT(*) as sayac FROM t_exams WHERE lesson_id=? and student_id=?");
                    $getir->execute([$i['id'],htmlspecialchars($_GET['id'])]);
                    $sinavsayi = $getir->fetch(PDO::FETCH_ASSOC);
                    foreach ($sonuc as $a){
                        if($i['lesson_name']==$a['lesson_name']){
                            $ort+=$a['exam_score'];
                        }
                       }
                    $sonort=$ort/$sinavsayi['sayac'];
                    $sonort=number_format($sonort,2);
                        echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5' value='{$i['lesson_name']}' disabled>
                    <label for='text'>Ders Adı</label>
                </div>";
                        echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5' value='{$i['exam_date']}' disabled>
                    <label for='text'>Sınav Tarihi</label>
                </div>";
                        echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5' value='{$i['exam_score']}' disabled>
                    <label for='text'>Sınav Puanı</label>
                </div>";
                    echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5' value='{$sonort}' disabled>
                    <label for='text'>Ders Ortalaması</label>
                </div>";
                        echo "<hr>";

                    $ort=0;
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