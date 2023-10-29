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
            <table class='table text-light'>
                <?php
                $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                if($_SESSION['rol']=='Admin') {
                    echo "<thead>
                    <tr>
                      <th scope='col'></th>
                      <th scope='col'>Ders Adı</th>
                      <th scope='col'>Sorumlu Adı</th>
                      <th scope='col'>İşlemler</th>
                    </tr>
                  </thead>";
                    $sql = "SELECT t_lessons.lesson_name,t_users.name,t_users.id,t_lessons.id as dersid FROM t_lessons 
                        INNER JOIN t_users ON t_users.id=t_lessons.teacher_user_id ORDER BY t_users.id";
                    $sonuc = $db->prepare($sql);
                    $sonuc->execute();
                    $ders = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                    echo '</select>';
                    echo '<form action="#" method="post">
                        <select class=" form-floating form-select bg-success mb-3 rounded-4" name="sorumlu" onchange="form.submit()">
                            <option value="" >Sorumluya göre filtrele</option>';
                    $temp=-1;
                    foreach ($ders as $k) {
                        if ($k['id'] != $temp) {
                            echo "<option value='{$k['id']}'>{$k['name']}</option>";
                        }
                        $temp=$k['id'];
                    }
                    echo '</select>';
                    if (isset($_POST['sorumlu'])) {
                        foreach ($ders as $d) {
                            $sorumlu = $_POST['sorumlu'];
                            if ($d['id'] == $sorumlu) {
                                echo "
                                <tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td>{$d['lesson_name']}</td>
                                  <td>{$d['name']}</td>
                                  <td class='form-floating '><button class='btn btn-outline-primary rounded-5 ' ><a href='Ders-ekle-guncelle-goruntule.php?ders_bilgi={$d['lesson_name']}&sorumlu={$sorumlu}&isim={$d['name']}&id={$d['dersid']}' class='text-decoration-none text-white'>Ders Düzenle</a></button><button class='btn btn-outline-danger rounded-5 mx-2'><a href='derssil.php?ders_bilgi={$d['lesson_name']}&sorumlu={$sorumlu}&id={$d['dersid']}' class='text-decoration-none text-white'>Ders Sil</a><button class='btn btn-outline-danger rounded-5 mx-2'><a href='derssorumlusil.php?ders_bilgi={$d['lesson_name']}&id={$sorumlu}' class='text-decoration-none text-white'>Ders Sorumlu Sil</a></button></td>
                                </tr>
                              </tbody>";
                            }
                        }
                    }else {
                        $sql = "SELECT lesson_name,id  FROM t_lessons 
                        WHERE teacher_user_id IS NULL";
                        $sonuc = $db->prepare($sql);
                        $sonuc->execute();
                        $kontrol = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                        if ($kontrol == null) {
                            foreach ($ders as $d) {
                                echo "<tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td id='ders'>{$d['lesson_name']}</td>
                                  <td id='isim'>{$d['name']}</td>
                                  <td class='form-floating '><button class='btn btn-outline-primary rounded-5 ' ><a href='Ders-ekle-guncelle-goruntule.php?ders_bilgi={$d['lesson_name']}&sorumlu={$d['id']}&isim={$d['name']}&id={$d['dersid']}' class='text-decoration-none text-white'>Ders Düzenle</a></button><button class='btn btn-outline-danger rounded-5 mx-2'><a href='derssil.php?ders_bilgi={$d['lesson_name']}&sorumlu={$d['id']}&id={$d['dersid']}' class='text-decoration-none text-white'>Ders Sil</a></button></td>
                                 </tr>";
                            }
                            echo "</tbody>";
                        }else{
                            foreach ($ders as $d) {
                                echo "<tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td id='ders'>{$d['lesson_name']}</td>
                                  <td id='isim'>{$d['name']}</td>
                                  <td class='form-floating '><button class='btn btn-outline-primary rounded-5 ' ><a href='Ders-ekle-guncelle-goruntule.php?ders_bilgi={$d['lesson_name']}&sorumlu={$d['id']}&isim={$d['name']}&id={$d['dersid']}' class='text-decoration-none text-white'>Ders Düzenle</a></button><button class='btn btn-outline-danger rounded-5 mx-2'><a href='derssil.php?ders_bilgi={$d['lesson_name']}&sorumlu={$d['id']}&id={$d['dersid']}' class='text-decoration-none text-white'>Ders Sil</a></button><button class='btn btn-outline-danger rounded-5 mx-2'><a href='derssorumlusil.php?ders_bilgi={$d['lesson_name']}&id={$d['id']}' class='text-decoration-none text-white'>Ders Sorumlu Sil</a></button></td>
                                 </tr>";
                            }
                            foreach ($kontrol as $k) {
                                echo "<tbody>
                                <tr>
                                  <th scope='row'></th>
                                  <td id='ders'>{$k['lesson_name']}</td>
                                  <td id='isim'>Sorumlusu Bulunmamaktadır</td>
                                  <td class='form-floating '><button class='btn btn-outline-primary rounded-5 ' ><a href='Ders-ekle-guncelle-goruntule.php?sorumlusu_olmayan_ders={$k['lesson_name']}&id={$k['id']}' class='text-decoration-none text-white'>Ders Düzenle</a></button><button class='btn btn-outline-danger rounded-5 mx-2'><a href='derssil.php?ders_bilgi={$k['lesson_name']}&id={$k['id']}' class='text-decoration-none text-white'>Ders Sil</a></button></td>
                                 </tr>";
                            }
                            echo "</tbody>";
                        }
                    }
                    echo "</table>";
                }elseif($_SESSION['rol']=='Öğretmen') {
                    $sql = "SELECT t_lessons.lesson_name,t_users.name,t_users.id FROM t_lessons 
                        INNER JOIN t_users ON t_users.id=? and t_lessons.teacher_user_id=?";
                    $sonuc = $db->prepare($sql);
                    $sonuc->execute([$_SESSION['kullanici'], $_SESSION['kullanici']]);
                    $ders = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                    echo '<form action="#" method="post">
                        <select class=" form-floating form-select bg-success mb-3 rounded-4" name="ders" onchange="form.submit()">
                            <option value="" >Verilen Dersleri Filtrele</option>';
                    foreach ($ders as $k) {
                        echo "<option value='{$k['lessons_id']}'>{$k['lesson_name']}</option>";
                    }
                    echo '</select>';
                    echo "<thead>
                    <tr>
                      <th scope='col'></th>
                      <th scope='col'>Verilen Dersler</th>
                    </tr>
                  </thead>";
                    foreach ($ders as $d) {
                        if (isset($_POST['ders'])) {
                            if ($d['id'] == $_SESSION['kullanici']) {
                                echo "<tbody>
                                <tr>
                                  <th scope='row'>*</th>
                                  <td>{$d['lesson_name']}</td>
                                  </tr>";
                                echo "</tbody>";
                            }
                        } else {
                            echo "<tbody>
                                <tr>
                                  <th scope='row'>*</th>
                                  <td>{$d['lesson_name']}</td>
                                  </tr>";
                            echo "</tbody>";
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