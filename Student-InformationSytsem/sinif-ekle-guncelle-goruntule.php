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
        include "navbar.php";
        ?>
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <img src="Resimler/yavuzlar.png" class=" arkaplan">
    <div class="row">
        <div class=" p-5 rounded-5 bg-light">
            <form action="#" method="post">
                        <?php
                        $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                        if(!isset($_GET['sinifad'])) {
                            $sql = "SELECT * FROM t_users WHERE role='Öğretmen'";
                            $getir = $db->prepare($sql);
                            $getir->execute();
                            $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
                            echo "<h3 class=' text-center mt-3 mb-3'>Sınıf ekleme</h3>
                                    <div class='row g-3'>
                                <div class='form-floating mb-3 col-md-6'>
                                <select class='form-select' name='sınıf'>
                                    <option selected>Sınıf Seçiniz</option>
                                    <option value='zayotem'> 2023 Zayotem</option>
                                    <option value='yavuzlar'>2023 Yavuzlar</option>
                                    <option value='cuberium'>2023 Cuberium</option>
                                </select>
                            </div>
                            <div class='form-floating mb-3 col-md-6'>";

                            echo '<select class="form-select" name="öğretmen">';
                            echo '<option selected>Öğretmen Seçiniz</option>';
                            foreach ($sonuc as $i) {
                                $sql = "SELECT * FROM t_classes WHERE class_teacher_id=?";
                                $getir = $db->prepare($sql);
                                $getir->execute([$i['id']]);
                                $ogretmen = $getir->fetchAll(PDO::FETCH_ASSOC);
                                if ($ogretmen == null) {
                                    $id = $i['id'];
                                    $name = $i['name'];
                                    echo "<option value='$id'>$name</option>";
                                }
                            }
                            echo '</select>';
                            echo "</div>";
                            echo "<div class='form-floating mb-3 col-md-6'>
                                    <input type='text' class='form-control form-control-lg bg-gradient' name='ders' placeholder='ders'>
                                    <label for='text'>Vereceği dersi giriniz</label>
                                </div><hr>";
                        }else {
                            if (isset($_GET['id'])) {
                                $sql = "SELECT * FROM t_users WHERE id!=? and role=?";
                                $getir = $db->prepare($sql);
                                $getir->execute([htmlspecialchars($_GET['id']), 'Öğretmen']);
                                $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);

                                $sql = "SELECT class_name FROM t_classes WHERE class_name!=?";
                                $getir = $db->prepare($sql);
                                $getir->execute([htmlspecialchars($_GET['sinifad'])]);
                                $ogretmen = $getir->fetchAll(PDO::FETCH_ASSOC);
                                $Sinifad=htmlspecialchars($_GET['sinifad']);

                                echo "<h3 class=' text-center mt-3 mb-3'>Sınıf Güncelleme</h3>
                                    <div class='row g-3'><div class='form-floating mb-3 col-md-6'>
                                <select class='form-select' name='yenisınıf'>
                                 <option value='{ $Sinifad}' selected> 2023 { $Sinifad}</option>";
                                foreach ($ogretmen as $o) {
                                    echo "<option value='{$o['class_name']}'> 2023 {$o['class_name']}</option>";
                                }
                                $idsi=htmlspecialchars($_GET['id']);
                                $adi=htmlspecialchars($_GET['ad']);
                                echo "</select>
                            </div>
                            <div class='form-floating mb-3 col-md-6'>";
                                echo '<select class="form-select" name="yeniogretmen">';
                                echo "<option value='{$idsi}' selected>{$adi}</option>";
                                foreach ($sonuc as $i) {
                                    $sql = "SELECT * FROM t_classes WHERE class_teacher_id!=?";
                                    $getir = $db->prepare($sql);
                                    $getir->execute([htmlspecialchars($_GET['id'])]);
                                    $ogretmen = $getir->fetchAll(PDO::FETCH_ASSOC);
                                    $id = $i['id'];
                                    $name = $i['name'];
                                    echo "<option value='$id'>$name</option>";
                                }
                                echo '</select>';
                                echo "</div>";
                            }else{
                                $sql = "SELECT * FROM t_users WHERE id IS NOT NULL and role=?";
                                $getir = $db->prepare($sql);
                                $getir->execute([ 'Öğretmen']);
                                $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);

                                $sql = "SELECT class_name FROM t_classes WHERE class_name!=?";
                                $getir = $db->prepare($sql);
                                $getir->execute([htmlspecialchars($_GET['sinifad'])]);
                                $ogretmen = $getir->fetchAll(PDO::FETCH_ASSOC);
                                $idsi=htmlspecialchars($_GET['id']);
                                $adi=htmlspecialchars($_GET['sinifad']);

                                echo "<h3 class=' text-center mt-3 mb-3'>Sınıf Güncelleme</h3>
                                    <div class='row g-3'><div class='form-floating mb-3 col-md-6'>
                                <select class='form-select' name='yenisınıf'>
                                 <option value='{$idsi}' selected> 2023 {$adi}</option>";
                                foreach ($ogretmen as $o) {
                                    echo "<option value='{$o['class_name']}'> 2023 {$o['class_name']}</option>";
                                }
                                echo "</select>
                            </div>
                            <div class='form-floating mb-3 col-md-6'>";
                                echo '<select class="form-select" name="yeniogretmen">';
                                echo "<option selected>Öğretmen seçiniz</option>";
                                foreach ($sonuc as $i) {
                                    $sql = "SELECT * FROM t_classes WHERE class_teacher_id IS NOT NULL";
                                    $getir = $db->prepare($sql);
                                    $getir->execute();
                                    $ogretmen = $getir->fetchAll(PDO::FETCH_ASSOC);
                                    $id = $i['id'];
                                    $name = $i['name'];
                                    echo "<option value='$id'>$name</option>";
                                }
                                echo '</select>';
                                echo "</div>";
                            }
                        }
                        ?>
                    <div class="form-floating mb-3 col-md-6">
                        <?php
                        if(!isset($_GET['sinifad'])) {
                            $sql = "SELECT * FROM t_users WHERE role='Öğrenci'";
                            $getir = $db->prepare($sql);
                            $getir->execute();
                            $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
                            $dizi = [];
                            echo "<p class='text-center text-bg-primary text-dark rounded-5'>Sınıfa Kaydedilecek öğrencileri seçiniz</p>";
                            foreach ($sonuc as $i) {
                                $id = $i['id'];
                                $name = $i['name'];
                                $surname = $i['surname'];
                                $sql = "SELECT * FROM t_classes_students WHERE ? = student_id";
                                $getir = $db->prepare($sql);
                                $getir->execute([$i['id']]);
                                $cevap = $getir->fetchAll(PDO::FETCH_ASSOC);
                                if ($cevap == null) {
                                    echo '<div class="form-check">';
                                    echo '<label for="ogrenci"></label>';
                                    echo "<input class='form-check-input' name='ogrenci[]' type='checkbox' value='$id' id='check'>";
                                    echo '<label class="form-check-label" for="check">';
                                    echo $name . ' ' . $surname;
                                    echo ' </label>';
                                    echo '</div>';
                                }

                            }
                        }else{
                            $sql = "SELECT * FROM t_users WHERE role='Öğrenci'";
                            $getir = $db->prepare($sql);
                            $getir->execute();
                            $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
                            $dizi = [];
                            echo "<p class='text-center text-bg-primary text-dark rounded-5'>Sınıfaki öğrenciler</p>";
                            foreach ($sonuc as $i) {
                                $id = $i['id'];
                                $name = $i['name'];
                                $surname = $i['surname'];
                                $sql = "SELECT * FROM t_classes_students WHERE ? = student_id and class_id=?";
                                $getir = $db->prepare($sql);
                                $getir->execute([$i['id'],htmlspecialchars($_GET['sinifid'])]);
                                $cevap = $getir->fetchAll(PDO::FETCH_ASSOC);


                                if ($cevap != null) {
                                    echo '<div class="form-check">';
                                    echo '<label for="ogrenci"></label>';
                                    echo "<input class='form-check-input' name='ogrenci[]' type='checkbox' value='$id' id='check' checked>";
                                    echo '<label class="form-check-label" for="check">';
                                    echo $name . ' ' . $surname;
                                    echo ' </label>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="form-check">';
                                    echo '<label for="ogrenci"></label>';
                                    echo "<input class='form-check-input' name='ogrenci[]' type='checkbox' value='$id' id='check'>";
                                    echo '<label class="form-check-label" for="check">';
                                    echo $name . ' ' . $surname;
                                    echo ' </label>';
                                    echo '</div>';
                                }

                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="d-grid gap-3 form-floating">
                    <input type="submit" class="btn btn-outline-success form-control-lg" name="buton" value="kaydet">
                </div>
        </div>
        </form>
        <?php
        if(isset($_POST['öğretmen'])) {
            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
            $sinif = $_POST['sınıf'];
            $rol = $_POST['öğretmen'];
            $ilksql = "SELECT * FROM t_classes WHERE class_name=?";
            $sonuc = $db->prepare($ilksql);
            $sonuc->execute([$sinif]);
            $kontrol_2 = $sonuc->fetchAll(PDO::FETCH_ASSOC);

            $ilksql = "SELECT * FROM t_classes WHERE class_name=? and class_teacher_id IS NULL";
            $sonuc = $db->prepare($ilksql);
            $sonuc->execute([$sinif]);
            $kontrol = $sonuc->fetchAll(PDO::FETCH_ASSOC);

            if ($kontrol_2 == null) {
                $sql = "INSERT INTO t_classes(class_name,class_teacher_id) VALUES (?,?)";
                $sonuc = $db->prepare($sql);
                $ekle = $sonuc->execute([$sinif, $rol]);
                $ogrenciler=$_POST['ogrenci'];

                $ilksql = "SELECT * FROM t_classes WHERE class_name=?";
                $sonuc = $db->prepare($ilksql);
                $sonuc->execute([$sinif]);
                $test = $sonuc->fetch(PDO::FETCH_ASSOC);
                $sinifid=$test['id'];

                $sql = "INSERT INTO t_lessons(teacher_user_id,lesson_name) VALUES (?,?)";
                $sonuc = $db->prepare($sql);
                $ekle = $sonuc->execute([$_POST['öğretmen'], $_POST['ders']]);

                foreach ($ogrenciler as $i) {
                    if(isset($i)){
                        $sql = "INSERT INTO t_classes_students(student_id,class_id) VALUES (?,?)";
                        $sonuc = $db->prepare($sql);
                        $ekle = $sonuc->execute([$i, $sinifid]);
                    }
                }


                echo "<script>Swal.fire({
                                text: 'Sınıf başarıyla eklenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";

             }elseif ($kontrol!=null){
                $sql = "UPDATE t_classes SET t_classes.class_teacher_id=? WHERE t_classes.class_teacher_id IS NULL and t_classes.class_name=?";
                $sonuc = $db->prepare($sql);
                $ekle = $sonuc->execute([$_POST['öğretmen'],$_POST['sınıf']]);

                $ogrenciler=$_POST['ogrenci'];

                $ilksql = "SELECT * FROM t_classes WHERE class_name=?";
                $sonuc = $db->prepare($ilksql);
                $sonuc->execute([$_POST['sınıf']]);
                $test = $sonuc->fetch(PDO::FETCH_ASSOC);
                $sinifid=$test['id'];

                foreach ($ogrenciler as $i) {
                    if(isset($i)){
                        $sql = "INSERT INTO t_classes_students(student_id,class_id) VALUES (?,?)";
                        $sonuc = $db->prepare($sql);
                        $ekle = $sonuc->execute([$i, $sinifid]);
                    }
                }

                echo "<script>Swal.fire({
                                text: 'Sınıf başarıyla eklenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";

                }else{
                echo "<script>Swal.fire({
                                text: 'Bu sınıfın sorumlusu bulunmaktadır',
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            });</script>";
            }

            }elseif (isset($_POST['yeniogretmen'])) {
            if (isset($_GET['id'])) {
                $sql = "UPDATE t_classes JOIN t_users ON t_classes.class_teacher_id = t_users.id SET t_classes.class_teacher_id=?,t_classes.class_name=? WHERE t_classes.class_teacher_id=? and t_classes.class_name=?";
                $sonuc = $db->prepare($sql);
                $ekle = $sonuc->execute([$_POST['yeniogretmen'], $_POST['yenisınıf'], htmlspecialchars($_GET['id']),htmlspecialchars( $_GET['sinifad'])]);
                $ogrenciler=$_POST['ogrenci'];

                $ilksql = "SELECT * FROM t_classes WHERE class_name=?";
                $sonuc = $db->prepare($ilksql);
                $sonuc->execute([$_POST['yenisınıf']]);
                $test = $sonuc->fetch(PDO::FETCH_ASSOC);
                $sinifid=$test['id'];

                $ilksql = "DELETE FROM t_classes_students WHERE class_id=?";
                $sonuc = $db->prepare($ilksql);
                $sonuc->execute([$sinifid]);

                foreach ($ogrenciler as $i) {
                    if(isset($i)){
                        $sql = "INSERT INTO t_classes_students(student_id,class_id) VALUES (?,?)";
                        $sonuc = $db->prepare($sql);
                        $ekle = $sonuc->execute([$i, $sinifid]);
                    }
                }

                echo "<script>Swal.fire({
                                text: 'Sınıf başarıyla güncellenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";

            }else{
                $sql = "UPDATE t_classes SET class_teacher_id=?,class_name=? WHERE class_teacher_id IS NULL and class_name=?";
                $sonuc = $db->prepare($sql);
                $ekle = $sonuc->execute([$_POST['yeniogretmen'], $_POST['yenisınıf'],htmlspecialchars( $_GET['sinifad'])]);
                echo "<script>Swal.fire({
                                text: 'Sınıf başarıyla güncellenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
            }
        }
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