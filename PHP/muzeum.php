<?php
session_start();
$ellenorzes = 'User';
$bejelentkezes_kijelentkezes_felirat = '';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $json_data = file_get_contents('felhasznalok.json');
    $users = json_decode($json_data, true);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                // Felhasználó adatainak megjelenítése
                $vezeteknev = $user['vezNev'];
                $keresztnev = $user['kerNev'];
                $email = $user['email'];
                break; // Ha megtaláltuk a felhasználót, kilépünk a foreach ciklusból
            }
        }
    }
    // Sikeres bejelentkezés
    $ellenorzes =  $_SESSION['username'];
    // Felhasználó be van jelentkezve, kijelentkezési lehetőség megjelenítése
    $bejelentkezes_kijelentkezes_felirat =
        '<a href="kijelentkezes.php" class="sub-menu-link">
            <p class="link-items"><i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i></p>
            <p class="dp_text link-items">Kijelentkezés</p>
            <p class="caret link-items">></p>
         </a>';
} else {
    // Felhasználó nincs bejelentkezve, bejelentkezési lehetőség megjelenítése
    $bejelentkezes_kijelentkezes_felirat =
        '<a href="bejelentkezes.php" class="sub-menu-link">
            <p class="link-items"><i class="fa-solid fa-right-to-bracket fa-xl"></i></p>
            <p class="dp_text link-items">Bejelentkezés</p>
            <p class="caret link-items">></p>
         </a>';
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/muzeum.css">
    <link rel="stylesheet" href="../CSS/dropdown.css">
    <link rel="stylesheet" href="../CSS/slideshow.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
    <title>Múzeum</title>
</head>

<body>
    <header>
        <h1>Múzeum</h1>
    </header>
    <main>
        <nav class="navbar">
            <ul>
                <li><a href="../index.php">Főoldal</a></li>
                <li><a href="irattar.php">Irattár</a></li>
                <li><a href="fogalomtar.php">Fogalomtár</a></li>
                <li><a onclick="toggleMenu()">Szekta</a></li>
            </ul>
            <div id="dropdown">
                <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <?php
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            echo '<div class="user-info">
                                    <img id="user-pic" src="' . $user['profil-kep'] . '" alt="felhasználó képe">
                                    <h3 id="username">' . $ellenorzes . '</h3>
                                  </div>
                                  <hr>';
                            echo '<a href="profil.php" class="sub-menu-link">
                                    <p class="link-items"><i class="fa-regular fa-circle-user fa-xl"></i></p>
                                    <p class="dp_text link-items">Profil</p>
                                    <p class="caret link-items">></p>
                                  </a>';

                            echo '<a href="forum.php" class="sub-menu-link">
                                  <p class="link-items"><i class="fa-solid fa-message fa-xl"></i></p>
                                  <p class="dp_text link-items">Fórum</p>
                                  <p class="caret link-items">></p>
                                </a>';
                        }
                        ?>
                        <?php echo $bejelentkezes_kijelentkezes_felirat; ?>
                        <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                            echo '<a href="regisztracio.php" class="sub-menu-link">
                            <p class="link-items"><i class="fa-regular fa-registered fa-xl"></i></p>
                            <p class="dp_text link-items">Regisztráció</p>
                            <p class="caret link-items">></p>
                        </a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>

        <a href="#"><img id="ugras" src="../IMG/logo.jpg" alt="oldal tetejére" title="oldal tetejére" width="92"></a>

        <div class="container">

            <p class="ismerteto">
                A kozmikus horror megalkotójának számos gondolata maradt rá az utókorra. Az ily gondolatok
                szerelmeseinek ajánljuk figyelmébe múzeumunkat, ahol összegyűjttöttük a költő legelgondolkodtatóbb
                idézeteit, valamint a Cthulhu-mítosz által ihletett ilussztrációkat.
                <br>
                Jó
                szórakozást!
            </p>

        </div>

        <div id="quotes">
            <div id="quoteDisplay">"Generálj idézeteket, hogy betekintést nyerhess Lovecraft gondolkodásmódjába!"</div>
            <button onclick="newQuote()">Idézet generálása</button>
            <script src="/JAVASCRIPT/qoute_gen.js"></script>
        </div>
        <hr style="margin-top: 2em; margin-bottom: 2em;">

        <!-- Slideshow container -->
        <div id="container">
            <div class="slideshow-container">

                <!-- Képel felirattal és számozással -->
                <div class="mySlides fade">
                    <img src="../IMG/muzeum/cthulhu.jpg" alt="kep1" style="width:100%">
                </div>

                <div class="mySlides fade">
                    <img src="../IMG/muzeum/cthulhu2.jpg" alt="kep2" style="width:100%">
                </div>

                <div class="mySlides fade">
                    <img src="../IMG/muzeum/cthulhu3.jpg" alt="kep3" style="width:100%">
                </div>

                <div class="mySlides fade">
                    <img src="../IMG/muzeum/forest.jpg" alt="kep1" style="width:100%">
                </div>

                <div class="mySlides fade">
                    <img src="../IMG/muzeum/church.jpg" alt="kep2" style="width:100%">
                </div>

                <div class="mySlides fade">
                    <img src="../IMG/muzeum/sky.jpg" alt="kep3" style="width:100%">
                </div>

                <div class="mySlides fade">
                    <img src="../IMG/muzeum/blood_of_izu_16-9.jpg" alt="kep3" style="width:100%">
                </div>

            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
    </main>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        // Előző/következő kontroll
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail kép kontroll
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex - 1].style.display = "block";
        }
    </script>
</body>



</html>