<?php
session_start();
session_destroy();
if($_SESSION['rol']=='Admin')
   echo "<script>window.location.href='adminlogin.php'</script>";
elseif ($_SESSION['rol']=='Öğretmen')
    echo "<script>window.location.href='sorumlu-login.php'</script>";
else
    echo "<script>window.location.href='login.php'</script>";