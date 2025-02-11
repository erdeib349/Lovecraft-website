<?php
session_start();
$ellenorzes = 'User';
$bejelentkezes_kijelentkezes_felirat = '';

// Ellenőrizd, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $json_data = file_get_contents('felhasznalok.json');
    $users = json_decode($json_data, true);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $bookmarks = $user['bookmarks'];
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

// Ellenőrizd, hogy az űrlap elküldése megtörtént-e
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ellenőrizd, hogy a felhasználó be van-e jelentkezve
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // Ellenőrizd, hogy a könyvjelzőzés checkbox be van-e jelölve az egyes könyvek esetén
        if (isset($_POST['lovecraftOsszes1'])) {
            addBookmark($_SESSION['username'], 'Howard Philips Lovecraft összes művei I.');
        }
        if (isset($_POST['lovecraftOsszes2'])) {
            addBookmark($_SESSION['username'], 'Howard Philips Lovecraft összes művei II.');
        }
        if (isset($_POST['lovecraftOsszes3'])) {
            addBookmark($_SESSION['username'], 'Howard Philips Lovecraft összes művei III.');
        }
        if (isset($_POST['necronomicon'])) {
            addBookmark($_SESSION['username'], 'Necronomicon');
        }
        if (isset($_POST['onnanTulrol'])) {
            addBookmark($_SESSION['username'], 'Onnan túlról');
        }
        if (isset($_POST['arnyekInnsmouthFolott'])) {
            addBookmark($_SESSION['username'], 'Árnyék Innsmouth fölött');
        }
        if (isset($_POST['alomFalaMogott'])) {
            addBookmark($_SESSION['username'], 'Az álom fala mögött');
        }
        if (isset($_POST['remuletDunwichben'])) {
            addBookmark($_SESSION['username'], 'Rémület Dunwichben');
        }
        if (isset($_POST['unnep'])) {
            addBookmark($_SESSION['username'], 'Az ünnep');
        }
        if (isset($_POST['haz'])) {
            addBookmark($_SESSION['username'], 'A ház, melyet mindenki elkerül');
        }
        if (isset($_POST['arnyek'])) {
            addBookmark($_SESSION['username'], 'Árnyék az időn túlról');
        }
        if (isset($_POST['hidegLevego'])) {
            addBookmark($_SESSION['username'], 'Hideg levegő');
        }
        if (isset($_POST['cthulhuHivasa'])) {
            addBookmark($_SESSION['username'], 'Cthulhu hívása');
        }
        if (isset($_POST['herbertWest'])) {
            addBookmark($_SESSION['username'], 'Herbert West, az újjáélesztő');
        }
        if (isset($_POST['patkanyok'])) {
            addBookmark($_SESSION['username'], 'Patkányok a falban');
        }
        if (isset($_POST['dologKuszobon'])) {
            addBookmark($_SESSION['username'], 'A dolog a küszöbön');
        }
        if (isset($_POST['randolphVallomas'])) {
            addBookmark($_SESSION['username'], 'Randolph Carter vallomása');
        }
        if (isset($_POST['pickman'])) {
            addBookmark($_SESSION['username'], 'Pickman modellje');
        }
        if (isset($_POST['szinAzUrbol'])) {
            addBookmark($_SESSION['username'], 'Szín az űrből');
        }
        if (isset($_POST['suttogas'])) {
            addBookmark($_SESSION['username'], 'Suttogás a sötétben');
        }
    }
}

