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
<nav class="navbar navbar-dark bg-gradient fixed-top position-relative mb-5">
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
                <li><a class="dropdown-item" href="../profil.php">Profil</a></li>
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
            <?php
            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                $ilksql = "SELECT t_users.name,t_users.id, t_users.surname,t_classes.class_teacher_id, t_exams.exam_date, t_exams.exam_score, t_classes.class_name, t_lessons.lesson_name,t_lessons.id as dersid,t_classes.id as sinifid
                           FROM t_exams
                           INNER JOIN t_lessons ON t_exams.lesson_id = t_lessons.id
                           INNER JOIN t_classes ON t_exams.class_id = t_classes.id
                           INNER JOIN t_users ON t_exams.student_id = t_users.id";
                $sonuc = $db->prepare($ilksql);
                $sonuc->execute();
                $ekle = $sonuc->fetchAll(PDO::FETCH_ASSOC);
if($_SESSION['rol']=='Admin') {
               echo' <form action="#" method="post">
            <select class=" form-floating form-select bg-success mb-3 rounded-4" name="sınıf" onchange="form.submit()">
                <option value="" >Sınıfa göre filtrele</option>
                <option value="zayotem"> 2023 Zayotem</option>
                <option value="yavuzlar">2023 Yavuzlar</option>
                <option value="cuberium">2023 Cuberium</option>
            </select>
            </form>';
                echo "<table class='table text-light '>
                  <thead>
                    <tr>
                      <th scope='col'></th>
                      <th scope='col'>Sınav Tarihi</th>
                      <th scope='col'>Sınıf adı</th>
                      <th scope='col'>Öğrenci ismi</th>
                      <th scope='col'>Öğrenci soyismi</th>
                      <th scope='col'>Ders adı</th>
                      <th scope='col'>Ders ortalaması</th>
                       <th scope='col'>İşlemler</th>
                    </tr>
                  </thead>";
                if (isset($_POST['sınıf'])) {
                    $sinif = $_POST['sınıf'];
                    foreach ($ekle as $i) {
                        if ($i['class_name'] == $sinif) {
                            echo "<tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td>{$i['exam_date']}</td>
                                  <td>{$i['class_name']}</td>
                                  <td>{$i['name']}</td>
                                  <td>{$i['surname']}</td>
                                  <td>{$i['lesson_name']}</td>
                                  <td>{$i['exam_score']}</td>
                                  <td><button class='btn btn-outline-primary rounded-5 mx-2'><a href='sınav-ekle-guncelle-goruntule.php?tarih={$i['exam_date']}&sinif={$i['class_name']}&isim={$i['name']}&soyad={$i['surname']}&ogrid={$i['id']}&dersadi={$i['lesson_name']}&sinav={$i['exam_score']}&dersid={$i['dersid']}&sinifid={$i['sinifid']}' class='text-decoration-none text-white'>Sınav puanı düzenle</a></button><button class='btn btn-outline-danger rounded-5'><a href='sinavsil.php?ogrid={$i['id']}&tarih={$i['exam_date']}&dersid={$i['dersid']}' class='text-decoration-none text-white'>Sınav puanı sil</a></button></td>
                                </tr>
                              </tbody>";
                        }
                    }

                    echo "</table>";
                }
}elseif ($_SESSION['rol']=='Öğretmen'){
                echo' <form action="#" method="post">
            <select class=" form-floating form-select bg-success mb-3 rounded-4" name="sınıf" onchange="form.submit()">
                <option value="" >Sınıfa göre filtrele</option>
                <option value="zayotem"> 2023 Zayotem</option>
                <option value="yavuzlar">2023 Yavuzlar</option>
                <option value="cuberium">2023 Cuberium</option>
            </select>
            </form>';
                echo "<table class='table text-light '>
                  <thead>
                    <tr>
                      <th scope='col'></th>
                      <th scope='col'>Sınav Tarihi</th>
                      <th scope='col'>Sınıf adı</th>
                      <th scope='col'>Öğrenci ismi</th>
                      <th scope='col'>Öğrenci soyismi</th>
                      <th scope='col'>Ders adı</th>
                      <th scope='col'>Ders ortalaması</th>
                       <th scope='col'>İşlemler</th>
                    </tr>
                  </thead>";
                $session=$_SESSION['kullanici'];
                if (isset($_POST['sınıf'])) {
                    $sinif = $_POST['sınıf'];
                    foreach ($ekle as $i) {
                        if ($i['class_name'] == $sinif and $i['class_teacher_id']==$session) {
                            echo "<tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td>{$i['exam_date']}</td>
                                  <td>{$i['class_name']}</td>
                                  <td>{$i['name']}</td>
                                  <td>{$i['surname']}</td>
                                  <td>{$i['lesson_name']}</td>
                                  <td>{$i['exam_score']}</td>
                                  <td><button class='btn btn-outline-primary rounded-5 mx-2'><a href='sınav-ekle-guncelle-goruntule.php?tarih={$i['exam_date']}&sinif={$i['class_name']}&isim={$i['name']}&soyad={$i['surname']}&ogrid={$i['id']}&dersadi={$i['lesson_name']}&sinav={$i['exam_score']}&dersid={$i['dersid']}&sinifid={$i['sinifid']}' class='text-decoration-none text-white'>Sınav puanı düzenle</a></button><button class='btn btn-outline-danger rounded-5'><a href='sinavsil.php?ogrid={$i['id']}&tarih={$i['exam_date']}&dersid={$i['dersid']}' class='text-decoration-none text-white'>Sınav puanı sil</a></button></td>
                                 </tr>
                              </tbody>";
                            }elseif($i['class_name']==$sinif){
                            echo "<tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td>{$i['exam_date']}</td>
                                  <td>{$i['class_name']}</td>
                                  <td>{$i['name']}</td>
                                  <td>{$i['surname']}</td>
                                  <td>{$i['lesson_name']}</td>
                                  <td>{$i['exam_score']}</td>
                                  <td></td>
                                   </tr>
                              </tbody>";
                        }
                        }

                    echo "</table>";
                }
}else {
                echo "<table class='table text-light '>
                  <thead>
                    <tr>
                      <th scope='col'></th>
                      <th scope='col'>Sınav Tarihi</th>
                      <th scope='col'>Sınıf adı</th>
                      <th scope='col'>Öğrenci ismi</th>
                      <th scope='col'>Öğrenci soyismi</th>
                      <th scope='col'>Ders adı</th>
                      <th scope='col'>Ders ortalaması</th>
                    </tr>
                  </thead>";
                $session = $_SESSION['kullanici'];
                foreach ($ekle as $i) {
                    if ($i['id'] == $session) {
                        echo "<tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td>{$i['exam_date']}</td>
                                  <td>{$i['class_name']}</td>
                                  <td>{$i['name']}</td>
                                  <td>{$i['surname']}</td>
                                  <td>{$i['lesson_name']}</td>
                                  <td>{$i['exam_score']}</td>
                              </tbody>";
                    }
                }
            }
            ?>
        </div>
        </div>
        <footer class="container-fluid fixed-bottom text-light">
            <hr>
            <div class=" text-center mt-4 mb-3">
                © Yavuzlar Web Güvenliği Takımı
            </div>
        </footer>
</body>
</html>