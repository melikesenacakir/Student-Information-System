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
                <li><a class="dropdown-item" href="../cikis.php">Çıkış Yap</a></li>
            </ul>
        </div>
        <?php
        include "navbar.php";
        ?>
        <div class="container vh-100 d-flex justify-content-center align-items-center flex-wrap">
            <img src="Resimler/yavuzlar.png" class=" arkaplan">
            <div class="row">
            <form action="#" method="post">
            <select class=" form-floating form-select bg-success mb-3 rounded-4" name="sınıf" onchange="form.submit()">
                <option value="" >Sınıfa göre filtrele</option>
                <option value="zayotem"> 2023 Zayotem</option>
                <option value="yavuzlar">2023 Yavuzlar</option>
                <option value="cuberium">2023 Cuberium</option>
            </select>
            </form>
            <table class='table text-light'>
                  <thead>
                    <tr>
                      <th scope='col'></th>
                      <th scope='col'>İsim</th>
                      <th scope='col'>Soyisim</th>
                      <th scope='col'>Sınıf</th>
                      <th scope='col'>Genel Başarı</th>
                      <th scope='col'>İşlemler</th>
                    </tr>
                  </thead>
                <?php
                $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
            $sql = "SELECT t_users.name,t_users.id, t_users.surname, t_classes.class_name,t_users.username,t_users.password
                           FROM t_classes_students
                           INNER JOIN t_classes ON t_classes_students.class_id = t_classes.id
                           INNER JOIN t_users ON t_classes_students.student_id = t_users.id ORDER BY t_users.id";
            $sonuc = $db->prepare($sql);
            $sonuc->execute();
            $ekle = $sonuc->fetchAll(PDO::FETCH_ASSOC);
            $ort=0;
            if (isset($_POST['sınıf'])) {
                $sinif = $_POST['sınıf'];
                foreach ($ekle as $i) {
                    if ($i['class_name'] == $sinif) {
                        $getir = $db->prepare("SELECT COUNT(DISTINCT lesson_id) as sayac FROM t_exams WHERE student_id=?");
                        $getir->execute([$i['id']]);
                        $derssayi = $getir->fetch(PDO::FETCH_ASSOC);

                        $getir = $db->prepare("SELECT COUNT(*) as sayac FROM t_exams WHERE student_id=?");
                        $getir->execute([$i['id']]);
                        $sinavsayi = $getir->fetch(PDO::FETCH_ASSOC);

                        $getir = $db->prepare("SELECT t_exams.exam_score,t_users.id FROM t_exams INNER JOIN t_users ON t_exams.student_id=t_users.id ORDER BY t_users.id");
                        $getir->execute();
                        $satir = $getir->fetchAll(PDO::FETCH_ASSOC);
                        $ort = 0;
                        foreach ($satir as $s) {
                            if ($s['id'] == $i['id']) {
                                $ort += $s['exam_score'];
                            }
                        }
                        if ($sinavsayi['sayac'] != null and $derssayi['sayac'] != null) {
                            $skor = ($ort / $sinavsayi['sayac']) / $derssayi['sayac'];
                        } else {
                            $skor = 0;
                        }
                        echo "<tbody>
                            <tr>
                              <th scope='row'></th>
                              <td>{$i['name']}</td>
                              <td>{$i['surname']}</td>
                              <td>{$i['class_name']}</td>
                              <td>{$skor}</td>
                              <td class='form-floating'><button class='btn btn-outline-primary rounded-5 '><a href='ogrenci-ekle-guncelle-goruntule.php?ad={$i['name']}&soyad={$i['surname']}&kullaniciadi={$i['username']}&sifre={$i['password']}' class='text-decoration-none text-white'>Öğrenci Düzenle</a></button><button class='btn btn-outline-danger rounded-5 mx-2'><a href='ogrencisil.php?id={$i['id']}' class='text-decoration-none text-white'>Öğrenci Sil</a></button><button class='btn btn-outline-info rounded-5'><a href='ayrinti.php?ad={$i['name']}&soyad={$i['surname']}&sinif={$i['class_name']}&id={$i['id']}' class='text-decoration-none text-white'>Ayrıntılı Görüntüle</a></button></td>
                            </tr>
                          </tbody>";
                    }
                }
            }
                echo "</table>";

            ?>
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