// Könyvjelző hozzáadása a felhasználóhoz
function addBookmark($username, $bookTitle)
{
    // Betöltés és feldolgozás a felhasználók adatainak
    $json_data = file_get_contents('felhasznalok.json');
    $users = json_decode($json_data, true);

    // Keressük meg a felhasználót
    foreach ($users as &$user) {
        if ($user['username'] === $username) {
            // Ellenőrizzük, hogy a könyvjelző tömb létezik-e, ha nem, hozzuk létre
            if (!isset($user['bookmarks']) || !is_array($user['bookmarks'])) {
                $user['bookmarks'] = array();
            }
            // Ellenőrizzük, hogy a könyvjelző még nem szerepel-e a felhasználó könyvjelzői között
            if (!in_array($bookTitle, $user['bookmarks'])) {
                // Hozzáadjuk a könyvjelzőt a felhasználó könyvjelzőihez
                $user['bookmarks'][] = $bookTitle;
            }
            break; // Kilépünk a foreach ciklusból, mert megtaláltuk a felhasználót
        }
    }

    // Frissítsd a felhasználók adatait a JSON fájlban
    file_put_contents('felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
}

function isChecked($bookID, $bookmarks)
{
    return in_array($bookID, $bookmarks) ? 'checked' : '';
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/dropdown.css">
    <link rel="stylesheet" href="../CSS/irattar.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
    <title>Irattár</title>
</head>

<body>
    <header>
        <h1>Irattár</h1>
    </header>
    <main>
        <nav class="navbar">
            <ul>
                <li><a href="../index.php">Főoldal</a></li>
                <li><a href="muzeum.php">Múzeum</a></li>
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
            <form action="irattar.php" method="post">

                <p class="ismerteto">
                    Lovecraft élete során termékeny író volt. Habár számos története elveszett, az utókorra
                    hozzávetőleg
                    hatvan novellája maradt. Ez az oldal azon kíváncsi, borzongást kutató egyéneknek szól, kik
                    érdeklődnek az író művei iránt, és támpontot keresnek, hogy melyik lenne számukra érdekes
                    olvasmány. A lentiekben a legnépszerűbb novellák és kötetek szedete található, rövid leírással.
                    <br>
                    Jó
                    szórakozást!
                </p>


                <article>
                    <h2>Kötetek</h2>
                    <details>
                        <summary id="Howard Philips Lovecraft összes művei I.">Howard Philips Lovecraft összes művei I.</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">
                                            <ul>
                                                <li>Első kiadás éve: 2001</li>
                                            </ul>
                                            <p>A H.P. Lovecraft összes prózai művét szisztematikusan összeszedő,
                                                bemutató
                                                három részes könyvsorozat első része.</p>
                                            <p>A libri leírása: <br><q>Szándékunk az volt, hogy sorozatunkkal Lovecraft
                                                    irodalmi
                                                    munkásságáról nyújtsunk hiteles és átfogó képet. Jelen
                                                    összeállításunk
                                                    az
                                                    első darabja annak a háromkötetes gyűjteménynek, mellyel a
                                                    színvonalas
                                                    és
                                                    áttekinthető Lovecraft-összkiadás hiányát kívánjuk pótolni,
                                                    remélhetőleg
                                                    az
                                                    olvasóközönség megelégedésére.</q>
                                            </p>
                                            <p><a href="https://www.szukits.hu/howard-phillips-lovecraft-osszes-muvei-1" target="_blank">Vedd
                                                    meg a kiadótól! <br><br><br>
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="lovecraftOsszes1" name="lovecraftOsszes1" ' . isChecked('Howard Philips Lovecraft összes művei I.', $bookmarks) . '>
                                                    <label for="lovecraftOsszes1">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>

                                        </td>
                                        <td class="masodik-cella">
                                            <img src="../IMG/lovecraftOsszes1.jpg" alt="Lovecraft összes művei I." loading="lazy">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </details>

                    <details>
                        <summary id="Howard Philips Lovecraft összes művei II.">Howard Philips Lovecraft összes művei II.</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">
                                            <ul>
                                                <li>Első kiadás éve: 2003</li>
                                            </ul>
                                            <p>
                                                Jelen összeállítás a második darabja annak a háromkötetes
                                                gyűjteménynek, mellyel a színvonalas és áttekinthető
                                                Lovecraft-összkiadás
                                                hiányát kívánja pótolni, remélhetőleg az olvasóközönség megelégedésére.
                                            </p>
                                            <p><a href="https://www.szukits.hu/howard-phillips-lovecraft-osszes-muvei-2" target="_blank">Vedd
                                                    meg a kiadótól! <br><br><br>
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="lovecraftOsszes2" name="lovecraftOsszes2" ' . isChecked('Howard Philips Lovecraft összes művei II.', $bookmarks) . '>
                                                <label for="lovecraftOsszes2">Könyvjelzőzöm!</label>';
                                                }
                                                ?>

                                            </div>

                                        </td>

                                        <td class="masodik-cella">
                                            <img src="../IMG/lovecraftOsszes2.jpg" alt="Lovecraft összes művei II." loading="lazy">
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Howard Philips Lovecraft összes művei III.">Howard Philips Lovecraft összes művei III.</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">
                                            <ul>
                                                <li>Első kiadás éve: 2005</li>
                                            </ul>
                                            <p>
                                                Jelen összeállítás a harmadik darabja annak a háromkötetes
                                                gyűjteménynek, mellyel a színvonalas és áttekinthető
                                                Lovecraft-összkiadás
                                                hiányát kívánja pótolni, remélhetőleg az olvasóközönség megelégedésére.
                                            </p>
                                            <p><a href="https://www.szukits.hu/howard-phillips-lovecraft-osszes-muvei-3" target="_blank">Vedd
                                                    meg a kiadótól!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="lovecraftOsszes3" name="lovecraftOsszes3" ' . isChecked('Howard Philips Lovecraft összes művei III.', $bookmarks) . '>
                                                <label for="lovecraftOsszes3">Könyvjelzőzöm!</label>';
                                                }
                                                ?>

                                            </div>

                                        </td>
                                        <td class="masodik-cella">
                                            <img src="../IMG/lovecraftOsszes3.jpg" alt="Lovecraft összes művei III." loading="lazy">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Necronomicon">Necronomicon</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">
                                            <ul>
                                                <li>Első kiadás éve: ??</li>
                                            </ul>
                                            <p>

                                                A Necronomicon, más néven a Halottak Könyve, vagy
                                                arab
                                                címmén, a Kitab al-Azif, egy fiktív varázskönyv, amely többször
                                                megjelenik Lovecraft történeteiben. Először
                                                az író 1924-es "A kutya" című rövid történetében szerepelt, bár a
                                                feltételezett szerzője, az "Őrült Arab" Abdul
                                                Alhazred, már egy évvel korábban megjelent Lovecraft "A névtelen város"
                                                című
                                                művében. A munka többek között tartalmazza a Nagy Öregeknek
                                                nevezett lények leírását, történetüket és a megidézésükhöz szükséges
                                                eszközöket. <br> A könyvnek létezik valós változata is.
                                            </p>
                                            <p><a href="https://www.libri.hu/konyv/howard_philips_lovecraft.necronomicon--1.html" target="_blank">Vedd
                                                    meg a kiadótól! <br><br><br>
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="necronomicon" name="necronomicon" ' . isChecked('Necronomicon', $bookmarks) . '>
                                                <label for="necronomicon">Könyvjelzőzöm!</label>';
                                                }
                                                ?>

                                            </div>

                                        </td>
                                        <td class="masodik-cella">
                                            <img src="../IMG/necronomicon.jpg" alt="Necronomicon" loading="lazy" width="264" height="400">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Onnan túlról">Onnan túlról</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">
                                            <ul>
                                                <li>Első kiadás éve: 2019</li>
                                            </ul>
                                            <p>
                                                A Helikon kiadó jóvoltából Lovecraft néhány novelláját bemutató kettő
                                                zsebköny közül az első. Tizenegy novellányi borzongást tartalmaz 218
                                                oldalon. Az
                                                író munkásságával ismerkedőknek kitűnő választás.

                                            </p>
                                            <p><a href="https://www.libri.hu/konyv/howard_philips_lovecraft.onnan-tulrol.html" target="_blank">Vedd
                                                    meg a kiadótól!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="onnanTulrol" name="onnanTulrol" ' . isChecked('Onnan túlról', $bookmarks) . '>
                                                <label for="onnanTulrol">Könyvjelzőzöm!</label>';
                                                }
                                                ?>

                                            </div>

                                        </td>
                                        <td class="masodik-cella">
                                            <img src="../IMG/onnanTulrol.jpg" alt="Onnan túlról" loading="lazy" width="218" height="357">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Árnyék Innsmouth fölött">Árnyék Innsmouth fölött</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">
                                            <ul>
                                                <li>Első kiadás éve: 2022</li>
                                            </ul>
                                            <p>
                                                A Helikon kiadó jóvoltából Lovecraft néhány novelláját bemutató kettő
                                                zsebköny közül az második. Három hosszabb novellát tartalmaz. Az
                                                író munkásságával ismerkedőknek kitűnő választás.

                                            </p>
                                            <p><a href="https://www.libri.hu/konyv/howard_philips_lovecraft.arnyek-innsmouth-folott.html" target="_blank">Vedd
                                                    meg a kiadótól!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="arnyekInnsmouthFolott" name="arnyekInnsmouthFolott" ' . isChecked('Árnyék Innsmouth fölött', $bookmarks) . '>
                                                <label for="arnyekInnsmouthFolott">Könyvjelzőzöm!</label>';
                                                }
                                                ?>

                                            </div>

                                        </td>
                                        <td class="masodik-cella">
                                            <img src="../IMG/ArnyekInnsmouthFolott.jpg" alt="Onnan túlról" loading="lazy" width="211" height="350">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>
                </article>
                <article>
                    <h2>Novellák</h2>
                    <details>
                        <summary id="Az álom fala mögött">Az álom fala mögött</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1919</li>
                                            </ul>
                                            <p>
                                                Egy rejtélyes és sötét történetet mesél el Randolph Carter kalandjairól,
                                                aki
                                                különös álmokba merülve felfedezi a titokzatos és régi világokat,
                                                melyeket
                                                álmában lát. Carter útjának középpontjában a városok, entitások és
                                                kultúrák
                                                állnak, amelyek csak a tudatalatti mélyén léteznek, az álmok
                                                birodalmában. A
                                                történet során Carter különös lényekkel találkozik és rejtélyes helyekre
                                                utazik álmaiban, ahol az álom és valóság határai elmosódnak.
                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=8" target="_blank">Elolvasom!
                                                </a>
                                            </p>
                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="alomFalaMogott" name="alomFalaMogott" ' . isChecked('Az álom fala mögött', $bookmarks) . '>
                                                <label for="alomFalaMogott">Könyvjelzőzöm!</label>';
                                                }
                                                ?>

                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Rémület Dunwichben">Rémület Dunwichben</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1928</li>
                                            </ul>
                                            <p>
                                                Egy kísérteties és sötét történet a kis Dunwich nevű faluról,
                                                amelyet furcsa és elzárkózott lakói és sötét titkok jellemeznek. A
                                                történet
                                                középpontjában Wilbur Whateley, egy rejtélyes és rettegett család sarja
                                                áll.
                                                Whateley nagyapa megidéz egy láthatatlan szörnyet, melyet a Miskatonic
                                                Egyetem tanárainak egy csoportjának kell megállítania, különben az
                                                elpusztítja egész New Englandet.

                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=29" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="remuletDunwichben" name="remuletDunwichben" ' . isChecked('Rémület Dunwichben', $bookmarks) . '>
                                                <label for="remuletDunwichben">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Az ünnep">Az ünnep</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1923</li>
                                            </ul>
                                            <p>
                                                Egy fiatalember visszatér ősei földjére, a régies és elhagyatott
                                                Kingsport városába. A városban éppen a hagyományos "Fesztivált/Ünnepet"
                                                tartják,
                                                melynek során titokzatos és sötét szertartások zajlanak. <br>Lovecraft
                                                egyik
                                                erősebb prózaverse, amely leginkább Kingsport városának komor és
                                                kísérteties
                                                leírása miatt csodálatra méltó.
                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=34" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="unnep" name="unnep" ' . isChecked('Az ünnep', $bookmarks) . '>
                                                <label for="unnep">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="A ház, melyet mindenki elkerül">A ház, melyet mindenki elkerül</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1927</li>
                                            </ul>
                                            <p>
                                                Lovecraft belekóstol a kísértetház műfajba. Egy fiatalember és tudós
                                                nagybátyja egy elhagyatott ház alatt különös, izzó gombák után kutat. Az
                                                író
                                                történetei közül azon
                                                kevés esetek egyike, amikor a főszereplőknek valóban van esélyük a
                                                rejtélyes
                                                szörnyűségekkel szemben, amelyekkel szembesülnek.

                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=92" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="haz" name="haz" ' . isChecked('A ház, melyet mindenki elkerül', $bookmarks) . '>
                                                <label for="haz">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Árnyék az időn túlról">Árnyék az időn túlról</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1934 - '35</li>
                                            </ul>
                                            <p>
                                                A történet idő- és tér utazást ír le tudatátvitel útján. Az alaptétel
                                                az,
                                                hogy egy adott helyen és időben lévő személy testet cserélhet valakivel,
                                                aki
                                                máshol vagy máskor van.


                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=90" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="arnyek" name="arnyek" ' . isChecked('Árnyék az időn túlról', $bookmarks) . '>
                                                <label for="arnyek">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Hideg levegő">Hideg levegő</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1926</li>
                                            </ul>
                                            <p>
                                                1923 nyara. Hőség. A halott testeket fagyasztott állapotban kell
                                                tartani,
                                                mert így lassan bomlanak, valamint a szomszédok sem gyanakodnak a
                                                szagokra...
                                                egy ideig. Amikor az alsó szomszéd a bérházban a plafonon különös vegyi
                                                anyag szivárgására figyel fel, hamarosan egy mesteri, de őrült elmével
                                                kell,
                                                hogy találkozzon Dr. Muñoz személyében...



                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=17" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="hidegLevego" name="hidegLevego" ' . isChecked('Hideg levegő', $bookmarks) . '>
                                                <label for="hidegLevego">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Cthulhu hívása">Cthulhu hívása</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1926</li>
                                            </ul>
                                            <p>
                                                Thurston, a fiatal kutató egyre több tárgyi és írásos bizonyítékát leli
                                                a
                                                hírhedt Cthulhu-kultusz létezésének. A kultisták a Necronomicon szövege
                                                alapján a nagy szörnyisten eljövetelét várják. A történetek a
                                                megtestesült
                                                iszonyatról beszélnek, ami átrepült az űrön és letelepedett a Földön sok
                                                millió évvel ezelőtt.
                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=10" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="cthulhuHivasa" name="cthulhuHivasa" ' . isChecked('Cthulhu hívása', $bookmarks) . '>
                                                <label for="cthulhuHivasa">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Herbert West, az újjáélesztő">Herbert West, az újjáélesztő</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1921 - '22</li>
                                            </ul>
                                            <p>
                                                Herbert West ifjú egyetemi hallgató a Miskatonic Egyetemen,
                                                szabadidejében
                                                hullákat támaszt fel. A narrátor, egy doktor, elmeséli Westtel való
                                                találkozásának és kapcsolatának történetét. Ámulatba ejti az orvostanonc
                                                azon elmélete, miszerint a halottakat újra lehet éleszteni, hiszen
                                                testük
                                                csupán egy organikus gép, amelyet megfelelő módosításokkal "meg lehet
                                                javítani".

                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=43" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="herbertWest" name="herbertWest" ' . isChecked('Herbert West, az újjáélesztő', $bookmarks) . '>
                                                <label for="herbertWest">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Patkányok a falban">Patkányok a falban</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1923</li>
                                            </ul>
                                            <p>
                                                A De la Poer família leszármazottja visszatér ősei birtokára, az angliai
                                                Exham Prioriba, hogy kései éveit az öreg ház falai közt töltse el.
                                                Visszaveszi ősi nevét, a de la Poer-t, noha ez a név a környéken még
                                                mindig
                                                viszolygást kelt, hiszen az ősök állítólag kapcsolatot ápoltak
                                                boszorkánysággal, fekete mágiával. Az ősi kúriát épp renoválják, amikor
                                                az
                                                örökös macskája a falak mögött mozgásra, motozásra lesz figyelmes.
                                                Delapoer
                                                felfedezi, hogy a patkányok a pince felől érkeznek, ezért elhatározza,
                                                hogy
                                                felderíti a rejtélyt.

                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=86" target="_blank">Elolvasom!
                                                </a>
                                            </p>

                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="patkanyok" name="patkanyok" ' . isChecked('Patkányok a falban', $bookmarks) . '>
                                                <label for="patkanyok">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="A dolog a küszöbön">A dolog a küszöbön</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1933</li>
                                            </ul>
                                            <p>
                                                Upton elmeséli Derbyvel való egész életen át tartó barátságát, amely
                                                akkor
                                                fordult rosszra, amikor Derby feleségül vett egy hátborzongató, Asenath
                                                Waite nevű fiatal innsmouthi nőt. Asenath apja, Ephraim tiltott
                                                varázslással
                                                foglalkozott, és úgy tűnt, Asenath az apja nyomdokaiba lépett, és
                                                titokzatos
                                                okkult kísérleteket végzett, aminek hatására Derby egyre jobban
                                                kifordult
                                                magából...

                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=103" target="_blank">Elolvasom!
                                                </a>
                                            </p>
                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="dologKuszobon" name="dologKuszobon" ' . isChecked('A dolog a küszöbön', $bookmarks) . '>
                                                <label for="dologKuszobon">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Randolph Carter vallomása">Randolph Carter vallomása</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1919</li>
                                            </ul>
                                            <p>
                                                Sötét helyeken, ősrégi temetőkben nemcsak halottak fekszenek a sírok
                                                alatt.
                                                Randolph Carter erről egy borzasztó éjszakán szerez tudomást.
                                                Tanúvallomást
                                                tesz a kórházban barátja, Harley Warren halála ügyében, aki nagy tudósa
                                                volt
                                                a túlvilági és okkult dolgoknak. A két barát felkeresett egy elhagyatott
                                                temetőt, abban is egy nagyon régi sírt.
                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=95" target="_blank">Elolvasom!
                                                </a>
                                            </p>
                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="randolphVallomas" name="randolphVallomas" ' . isChecked('Randolph Carter vallomása', $bookmarks) . '>
                                                <label for="randolphVallomas">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Pickman modellje">Pickman modellje</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1926</li>
                                            </ul>
                                            <p>
                                                Richard Upton Pickman tehetséges festő salemi gyökerekkel. Bostoni
                                                műtermében lenyűgöző festményeket alkot, kivételes fantáziával és
                                                látásmóddal jeleníti meg a legborzalmasabb rémálmokban megjelenő
                                                szörnyalakokat. Barátja, a történet narrátora ugyanakkor kénytelen
                                                megszakítani látogatásait a festőnél az ott tapasztalt hátborzongató
                                                események következtében.

                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=80" target="_blank">Elolvasom!
                                                </a>
                                            </p>
                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="pickman" name="pickman" ' . isChecked('Pickman modellje', $bookmarks) . '>
                                                <label for="pickman">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Szín az űrből">Szín az űrből</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1927</li>
                                            </ul>
                                            <p>
                                                Egy túlélő beszámolója az Arkham-közeli halál földjéről, ahol semmi sem
                                                nő
                                                már. Évekkel ezelőtt Nahum Gardner furcsa meteoritot lelt a birtokán. A
                                                színes matéria különös fizikai és kémiai tulajdonságokkal bírt, a
                                                meteorit
                                                végül a föld alá süllyedt, és ezután kezdődtek a furcsábbnál furcsább
                                                események…


                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=16" target="_blank">Elolvasom!
                                                </a>
                                            </p>
                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="szinAzUrbol" name="szinAzUrbol" ' . isChecked('Szín az űrből', $bookmarks) . '>
                                                <label for="szinAzUrbol">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary id="Suttogás a sötétben">Suttogás a sötétben</summary>
                        <div class="osszefoglalo">
                            <div>
                                <table>
                                    <tr>
                                        <td class="elso-cella">

                                            <ul>
                                                <li>Keletkezés éve: 1930</li>
                                            </ul>
                                            <p>
                                                A vermonti hegyekben állítólag különös, nem a Földről származó lények
                                                élnek,
                                                és az 1927-es áradások során számos idegen testet is magával sodort a
                                                víz.
                                                Albert Wilmarth, a Miskatonic Egyetem tanára különös levelet kap az
                                                Ördöghegy közelében élő magányos embertől, Henry Wentworth Akeleytől,
                                                aki a
                                                szkeptikus tanárnak azt bizonygatja, hogy a mendemondák igazak, sőt,
                                                földönkívüli szörnyek titkos szervezetéről rántja le a leplet a fiatal
                                                tudós
                                                előtt.
                                            </p>
                                            <p class="utolso"><a href="https://hplovecraft.hu/index.php?page=library_biblio&id=117" target="_blank">Elolvasom!
                                                </a>
                                            </p>
                                            <div class="konyvjelzoDoboz">
                                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                    echo '<input type="checkbox" id="suttogas" name="suttogas" ' . isChecked('Suttogás a sötétben', $bookmarks) . '>
                                                <label for="suttogas">Könyvjelzőzöm!</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </details>
                </article>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo '<div id="submitContainer"><button type="submit">
                    Könyvjelzők mentése
                </button>
                <p id="bookmarkTxT">A könyvjelzőket megtekintheted a profilodban. Ha szeretnéd törölni a könyvjelzőidet, azt szintén a profilodban teheted meg.</p></div>';
                }
                ?>

            </form>
        </div>
    </main>
    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>
</body>


</html>