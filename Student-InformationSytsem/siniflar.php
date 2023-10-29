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
                <table class='table text-light '>
                  <thead>
                    <tr>
                      <th scope='col'></th>
                      <th scope='col'>Sınıf Adı</th>
                      <th scope='col'>Sorumlu Öğretmen</th>
                      <th scope='col'>Sınıf Başarı Ortalaması</th>
                      <th scope='col'>Öğrenci Sayısı</th>
                      <th scope='col'>İşlemler</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $db = new PDO("mysql:host=db;dbname=obs", "root", "1");

                  $ilksql = "SELECT id,class_name FROM t_classes";
                  $sonuc = $db->prepare($ilksql);
                  $sonuc->execute();
                  $siniflar = $sonuc->fetchAll(PDO::FETCH_ASSOC);

                  foreach ($siniflar as $s) {
                      $ilksql = "SELECT class_name FROM t_classes WHERE class_teacher_id IS NULL and class_name=?";
                      $sonuc = $db->prepare($ilksql);
                      $sonuc->execute([$s['class_name']]);
                      $kontrol = $sonuc->fetchAll(PDO::FETCH_ASSOC);

                      if($kontrol==null) {
                          $ilksql = "SELECT t_users.surname,t_classes.class_teacher_id, t_classes.class_name, t_lessons.lesson_name,t_classes.id as sinifid
                               FROM t_users
                               INNER JOIN t_classes ON t_classes.class_teacher_id = t_users.id
                               INNER JOIN t_lessons ON t_lessons.teacher_user_id = t_users.id and t_classes.class_name=? ORDER BY t_classes.class_teacher_id ";
                          $sonuc = $db->prepare($ilksql);
                          $sonuc->execute([$s['class_name']]);
                          $ekle = $sonuc->fetchAll(PDO::FETCH_ASSOC);

                          $sql = "SELECT t_exams.exam_score,t_classes.class_teacher_id,t_classes_students.student_id FROM t_exams INNER JOIN t_lessons ON t_lessons.id=t_exams.lesson_id INNER JOIN t_classes ON t_classes.id=t_exams.class_id INNER JOIN t_classes_students ON t_classes_students.student_id=t_exams.student_id";
                          $sonuc = $db->prepare($sql);
                          $sonuc->execute();
                          $sinav = $sonuc->fetchAll(PDO::FETCH_ASSOC);

                          if($ekle!=null and $sinav!=null) {
                              $id = -1;
                              $dizi = [];
                              $skor=0;
                              foreach ($ekle as $i) {
                                  if ($i['class_teacher_id'] != $id) {
                                      $sql = "SELECT name,surname FROM t_users WHERE id=?";
                                      $sonuc = $db->prepare($sql);
                                      $sonuc->execute([$i['class_teacher_id']]);
                                      $ogretmen = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                                      foreach ($ogretmen as $o) {
                                          $ad = $o['name'];
                                          $soyad = $o['surname'];
                                      }

                                      $sql = "SELECT COUNT(*) as ogrsayi FROM t_classes_students 
                                          INNER JOIN t_classes ON t_classes.class_teacher_id=? and t_classes.id=t_classes_students.class_id";
                                      $sonuc = $db->prepare($sql);
                                      $sonuc->execute([$i['class_teacher_id']]);
                                      $ogrencisayisi = $sonuc->fetch(PDO::FETCH_ASSOC);

                                      $sql = "SELECT t_classes_students.student_id FROM t_classes_students INNER JOIN t_classes ON t_classes.id=t_classes_students.class_id WHERE t_classes.class_teacher_id=? ORDER BY t_classes_students.student_id";
                                      $sonuc = $db->prepare($sql);
                                      $sonuc->execute([$i['class_teacher_id']]);
                                      $ogrenci = $sonuc->fetchAll(PDO::FETCH_ASSOC);

                                      foreach ($ogrenci as $student) {
                                          $ort = 0;
                                          $getir = $db->prepare("SELECT COUNT(DISTINCT lesson_id) as sayac FROM t_exams WHERE student_id=?");
                                          $getir->execute([$student['student_id']]);
                                          $derssayi = $getir->fetch(PDO::FETCH_ASSOC);

                                          $getir = $db->prepare("SELECT COUNT(*) as sayac FROM t_exams WHERE student_id=?");
                                          $getir->execute([$student['student_id']]);
                                          $sinavsayi = $getir->fetch(PDO::FETCH_ASSOC);

                                          foreach ($sinav as $s) {
                                              if($s['student_id']==$student['student_id']){
                                                  $ort += $s['exam_score'];
                                              }
                                          }

                                          if ($sinavsayi['sayac'] != null and $derssayi['sayac'] != null) {
                                              $skor = ($ort / $sinavsayi['sayac']) / $derssayi['sayac'];
                                          }
                                          array_push($dizi, $skor);
                                      }
                                      $ort=0;
                                      foreach ($dizi as $d) {
                                          $ort += $d;
                                      }
                                      $sonort=$ort/$ogrencisayisi['ogrsayi'];
                                      $adsoyad = $ad . ' ' . $soyad;
                                      echo "<tr>
                                      <th scope='row'></th>
                                      <td>{$i['class_name']}</td>
                                      <td>{$adsoyad}</td>
                                      <td>";
                                      echo number_format($sonort,2);
                                      if($_SESSION['rol']=='Admin'){
                                          echo "</td>
                                      <td>{$ogrencisayisi['ogrsayi']}</td>
                                      <td><button class='btn btn-outline-primary form-floating rounded-5 mx-2'><a class='text-decoration-none text-white' href='sinif-ekle-guncelle-goruntule.php?id={$i['class_teacher_id']}&sinifad={$i['class_name']}&ad={$ad}&sinifid={$i['sinifid']}'>Sınıfı Düzenle</a></button><button class='btn btn-outline-danger form-floating rounded-5'><a href='sinifsil.php?id={$i['class_teacher_id']}&sinifid={$i['sinifid']}' class='text-decoration-none text-white'>Sınıfı Sil</a></button><button class='btn btn-outline-primary rounded-5 mx-2'><a class='text-decoration-none text-white' href='sinifsil.php?sorumlu_sil_id={$i['class_teacher_id']}&sinifad={$i['class_name']}'>Sınıf Sorumlusunu Sil</a></button></td>
                                    </tr>
                                  </tbody>";
                                      }elseif($_SESSION['rol']=='Öğretmen'){
                                          echo "</td>
                                          <td>{$ogrencisayisi['ogrsayi']}</td>
                                          <td></td>
                                        </tr>
                                      </tbody>";
                                      }

                                      $id = $i['class_teacher_id'];
                                  }

                              }
                          }else{
                              $ilksql = "SELECT t_users.id, t_users.surname,t_classes.class_teacher_id, t_classes.class_name, t_lessons.lesson_name,t_classes.id as sinifid
                               FROM t_classes
                               INNER JOIN t_lessons ON t_classes.class_teacher_id= t_lessons.teacher_user_id
                               INNER JOIN t_users ON t_users.id = t_classes.class_teacher_id and t_classes.class_name=? ORDER BY t_classes.class_teacher_id ";
                              $sonuc = $db->prepare($ilksql);
                              $sonuc->execute([$s['class_name']]);
                              $ekle = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                              $ogretmenid=-1;
                              foreach ($ekle as $i) {
                                  if ($ogretmenid != $i['id']) {
                                      $sql = "SELECT name,surname FROM t_users WHERE id=?";
                                      $sonuc = $db->prepare($sql);
                                      $sonuc->execute([$i['class_teacher_id']]);
                                      $ogretmen = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                                      foreach ($ogretmen as $o) {
                                          $ad = $o['name'];
                                          $soyad = $o['surname'];
                                      }

                                      $sql = "SELECT COUNT(*) as ogrsayi FROM t_classes_students 
                                              INNER JOIN t_classes ON t_classes.class_teacher_id=? and t_classes.id=t_classes_students.class_id";
                                      $sonuc = $db->prepare($sql);
                                      $sonuc->execute([$i['class_teacher_id']]);
                                      $ogrenci = $sonuc->fetch(PDO::FETCH_ASSOC);
                                      $adsoyad = $ad . ' ' . $soyad;
                                      if($_SESSION['rol']=='Admin'){
                                          echo "<tr>
                                          <th scope='row'></th>
                                          <td>{$i['class_name']}</td>
                                          <td>{$adsoyad}</td>
                                          <td>0</td>
                                          <td>{$ogrenci['ogrsayi']}</td>
                                          <td><button class='btn btn-outline-primary form-floating rounded-5 mx-2'><a class='text-decoration-none text-white' href='sinif-ekle-guncelle-goruntule.php?id={$i['class_teacher_id']}&sinifad={$i['class_name']}&ad={$ad}&sinifid={$i['sinifid']}'>Sınıfı Düzenle</a></button><button class='btn btn-outline-danger form-floating rounded-5'><a href='sinifsil.php?id={$i['class_teacher_id']}&sinifid={$i['sinifid']}' class='text-decoration-none text-white'>Sınıfı Sil</a></button><button class='btn btn-outline-primary rounded-5 mx-2'><a class='text-decoration-none text-white' href='sinifsil.php?sorumlu_sil_id={$i['class_teacher_id']}&sinifad={$i['class_name']}'>Sınıf Sorumlusunu Sil</a></button></td>
                                        </tr>
                                      </tbody>";
                                      }elseif($_SESSION['rol']=='Öğretmen'){
                                          echo "<tr>
                                          <th scope='row'></th>
                                          <td>{$i['class_name']}</td>
                                          <td>{$adsoyad}</td>
                                          <td>0</td>
                                          <td>{$ogrenci['ogrsayi']}</td>
                                          <td></td>
                                         </tr>
                                      </tbody>";
                                      }
                                  }
                                  $ogretmenid=$i['id'];
                              }
                          }
                      }else {

                              $sql = "SELECT COUNT(*) as ogrsayi FROM t_classes_students 
                                          INNER JOIN t_classes ON t_classes.class_name=?";
                              $sonuc = $db->prepare($sql);
                              $sonuc->execute([$s['class_name']]);
                              $ogrenci = $sonuc->fetch(PDO::FETCH_ASSOC);
                              if($_SESSION['rol']=='Admin'){
                                  echo "<tr>
                                      <th scope='row'></th>
                                      <td>{$s['class_name']}</td>
                                      <td>Sorumlu öğretmen bulunmamaktadır</td>
                                      <td>0</td>
                                      <td>{$ogrenci['ogrsayi']}</td>
                                      <td><button class='btn btn-outline-primary form-floating rounded-5 mx-2'><a class='text-decoration-none text-white' href='sinif-ekle-guncelle-goruntule.php?&sinifad={$s['class_name']}&sinifid={$s['id']}'>Sınıfı Düzenle</a></button><button class='btn btn-outline-danger form-floating rounded-5'><a href='sinifsil.php?sinifid_sorumlusuz={$s['id']}' class='text-decoration-none text-white'>Sınıfı Sil</a></button></td>
                                  </tr>
                                  </tbody>";
                              }elseif ($_SESSION['rol']=='Öğretmen'){
                                  echo "<tr>
                                      <th scope='row'></th>
                                      <td>{$s['class_name']}</td>
                                      <td>Sorumlu öğretmen bulunmamaktadır</td>
                                      <td>0</td>
                                      <td>{$ogrenci['ogrsayi']}</td>
                                      <td></td>
                                    </tr>
                                  </tbody>";
                              }

                      }
                  }

                echo "</table>";
                ?>
        </div>
        <footer class="container-fluid clearfix text-light">
            <hr>
            <div class=" text-center mt-4 mb-3">
                © Yavuzlar Web Güvenliği Takımı
            </div>
        </footer>
</body>
</html>