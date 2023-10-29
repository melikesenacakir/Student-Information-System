<?php
if($_SESSION['rol']=='Admin'){
    ?>
<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">İşlemler</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="anasayfa.php">Anasayfa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="ogrenci-ekle-guncelle-goruntule.php">Yeni öğrenci ekle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="sorumlu-ekle-guncelle-goruntule.php">Yeni öğretmen ekle</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="Ders-ekle-guncelle-goruntule.php">Yeni ders ekle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sinif-ekle-guncelle-goruntule.php">Yeni sınıf ekle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sınav-ekle-guncelle-goruntule.php">Yeni sınav ekle</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Görüntüle
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="siniflar.php">Sınıflar</a></li>
                    <li><a class="dropdown-item" href="dersler.php">Dersler</a></li>
                    <li><a class="dropdown-item" href="ogrenciler.php">Öğrenciler</a></li>
                    <li><a class="dropdown-item" href="ogretmenler.php">Öğretmenler</a></li>
                    <li><a class="dropdown-item" href="sinavlar.php">Sınavlar</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</div>
</nav>
    </nav>
<?php
}
?>
<?php
if($_SESSION['rol']=='Öğretmen'){
?>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">İşlemler</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="anasayfa.php">Anasayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sınav-ekle-guncelle-goruntule.php">Yeni sınav ekle</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Görüntüle
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="siniflar.php">Sınıf Bilgisi</a></li>
                        <li><a class="dropdown-item" href="dersler.php">Ders Bilgisi</a></li>
                        <li><a class="dropdown-item" href="ogrenciler.php">Öğrenciler</a></li>
                        <li><a class="dropdown-item" href="sinavlar.php">Sınavlar</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    </div>
    </nav>
    </nav>
<?php
}
?>
<?php
if($_SESSION['rol']=='Öğrenci'){
?>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">İşlemler</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="anasayfa.php">Anasayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="sinavlar.php">Sınavlar</a>
                </li>
            </ul>
        </div>
    </div>
    </div>
    </nav>
    </nav>
<?php
}
?>