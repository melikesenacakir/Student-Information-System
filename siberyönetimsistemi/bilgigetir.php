<?php
$db = new PDO("mysql:host=db;dbname=obs", "root", "1");
$session=$_SESSION['kullanici'];
if($session and !isset($_POST['search'])) {
    $sql = "SELECT * FROM t_users WHERE username=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$session]);
    $data = $sonuc->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $i) {
        echo "Kullanıcı Adı: ".$i['name'];
        echo "<br>";
        echo "Kayıt Tarihi: ".$i['created_ad'];
    }
}