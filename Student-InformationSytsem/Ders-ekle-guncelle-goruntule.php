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
    <?php
    if(!isset($_SESSION['kullanici'])){
        echo "<script>alert('Giriş Yapınız');</script>";
        echo "<script>window.location.href='adminlogin.php'</script>";
    }
    ?>
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
    <div class=" p-5 rounded-5 bg-light">
        <form action="#" method="post">
            <h3 class=" text-center mt-3">Ders ekleme</h3>
            <div class="row g-3">
        <?php
        if (isset($_GET['sorumlu'])) {
            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
            $sql = "SELECT name,id FROM t_users WHERE role='Öğretmen' and id!=?";
            $getir = $db->prepare($sql);
            $getir->execute([htmlspecialchars($_GET['sorumlu'])]);
            $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
            $lessoninfo=htmlspecialchars($_GET['ders_bilgi']);
            $teacher=htmlspecialchars($_GET['sorumlu']);
            $name=htmlspecialchars($_GET['isim']);

            echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient' name='ders' placeholder='ders' value='{$lessoninfo}'>
                    <label for='text'>Ders</label>
                </div>
                <div class='form-floating mb-3 col-md-6'>";
            echo '<select class="form-select p-2" name="öğretmen">';
            echo "<option value='{$teacher}' selected>{$name}</option>";
            foreach ($sonuc as $s) {
                echo "<option value='{$s['id']}'>{$s['name']}</option>";
            }
            echo '</select>';
            echo "</div>";
            echo '<div class="d-grid gap-3 form-floating">
                    <input type="submit" class="btn btn-outline-success form-control-lg" name="buton" value="kaydet">
                </div>
            </div>
        </form>';
        if(isset($_POST['öğretmen'])) {
            $tid = $_POST['öğretmen'];
            $ders = $_POST['ders'];

            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                $sql = "UPDATE t_lessons JOIN t_users ON t_lessons.teacher_user_id = t_users.id SET t_lessons.teacher_user_id=?,t_lessons.lesson_name=? WHERE t_lessons.teacher_user_id=? and t_lessons.lesson_name=? and t_lessons.id=?";
                $sonuc = $db->prepare($sql);
                $sonuc->execute([$tid, $ders,htmlspecialchars($_GET['sorumlu']),htmlspecialchars( $_GET['ders_bilgi']),htmlspecialchars( $_GET['id'])]);
                echo "<script>Swal.fire({
                                text: 'Ders başarıyla guncellenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
            }
        }elseif (isset($_GET['sorumlusu_olmayan_ders'])){
            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
        $sql = "SELECT name,id FROM t_users WHERE role='Öğretmen'";
        $getir = $db->prepare($sql);
        $getir->execute();
        $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
       
         $lesson=htmlspecialchars($_GET['sorumlusu_olmayan_ders']);
        echo "<div class='form-floating mb-3 col-md-6'>
                    <input type='text' class='form-control form-control-lg bg-gradient' name='ders' placeholder='ders' value='{$lesson}'>
                    <label for='text'>Ders</label>
                </div>
                <div class='form-floating mb-3 col-md-6'>";
        echo '<select class="form-select p-2" name="öğretmen">';
            echo '<option selected>Öğretmen Seçiniz</option>';
        foreach ($sonuc as $s) {
            echo "<option value='{$s['id']}'>{$s['name']}</option>";
        }
        echo '</select>';
        echo "</div>";
        echo '<div class="d-grid gap-3 form-floating">
                    <input type="submit" class="btn btn-outline-success form-control-lg" name="buton" value="kaydet">
                </div>
            </div>
        </form>';
        if(isset($_POST['öğretmen'])) {
            $tid = $_POST['öğretmen'];
            $ders = $_POST['ders'];
            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
            $sql = "UPDATE t_lessons SET teacher_user_id=?,lesson_name=? WHERE teacher_user_id IS NULL and lesson_name=? ";
            $sonuc = $db->prepare($sql);
            $sonuc->execute([$tid, $ders, $ders]);

            echo "<script>Swal.fire({
                                text: 'Ders başarıyla guncellenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
        }
        }else{
            echo '<div class="form-floating mb-3 col-md-6">
                    <input type="text" class="form-control form-control-lg bg-gradient" name="ders" placeholder="ders" >
                    <label for="text">Ders</label>
                </div>
                <div class="form-floating mb-3 col-md-6">';
                $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
            $sql = "SELECT * FROM t_users WHERE role='Öğretmen'";
            $getir = $db->prepare($sql);
            $getir->execute();
            $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
            echo '<select class="form-select p-2" name="öğretmen">';
            echo '<option selected>Öğretmen Seçiniz</option>';
            foreach ($sonuc as $i){
                $id=$i['id'];
                $name=$i['name'];
                echo "<option value='$id'>$name</option>";
            }
            echo '</select>';
            echo "</div>";
            echo '<div class="d-grid gap-3 form-floating">
                    <input type="submit" class="btn btn-outline-success form-control-lg" name="buton" value="kaydet">
                </div>
            </div>
        </form>';
            if (isset($_POST['öğretmen'])) {
                $tid = $_POST['öğretmen'];
                $ders = $_POST['ders'];
                $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                $sql = "SELECT * FROM t_users INNER JOIN t_lessons ON t_lessons.lesson_name=? and t_lessons.teacher_user_id!=null";
                $getir = $db->prepare($sql);
                $getir->execute([$ders]);
                $sonuc = $getir->fetchAll(PDO::FETCH_ASSOC);
                if ($sonuc == null) {
                    $sql = "INSERT INTO t_lessons(teacher_user_id,lesson_name) VALUES (?,?)";
                    $sonuc = $db->prepare($sql);
                    $ekle = $sonuc->execute([$tid, $ders]);
                    echo "<script>Swal.fire({
                                text: 'Ders başarıyla eklenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
                } else {
                    echo "<script>Swal.fire({
                                text: 'Ders bulunmaktadır',
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            });</script>";
                }
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