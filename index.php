<?php
session_start();
$ellenorzes = 'User';
$bejelentkezes_kijelentkezes_felirat = '';

// Ellenőrizd, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $json_data = file_get_contents('PHP/felhasznalok.json');
    $users = json_decode($json_data, true);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                // Felhasználó adatainak megjelenítése
                $vezeteknev = $user['vezNev'];
                $keresztnev = $user['kerNev'];
                $email = $user['email'];
                $profilkep = $user['profil-kep']; // Profilkép URL-je
                break; // Ha megtaláltuk a felhasználót, kilépünk a foreach ciklusból
            }
        }
    }
    // Sikeres bejelentkezés
    $ellenorzes =  $username;
    // Felhasználó be van jelentkezve, kijelentkezési lehetőség megjelenítése
    $bejelentkezes_kijelentkezes_felirat =
        '<a href="PHP/kijelentkezes.php" class="sub-menu-link">
            <p class="link-items"><i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i></p>
            <p class="dp_text link-items">Kijelentkezés</p>
            <p class="caret link-items">></p>
         </a>';
} else {
    // Felhasználó nincs bejelentkezve, bejelentkezési lehetőség megjelenítése
    $bejelentkezes_kijelentkezes_felirat =
        '<a href="PHP/bejelentkezes.php" class="sub-menu-link">
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
    <link rel="icon" href="IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/dropdown.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
    <title>Főoldal</title>
</head>

<body>
    <header>
        <h1>H.P. Lovecraft</h1>
    </header>
    <main>
        <nav class="navbar">
            <ul>
                <li><a href="PHP/irattar.php">Irattár</a></li>
                <li><a href="PHP/muzeum.php">Múzeum</a></li>
                <li><a href="PHP/fogalomtar.php">Fogalomtár</a></li>
                <li><a onclick="toggleMenu()">Szekta</a></li>
            </ul>
            <div id="dropdown">
                <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <?php
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            echo '<div class="user-info">
                                    <img id="user-pic" src="' . $profilkep . '" alt="felhasználó képe">
                                    <h3 id="username">' . $ellenorzes . '</h3>
                                  </div>
                                  <hr>';
                            echo '<a href="/PHP/profil.php" class="sub-menu-link">
                                    <p class="link-items"><i class="fa-regular fa-circle-user fa-xl"></i></p>
                                    <p class="dp_text link-items">Profil</p>
                                    <p class="caret link-items">></p>
                                  </a>';

                            echo '<a href="/PHP/forum.php" class="sub-menu-link">
                                  <p class="link-items"><i class="fa-solid fa-message fa-xl"></i></i></p>
                                  <p class="dp_text link-items">Fórum</p>
                                  <p class="caret link-items">></p>
                                </a>';
                        }
                        ?>
                        <?php echo $bejelentkezes_kijelentkezes_felirat; ?>
                        <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                            echo '<a href="/PHP/regisztracio.php" class="sub-menu-link">
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

        <a href="#"><img id="ugras" src="IMG/logo.jpg" alt="oldal tetejére" title="oldal tetejére" width="92"></a>

        <div class="container">
            <article>
                <h2>Az íróról</h2>
                <div class="fo">
                    <img src="IMG/HP-Lovecraft.jpeg" alt="H.P. Lovecraft" width="214" height="297" class="left" loading="lazy">
                    <div class="elso">
                        <q>Nem halott az, mi fekszik örökkön,<br>A halál sem ér át végtelen időkön.</q>
                        <p>1890 - 1935</p>
                    </div>
                </div>

                <p>Howard Philips Lovecraft a 20. század elején alkotó amerikai író, költő, valamint publicista
                    volt. Egyedi hangulatú horror novelláiról vált ismertté, melyek az ő általa kitalált részben
                    mitikus, részben valósághű világban játszódnak. Nevével mára már összeforrtak a "Cthulhu-mítosz"
                    és a "kozmikus horror" fogalmak. Műveire nagy benyomást tett Edgar Allan Poe
                    munkássága, de Lovecraft saját maga által felépített mítoszával teljesen új dimenziókba - olykor
                    szó szerint- repítette a horror történetek mesélését. Novelláira jellemző a borzongás, az
                    ismeretlen iszonyattal való szembesülés, ahol a történet főhőse előtt csak egy pillanatra vagy
                    egyáltalán nem lebben fel a boldog tudatlanság fátyla. Történeteinek egyedi hangulatát a végig
                    ott lappangó sejtés és bizonytalanság, a szenvtelen, ember előtti hatalmakkal való találkozás
                    adja meg.</p>
                <p>Meglehet, hogy jobb derűs tudatlanságban leélni életünket ahelyett, hogy megismernénk az
                    univerzum borzalmait, akár egy pillanatra is.</p>
                <p class="masodik">
                    <q>The oldest and strongest emotion of mankind is fear, and the oldest and strongest kind of
                        fear is fear of the unknown.</q>
                </p>


                <p>Miután az apja 1893-ban megőrült, a család Providence-en belül a nagyapja házába költözött, ahol
                    az író is született. Nagyapja 2000 kötetes könyvtára ismertette meg az olvasás szeretetével.
                    Miután a nagyapja meghalt, a házat eladták és a család egy másikat bérelt. Lovecraft 1905-ben a
                    Hope Street High Schoolba iratkozott, de gyenge egészségi állapota miatt képtelen volt
                    elvégezni. Publikálni kezdett a Providence Journalben, a Scientific Americanben, az Evening
                    Tribune-ben és Gleanerben. 1924-ben New Yorkba költözött és elvette feleségül Sonia Haft
                    Greene-t. Házasságuk sikertelen lett, így 1926 áprilisában visszatért Providence-be, ahol a
                    nagynénjével élt.</p>
                <p>Az 1926 és 1933 közötti időszak az egyik legtermékenyebb volt Lovecraft számára. Ekkor írta
                    legnépszerűbb műveit, mint például a Cthulhu hívása, Pickman modellje és a Rémület Dunwichben.
                    Művei főként a Weird Tales-ben és egyéb <abbr title="gazdaságosan kiadott, alacsony minőségű irodalom, ponyva">pulp fiction</abbr>
                    magazinokban jelentek meg.</p>
                <p>
                    Egész életében gyenge egészségi állapota volt, és különféle egészségügyi állapotokkal, például
                    gyomorproblémákkal és krónikus fejfájással küzdött. 1937. március 15-én, mindössze 46 évesen,
                    rákban hunyt el.
                </p>
                <p>
                    Műveinek nagy része csak halála után látott napvilágot, és amit még életében publikált, az sem
                    aratott sikert. Legalább tizenhárom írói álnevéről tudunk. Fordulópontot az 1926-os év
                    jelentett, amikor megismerkedett August Derlethel, akinek szerepe kimagasló volt az író műveinek
                    népszerűsítésében.
                    Lovecraft műveit kevéssé értették meg kortársai, emellett sokan kritizálták stílusát és
                    témaválasztását.
                    <img class="right" src="IMG/lovecraftPortrait.jpg" alt="Illusztráció" width="266" height="384" loading="lazy">
                    Később, az 1930-as évek végén és az 1940-es években, különösen az amerikai fantasztikus irodalom
                    térhódításával
                    egyre több figyelmet kapott. Ezek az évek voltak azok, amikor Lovecraft munkássága kezdett egyre
                    nagyobb
                    <!-- <img class="illustration" src="/IMAGES/portrait.jpg" alt="Illusztráció" width="240" height="360"> -->
                    elismerést kapni az irodalmi körökben, és egyes írók és kritikusok kezdték értékelni a misztikus
                    atmoszféráját és egyedi világépítését.<br>
                </p>
                <p>
                    A későbbi évtizedek során munkája jelentős hatást gyakorolt a horror- és fantasztikus
                    irodalomra, és mára már elismert klasszikusnak számít. <br> Halála után négy évtizeddel rajongói
                    sírkövet emeltek neki <br> <q>Én vagyok a gondviselés</q> ("I AM PROVIDENCE") felirattal.
                </p>

            </article>

            <article>
                <h2>A Cthulhu-mítosz</h2>

                <p>
                    Lovecraft által megálmodott és kiterjesztett irodalmi univerzum, amely misztikus, sötét és
                    hátborzongató világot ábrázol. Ez az irodalmi világ számos novellájában, kisregényében és
                    levelezéseiben jelenik meg, valamint más szerzők is továbbfejlesztették és kibővítették.
                    A mítosz középpontjában állnak az ősidőkből származó, hatalmas és kozmikus lények, akiket
                    istenségként tiszteltek, a Nagy Öregek. Ezek a lények ősi és ismeretlen birodalmakból
                    származnak, és rendkívüli erejük, tudásuk révén túllépnek az emberi értelem határain.
                </p>
                <p>
                    <img class="left" src="IMG/portrait.jpg" alt="Illusztráció" width="216" height="324" loading="lazy">
                    A Cthulhu-mítosz alapvető elemei közé tartoznak a rejtélyes kultuszok és szekták is, amelyek a
                    Nagy Öregeket imádják és szolgálják, valamint az őket körülvevő misztikus és rémisztő tájak és
                    helyszínek, például Innsmouth városa vagy a R'lyeh alatt rejtőző elátkozott város.
                    A mítoszban fontos szerepet játszik az ismeretlen, a megmagyarázhatatlan és a végtelen veszély,
                    amely az emberi értelem és lét határain túl terül el, és hajthatatlanul a háttérben munkálkodik.
                    A Cthulhu-mítosz jelentős hatással volt a fantasztikus irodalomra és a popkultúrára, és azóta is
                    számos adaptációban és továbbfejlesztésben is találkozhatunk vele.
                </p>

            </article>
        </div>
    </main>

    <footer>

    </footer>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

</body>

</html>