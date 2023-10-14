<?php
session_start();

if (!isset($_SESSION['kullanici'])) {
    echo "<script>alert('Giriş Yapınız');</script>";
    echo "<script>window.location.href='adminlogin.php'</script>";
}