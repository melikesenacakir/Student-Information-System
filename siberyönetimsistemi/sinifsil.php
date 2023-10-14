<?php
$db = new PDO("mysql:host=db;dbname=obs", "root", "1");
if(isset($_GET['sinifid'])) {
    $sql = "DELETE FROM t_classes_students WHERE class_id=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['sinifid']]);
    $sql = "DELETE FROM t_exams WHERE class_id=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['sinifid']]);

    $sql = "DELETE FROM t_classes WHERE class_teacher_id=? and id=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['id'], $_GET['sinifid']]);
}elseif(isset($_GET['sorumlu_sil_id'])){
    $sql = "UPDATE t_classes SET class_teacher_id=? WHERE class_teacher_id=? and class_name=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([null,$_GET['sorumlu_sil_id'],$_GET['sinifad']]);
}elseif(isset($_GET['sinifid_sorumlusuz'])){
    echo $_GET['sinifid_sorumlusuz'];
    $sql = "DELETE FROM t_classes WHERE id=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['sinifid_sorumlusuz']]);
}
echo "<script>window.location.href = 'siniflar.php';</script>";

