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
                        <h3 class=" text-center mt-3 mb-3">Sınav ekleme</h3>
                        <div class="row g-3">
                                    <?php
                                    if($_SESSION['rol']=='Öğretmen') {
                                        if(!isset($_GET['sinav'])) {
                                            echo "<div class='form-floating mb-3 col-md-6'>";
                                            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                                            $sql = "SELECT lesson_name,id FROM t_lessons WHERE teacher_user_id=?";
                                            $sonuc = $db->prepare($sql);
                                            $sonuc->execute([$_SESSION['kullanici']]);
                                            $ders = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                                            echo '<select class="form-select" name="ders">
                                            <option selected>Ders Seçiniz</option>';
                                            foreach ($ders as $d) {
                                                echo "<option value='{$d['id']}'>{$d['lesson_name']}</option>";
                                            }
                                            echo "</select>";
                                            echo '</div>';
                                            $dersid=htmlspecialchars($_GET['dersid']);
                                            $dersadi=htmlspecialchars($_GET['dersadi']);
                                            $classname=htmlspecialchars($_GET['sinifadi']);
                                            $classN=htmlspecialchars($_GET['sinif']);
                                            $ogrid=htmlspecialchars($_GET['ogrid']);
                                            $namee=htmlspecialchars($_GET['isim']);
                                            $surnamee=htmlspecialchars($_GET['soyad']);
                                            $datee=htmlspecialchars($_GET['tarih']);
                                            $exam=htmlspecialchars($_GET['sinav']);
                                            echo '<div class="form-floating mb-3 col-md-6">
                                                    <input type="datetime-local" class="form-control form-control-lg bg-gradient" name="tarih" placeholder="Tarih ve saatini giriniz" >
                                                    <label for="datetime-local">Tarih ve saatini giriniz</label>
                                                </div>';
                                        }else{
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='{$dersid}' value='{$dersadi}' disabled>
                                                  <label for='text'>Ders</label>
                                                  </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='{$classname}' value='{$classN}' disabled>
                                                    <label for='text'>Sınıf</label>
                                                  </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='{$ogrid}' value='{$namee} {$surnamee}' disabled>
                                                     <label for='text'>Ad Soyad</label>
                                                  </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='datetime-local' class='form-control form-control-lg bg-gradient rounded-5' name='yenitarih' value='{$datee}' placeholder='Tarih ve saatini giriniz' >
                                                    <label for='datetime-local'>Tarih ve saatini giriniz</label>
                                                </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='yeninot' placeholder='ders' value='{$exam}' >
                                                    <label for='text'>Ders</label>
                                                </div>";
                                        }
                                    }elseif($_SESSION['rol']=='Admin'){
                                        if(!isset($_GET['sinav'])) {
                                            echo "<div class='form-floating mb-3 col-md-6'>";
                                            echo '<select class="form-select" name="ders">
                                    <option selected>Ders Seçiniz</option>';
                                            $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                                            $sql = "SELECT t_lessons.lesson_name,t_users.name,t_lessons.id FROM t_lessons 
                                            INNER JOIN t_users ON t_users.id=t_lessons.teacher_user_id";
                                            $sonuc = $db->prepare($sql);
                                            $sonuc->execute();
                                            $ders = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($ders as $d) {
                                                echo "<option value='{$d['id']}'>{$d['lesson_name']}</option>";
                                            }
                                            echo "</select>";
                                            echo '</div>';
                                            echo '<div class="form-floating mb-3 col-md-6">
                                                    <input type="datetime-local" class="form-control form-control-lg bg-gradient" name="tarih" placeholder="Tarih ve saatini giriniz" >
                                                    <label for="datetime-local">Tarih ve saatini giriniz</label>
                                                </div>';
                                        }else{
                                            $dersid=htmlspecialchars($_GET['dersid']);
                                            $dersadi=htmlspecialchars($_GET['dersadi']);
                                            $classname=htmlspecialchars($_GET['sinifid']);
                                            $classN=htmlspecialchars($_GET['sinif']);
                                            $ogrid=htmlspecialchars($_GET['ogrid']);
                                            $namee=htmlspecialchars($_GET['isim']);
                                            $surnamee=htmlspecialchars($_GET['soyad']);
                                            $datee=htmlspecialchars($_GET['tarih']);
                                            $exam=htmlspecialchars($_GET['sinav']);

                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='{$dersid}' value='{$dersadi}' disabled>
                                                  <label for='text'>Ders</label>
                                                  </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='{$classname}' value='{$classN}' disabled>
                                                    <label for='text'>Sınıf</label>
                                                  </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='{$ogrid}' value='{$namee} {$surname}' disabled>
                                                     <label for='text'>Ad Soyad</label>
                                                  </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='datetime-local' class='form-control form-control-lg bg-gradient rounded-5' name='yenitarih' value='{$datee}' placeholder='Tarih ve saatini giriniz' >
                                                    <label for='datetime-local'>Tarih ve saatini giriniz</label>
                                                </div>";
                                            echo "<div class='form-floating mb-3 col-md-6'>
                                                    <input type='text' class='form-control form-control-lg bg-gradient rounded-5 text-center' name='yeninot' placeholder='ders' value='{$exam}' >
                                                    <label for='text'>Ders</label>
                                                </div>";
                                        }
                                    }
                                ?>
                        </div>
                        <div class="d-grid gap-3 form-floating mt-3">
                            <input type="submit" class="btn btn-outline-success form-control-lg" name="buton" value="kaydet">
                        </div>
                </div>
                </form>
                <?php
                if($_SESSION['rol']=='Öğretmen') {
                    if (isset($_POST['tarih'])) {
                        $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                        $tarih = date("Y-m-d H:i:s", strtotime($_POST['tarih']));
                        $ders = $_POST['ders'];
                        $ilksql = "SELECT * FROM t_exams WHERE exam_date=?";
                        $sonuc = $db->prepare($ilksql);
                        $sonuc->execute([$tarih]);
                        $kontrol = $sonuc->fetch(PDO::FETCH_ASSOC);

                        $ilksql = "SELECT t_classes.id as sinifid,t_users.id FROM t_users
                                    INNER JOIN t_classes_students ON t_classes_students.student_id=t_users.id
                                    INNER JOIN t_classes ON t_classes.class_teacher_id=? and t_classes.id=t_classes_students.class_id";
                        $sonuc = $db->prepare($ilksql);
                        $sonuc->execute([$_SESSION['kullanici']]);
                        $bilgi = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                        if ($kontrol == null) {
                            foreach ($bilgi as $b) {
                                $sql = "INSERT INTO t_exams(student_id,lesson_id,class_id,exam_score,exam_date) VALUES (?,?,?,?,?)";
                                $sonuc = $db->prepare($sql);
                                $ekle = $sonuc->execute([$b['id'],$ders,$b['sinifid'],0,$tarih]);
                            }
                            echo "<script>Swal.fire({
                                text: 'Sınav Oluşturulmuştur',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
                        }else {
                            echo "<script>Swal.fire({
                                text: 'Bu tarihte başka sınav bulunmaktadır',
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            });</script>";
                        }
                    }elseif(isset($_POST['yeninot'])){
                        $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                        $sql = "UPDATE t_exams JOIN t_users ON t_exams.student_id = ? and t_exams.lesson_id=? SET t_exams.exam_date=?, t_exams.exam_score=? WHERE t_exams.exam_date=? and t_exams.exam_score=?";
                        $sonuc = $db->prepare($sql);
                        $ekle = $sonuc->execute([htmlspecialchars($_GET['ogrid']),htmlspecialchars($_GET['dersid']),$_POST['yenitarih'],$_POST['yeninot'],htmlspecialchars($_GET['tarih']),htmlspecialchars($_GET['sinav'])]);
                        echo "<script>Swal.fire({
                                text: 'Sınav Güncellenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
                    }
                }elseif ($_SESSION['rol']=='Admin'){
                    if (isset($_POST['ders'])) {
                        $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                        $tarih = date("Y-m-d H:i:s", strtotime($_POST['tarih']));
                        $ders = $_POST['ders'];
                        $ilksql = "SELECT * FROM t_exams WHERE exam_date=?";
                        $sonuc = $db->prepare($ilksql);
                        $sonuc->execute([$tarih]);
                        $kontrol = $sonuc->fetch(PDO::FETCH_ASSOC);

                        $ilksql = "SELECT t_classes.id as sinifid,t_users.id FROM t_users
                                    INNER JOIN t_classes_students ON t_classes_students.student_id=t_users.id
                                    INNER JOIN t_classes ON t_classes.id=t_classes_students.class_id
                                    INNER JOIN t_lessons ON t_lessons.id=?";
                        $sonuc = $db->prepare($ilksql);
                        $sonuc->execute([$ders]);
                        $bilgi = $sonuc->fetchAll(PDO::FETCH_ASSOC);
                        if ($kontrol == null) {
                            foreach ($bilgi as $b) {
                                $sql = "INSERT INTO t_exams(student_id,lesson_id,class_id,exam_score,exam_date) VALUES (?,?,?,?,?)";
                                $sonuc = $db->prepare($sql);
                                $ekle = $sonuc->execute([$b['id'],$ders,$b['sinifid'],0,$tarih]);
                            }
                            echo "<script>Swal.fire({
                                text: 'Sınav Oluşturulmuştur',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
                        }else {
                            echo "<script>Swal.fire({
                                text: 'Bu tarihte başka sınav bulunmaktadır',
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            });</script>";
                        }
                    }elseif(isset($_POST['yeninot'])){
                        $db = new PDO("mysql:host=db;dbname=obs", "root", "1");
                            $sql = "UPDATE t_exams JOIN t_users ON t_exams.student_id = ? and t_exams.lesson_id=? SET t_exams.exam_date=?, t_exams.exam_score=? WHERE t_exams.exam_date=? and t_exams.exam_score=?";
                            $sonuc = $db->prepare($sql);
                            $ekle = $sonuc->execute([htmlspecialchars($_GET['ogrid']),htmlspecialchars($_GET['dersid']),$_POST['yenitarih'],$_POST['yeninot'],htmlspecialchars($_GET['tarih']),htmlspecialchars($_GET['sinav'])]);
                            echo "<script>Swal.fire({
                                text: 'Sınav Güncellenmiştir',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            });</script>";
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