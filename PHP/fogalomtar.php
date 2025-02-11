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
    <link rel="stylesheet" href="../CSS/fogalomtar.css">
    <link rel="stylesheet" href="../CSS/dropdown.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>

    <title>Fogalomtár</title>
</head>

<body>
    <header>
        <h1>Fogalomtár</h1>
    </header>
    <main>
        <nav class="navbar">
            <ul>
                <li><a href="../index.php">Főoldal</a></li>
                <li><a href="muzeum.php">Múzeum</a></li>
                <li><a href="irattar.php">Irattár</a></li>
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
                Lovecraft világában számos visszatérő szereplő, különös helyszín és kifejezés, valamint érdekes, nem
                evilági tárgy is megfordul. Ezen oldal azt a célt szolgálja, hogy az érdeklődők számára ne maradjon
                homályos folt Lovecraft világát illetően. A lentiekben összeszedett gyűjtemény egyfajta enciklopédiaként
                működik. <br>Jó szórakozást!
            </p>

            <div class="kereso">
                <form>
                    <i class="fa fa-search"></i>
                    <input type="text" name="search" id="searchInput" placeholder="Keresés...">
                </form>
            </div>

            <div class="fogalmak" id="fogalmak">
                <article>
                    <h2>Kultikus helyszínek</h2>
                    <section>
                        <h3 class="fogalom">Arkham:</h3>

                        <p>Arkham egy fiktív lovecrafti város, amely Massachusettsben található. Számos történetben
                            szerepel és a Cthulhu-mítosz írói is szívesen használják történeteik helyszíneként. A város
                            nevével
                            először az 1920-as A kép a házban című novellában találkozunk. Arkham fő újságja az Arkham
                            Advertiser. A 1880-as években az újság címe Arkham Gazette volt.
                        </p>

                        <p>Arkhamet házai és a városhoz kötődő sötét, több évszázados legendák teszik kísértetiessé:
                            például az
                            eltűnt gyermekek (akiket feltehetően meggyilkoltak rituális áldozatként).
                        </p>
                        <p>
                            Arkham pontos helye ismeretlen, de valószínűleg közel esik Innsmouthhoz és Dunwichhez.
                            Azonban
                            az is
                            valószínű, hogy Észak-Boston közelében (Essex megye) található. Arkham és a valós Salem
                            városa
                            közt
                            párhuzam vonható, hiszen az utóbbi településhez is számos mendemonda köthető. Megemlítendő,
                            hogy
                            August Derleth és Donald Wandrei, Lovecraft rajongói könyvkiadó cégük alapításakor Lovecraft
                            iránti
                            tiszteletből adták a vállalkozásnak az Arkham House nevet.
                        </p>
                    </section>
                    <section>
                        <h3 class="fogalom">Miskatonic Egyetem:</h3>
                        <p>A Miskatonic Egyetem Lovecraft fiktív egyeteme, amely az ugyancsak fiktív Arkhamben
                            található.
                            Nevét a Miskatonic-folyóról kapta. Maga az egyetem az 1922-es Herbert West - Reanimatorban
                            jelenik meg először, és az iskola még számos horrortörténet helyszíne lesz. A Dunwich
                            Horrorban
                            az író az egyetemet magas presztízsű, a Harvard színvonalával és népszerűségével vetekedő
                            tanintézményként mutatja be.
                        </p>
                        <p>
                            A Miskatonic Egyetemet a már megszűnt Bradford College-ről mintázta Lovecraft. Az intézmény
                            Haverhillben működött, amely malomiparáról volt híres, emellett élesen eltérő társadalmi
                            osztályú lakosai voltak. Lovecraft egyik barátnője járt ebbe az iskolába, és ki volt téve a
                            különböző közösségek ellentéteinek e kísérteties helyen. Lovecraft történeteiben az egyetem
                            hallgatói mind férfi, akárcsak az észak-keleti egyetemek esetében Lovecraft idejében. Az
                            egyetlen diáklány Asenath Waite (A dolog a küszöbön).
                        </p>
                        <p>

                            Az egyetem híres az okkult könyvgyűjteményéről. Az egyetemi könyvtárban fellelhető egy
                            valódi
                            példány a Necronomiconból. De ugyancsak megtalálható itt az Unaussprechlichen Kulten
                            Friedrich
                            von Junzttól és a töredékes Eibon könyve.
                        </p>
                    </section>

                    <section>
                        <h3 class="fogalom">Arkhami Elmegyógyintézet:</h3>
                        <p>Más néven Arkhami Szanatórium. A mentális betegségben szenvedő páncienseket kezelik itt.
                            Bizonyos
                            források szerint az intézet nem annyira ártatlan, mint ahogy a neve sugallná.</p>
                    </section>

                    <section>
                        <h3 class="fogalom">Arkhami mocsarak:</h3>
                        <p>Ezek a mocsarak gyakran szolgálnak a történetek háttérképéül, olyan helyszínek, ahol az
                            emberek
                            rejtélyes körülmények között eltűnnek.
                        </p>

                        <p>Számos lovecrafti történet csatol a mocsarakhoz őrületet, misztikumot, valamint ismeretlen
                            isteneket imádó szektákat.
                        </p>

                        <p>Az Arkhami mocsaraknak nincs szigorúan meghatározott térképi elhelyezkedése vagy jellemző
                            tulajdonságai, ezáltal Lovecraft hagyományosan homályosan hagyta ezeket a helyszíneket, hogy
                            tovább erősítse a misztikus, megmagyarázhatatlan atmoszférát, ami az olvasók képzeletét
                            serkenti.</p>
                    </section>

                    <section>
                        <h3 class="fogalom">Innsmouth:</h3>
                        <p>Egy öreg, koszos kis halászváros, amit még az arkhami lakosok is elkerülnek. Sötét legendák
                            keringenek a város lakóiról, belterjességükről, és különös, már-már halszerű kinézetükről.
                            Az
                            Innsmouth-i lakosság különösnek és zárkózottnak bizonyul, nem tűrik meg az idegeneket. A
                            helyi
                            lakosok között állítólag számos titokzatos kultusz működik, melyek a tengeri isteneket vagy
                            más
                            ősi lényeket tisztelnek és imádnak.
                        </p>
                        <p>
                            Az Innsmouth-i városkép jellegzetessége a sötét, pusztuló és kihalt megjelenés. A város
                            gazdaságát hajdanán a halászat és a tengeri kereskedelem adta, de ezek a tevékenységek
                            hanyatlásnak indultak, és a város egyre inkább elvesztette gazdasági és társadalmi
                            jelentőségét.
                        </p>
                    </section>

                    <section>
                        <h3 class="fogalom">Kingsport:</h3>
                        <p>Kingsport a tengerparton, egy festői öbölben található rejtélyes kisváros, amely tele
                            van sötét titkokkal és ősi misztikumokkal. Lovecraft írásaiban Kingsportot gyakran olyan
                            helyként jeleníti meg, amely tele van ősi kultúrák nyomával és a szellemi örökségüket őrző
                            lakóival.</p>
                        <p>
                            A városban találhatóak olyan helyszínek, mint a világhírű Kingsport Művészeti és Tudományos
                            Társaság, ahol misztikus szertartásokat és rejtélyes összejöveteleket tartanak, valamint a
                            High
                            Street, amelynek egyes részei ősi kúriák és viktoriánus stílusú épületek sora.
                        </p>
                    </section>
                    <section>
                        <h3 class="fogalom">Dunwich:</h3>
                        <p>Az ország egyik legrégebbi települése. Massachusetts államban található, hegyekkel tűzdelt
                            régióban. A közeli hegyekben ismeretlen eredetű kőoszlopok emelkednek a magasba. A kisváros
                            legfiatalabb épülete egy malom a közeli vízesésnél, ami -csakúgy, mint maga Dunwich- már rég
                            romokban áll.</p>
                    </section>

                    <section>
                        <h3 class="fogalom">Álomvilág:</h3>
                        <p>Egy alternatív valóság amibe álmokon keresztül lehet eljutni. Neve ellenére egy valóságos
                            hely, ami azáltal is bizonyítható, hogy olykor, kapuk segítségével is sikerült belépni ebbe
                            a
                            világba. Több régióra osztható, területét hegységek, mezők, tengerek, folyók és városok
                            színesítik. Részletes információt <a href="https://kadath.fandom.com/wiki/Dreamlands" target="_blank">itt</a>
                            találsz.
                        </p>
                    </section>

                    <section>
                        <h3 class="fogalom">Celephaïs:</h3>
                        <p> Álomvilág leglenyűgözőbb városa. A várost a Celephaïs nevű novellában, a főszereplő, Kuranes
                            álmain keresztül ismerjük meg. A történet szerint Kuranes emlékszik egykor létezett
                            városára,
                            Celephaïsra, amely egy
                            lenyűgöző és csodálatos hely volt. A város tele volt csodálatos palotákkal és kertekkel, és
                            minden, ami Kuranes számára fontos volt az életben, ott megtalálható volt.
                        </p>
                        <p>
                            Celephaïs egyfajta szimbólum is lehet Lovecraft munkáiban, ahol a valóság és az álom, az
                            ismert
                            és az ismeretlen határai elmosódnak. Celephaïs-t a Cthulhu-mitológia egyik fontos
                            részének tekintik, amely hozzájárul azon lények és helyszínek összetett hálójához, amelyek a
                            Lovecraft-i univerzumban találhatók.
                        </p>
                    </section>
                    <section>
                        <h3 class="fogalom">Yuggoth:</h3>
                        <p>Egy, a naprendszerünk szélén található bolygó. Az ősi yuggothi fajnak a szülővilága volt,
                            annak
                            kihalásáig, azóta a Mi-gok előőrse, kolóniával együtt. Még fellelhetők az Ősi Faj
                            maradványai a
                            bolygón: Égbe meredő zöld piramisok, egy feneketlen verem. A Yuggoth egy sötét,
                            barátságtalan
                            világ. Felszínét erős szelek tépik, míg forró, olajos anyagból álló "tengerei" és "folyói"
                            lomhán áradnak a bazalt hidak alatt. Mind szárazföldből, úgy a vizekből is fekete tornyok
                            magasodnak a légkör felé.</p>
                    </section>
                    <section>
                        <h3 class="fogalom">R'lyeh:</h3>
                        <p>Egy ősi, eonokkal ezelőtt épített város, valahol a Csendes-óceán mélyén, melynek hatalmas,
                            nem
                            Euklediszi-geometriát követő falai között alussza örök álmát az egyik Nagy Öreg, Chtulhu. A
                            város
                            valamikor a földtörténeti ókorban épülhetett, szárazföldön. Elsüllyedése egy korai
                            kataklizmával
                            azonosítható.</p>
                    </section>
                </article>
                <article>
                    <h2>Karakterek</h2>

                    <section>
                        <h3 class="fogalom">Randolph Carter:</h3>
                        <p>Nem hivatalosan Lovecraft alter-egoja, számos tulajdonságában hasonlít az íróra. Maga Carter
                            is egy kevéssé becsült író saját kortársai között. Melankólikus, álmodozó, érzékeny alak,
                            nagy
                            érzelmi stressz hatására képes elájulni. Mindezek ellenére, képes bátor maradni, és elég
                            akaraterőt összegyűjteni, hogy bármilyen szörnyűséggel szembenézzen, ha szükséges.</p>
                    </section>
                    <section>
                        <h3 class="fogalom">Charles Dexter Ward:</h3>
                        <p>1902-ben született, egy kiemelkedő Rhode Island-i család sarjaként. Huszonhat évesen rájön,
                            hogy
                            szépapjának apja, Joseph Curwen, neves varázsló volt, ráadásul pontosan ugyan úgy nézett ki,
                            mint ő maga. Ezen ismeretek birtokában 1928-ban megpróbálta feltámasztani Curwent.</p>
                    </section>
                    <section>
                        <h3 class="fogalom">Herbert West:</h3>
                        <p>Egy fiatal, különösen intelligens tudós, és egy könyörtelen ember. Kifejleszett egy szérumot,
                            mellyel megelevenítheti az élettelen testeket. Célja a halottak feltámasztása volt, ám nem
                            minden úgy sikerült, ahogy azt várta.</p>
                    </section>
                    <section>
                        <h3 class="fogalom">Wilbur Whateley:</h3>
                        <p>1913. február 5-én, Dunwich csendes városában Lavinia Wheatley életet adott fiának Wilbur
                            Whateley-nek. A lakosok születésének dátumát a hegyek dübörgése és a kutyák szüntelen
                            ugatása
                            előtti éjszakára jegyzik. Egész élete során a kutyák különös, ösztönös utálattal viseltettek
                            utána. Emberhez képest természetellenesen gyorsan fejlődött: 7 hónaposan egyedül tudott
                            járni,
                            11 hónaposan már beszélt. Négy és fél évesen tizenötnek nézett ki, és szakállt kezdett
                            növeszteni. Külsejében mindig is volt valami, amit leginkább az "állatias" jelzővel lehetett
                            körül írni. Fiatal korában a lehető legtöbbet takaró ruhákat kezdett el viselni. Szaga is
                            állatias, hangjában nem emberi ritmusok és hanglejtések hallatszanak. Tizenöt évesen közel
                            három
                            méteres magassággal rendelkezett, és semmi jelét nem adta a megállásnak. Arra született,
                            hogy
                            kinyisson egy kaput, mely botzalmakat hoz a világra. </p>
                    </section>
                </article>

                <article>
                    <h2>Entitások</h2>
                    <section>
                        <h3 class="fogalom">Nagy Öregek:</h3>
                        <p> Kolosszális, groteszk és gonosz élőlények, melyek a Föld különböző helyein aludják
                            álmukat. Ha felébresztik őket,
                            halált és pusztulást hoznak világunkra, és maguknak követelik a bolygót, mint jogos
                            uralkodók.
                            Kinézetük oly felfoghatatlanul bizarr a földiek számára, hogy mindenkiben őrületet keltenek,
                            akik vannak olyan szerencsétlenek, hogy megpillanthassanak egy Nagy Öreget. Semmilyen
                            érdeklősést nem mutatnak az emberi faj iránt, olyanok vagyunk nekik, mint a hangyák.
                        </p>
                    </section>

                    <section>
                        <h3 class="fogalom">Külső Istenek:</h3>
                        <p> A számunkra ismert világon túl lakozó isteni erővel bíró entitások. Hatalmukat a mélyűrből,
                            vagy más dimenzikból
                            gyakorolják. Erejük sokkalta nagyobb, mint a Nagy
                            Öregeknek, azonban ez a két kategória nincsen pontosan elválasztva a lovecrafti
                            mitológiában.
                        </p>
                    </section>
                    <section>
                        <h3 class="fogalom">Chtulhu:</h3>
                        <p> Kozmikus entitás, a Nagy Öregek egyike.
                            Hatalmas erejű,
                            polip alakú lényként ábrázolják, aki halálhoz hasonló szendergésben fekszik elsüllyedt
                            R'lyeh városában, a Csendes-óceán alatt. A Chtulhu-mítosz legfontosabb eleme.
                            Pontos leírás nem létezik róla, leginkább az őt ábrázoló szobrokat szokták körül írni. Ebből
                            feltételehzető, hogy polip szerű fejjel, valamint szárnyakkal rendelkezik.
                            Képes kommunikálni, üzenetet küldeni -álmok formájában az érzékenyebb, nyitottabb
                            szellemű/gondolkodású embereknek.

                        </p>
                        <p>Követőinek száma ismeretlen, annyit tudni, hogy a Föld minden pontján kultuszok zengik a
                            nevét.
                            Az őt imádó szektákat leginkább a civilizációtól elzárkózott közösségek, törzsek adják. Arra
                            készülnek, hogy amikor eljön az idő, felébresszék a nagy Chtulhut.
                            Lokációtól függetlenül a követők ugyan azt a mondatot suttogják: "Ph'nglui mglw'nafh Cthulhu
                            R'lyeh wgah'nagl fhtagn.", "R'lyeh házában álmodva vár ránk a halott Cthulhu.”
                        </p>
                    </section>

                    <section>
                        <h3 class="fogalom">Nyarlathotep:</h3>
                        <p>A Külső Istenek hírvivője. Képes bármilyen alakot felölteni. Ismert megjelenési formái közé
                            tartozik a fáraószerű emberi alak; a csápos szörnyeteg, arca helyén egy vérvörös
                            nyúlvánnyal; a
                            vörös szemű, fekete, szárnyas lény; és talán az a „fekete ember” („man in black”) is ő, aki
                            a
                            boszorkányszombatokon elnökölni szokott. Nem gyilkos természetű, mint a legtöbb lovecrafti
                            isten, jobban szereti áldozatait az őrületbe kergetni. Ennek ellenére több helyen is
                            történik
                            utalás arra, hogy egyszer majd ő fogja kiirtani az emberiséget, illetve elpusztítani a
                            Földet.
                            (Bár lehet, hogy ezt is a maga módján teszi, kollektív őrületet bocsátva az emberiségre.)
                            Sokan Kúszó Káoszként emlegetik.
                        </p>
                    </section>

                    <section>
                        <h3 class="fogalom">Azathoth:</h3>
                        <p>A lovecrafti mitológia egyik főistene, a külső istenek ura. Életkora megegyezik az
                            univerzuméval
                            (vagy meghaladja azt). A normális téridőn túl, a mindenség középpontjában él.
                            Alaktalan "teste" pihenés nélkül lüktet, vonaglik valamiféle monoton "fuvolaszóra".
                            Körülötte
                            alacsonyabb rangú szolgáló istenek táncolnak ugyanerre a hangra. Azatoth egy vak és értelem
                            nélküli lény, a teljességgel felfoghatatlan, leírhatatlan, meghatározhatatlan őskáosz
                            reprezentánsa. Hívei nincsenek, hacsak valami őrült nem próbál meg kapcsolatba lépni egy
                            olyan
                            létezővel, akiben a szikrája sincs meg bármiféle tudatosságnak. Bár egyesek szerint ha
                            valakinek
                            mégis sikerülne valamiféle kontaktust létrehoznia vele, az bepillantást nyerhetne az
                            univerzum
                            természetének, eredetének és értelmének legvégsőbb, legrejtettebb titkaiba, amelyeket ép
                            ésszel
                            lehetetlen felfogni.
                        </p>
                    </section>
                </article>

                <article>
                    <h2>Tárgyak</h2>
                    <section>
                        <h3 class="fogalom">Necronomicon:</h3>
                        <p>A Necronomicon, más néven a Halottak Könyve, vagy arab címmén, a Kitab al-Azif, egy fiktív
                            varázskönyv, amely többször megjelenik Lovecraft történeteiben. Először az író 1924-es "A
                            kutya"
                            című rövid történetében szerepelt, bár a feltételezett szerzője, az "Őrült Arab" Abdul
                            Alhazred,
                            már egy évvel korábban megjelent Lovecraft "A névtelen város" című művében. A munka többek
                            között tartalmazza a Nagy Öregeknek nevezett lények leírását, történetüket és a
                            megidézésükhöz
                            szükséges eszközöket.
                            A könyvnek létezik valós változata is.
                        </p>
                    </section>
                </article>
            </div>
        </div>

    </main>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

    <script>
        // Először kiválasztjuk a keresősáv input elemét
        const searchInput = document.getElementById("searchInput");

        // Majd figyeljük az input eseményét, amikor változik
        searchInput.addEventListener("input", function() {
            // Kiválasztjuk az összes section elemet
            const sections = document.querySelectorAll("section");

            // Az input értékét kisbetűssé alakítjuk, hogy ne legyen érzékeny a kis- és nagybetűkre
            const inputValue = searchInput.value.toLowerCase();

            // Végigmegyünk minden section elemen
            sections.forEach(function(section) {
                // Kiválasztjuk az adott sectionhoz tartozó címsorokat (h2 és h3 elemek)
                const headings = section.querySelectorAll("h2, h3");

                // Alapértelmezetten elrejtjük a sectiont
                let showSection = false;

                // Végigmegyünk minden címsoron (h2 vagy h3 elem) az adott sectionban
                headings.forEach(function(heading) {
                    // A címsor szövegét kisbetűssé alakítjuk
                    const headingText = heading.textContent.toLowerCase();

                    // Ha az input értéke megtalálható a címsor szövegében
                    if (headingText.includes(inputValue)) {
                        // Megjelenítjük az adott sectiont
                        showSection = true;
                    }
                });

                // Ha az adott sectionnak van olyan címsora, amely tartalmazza az input értékét, megjelenítjük azt
                if (showSection) {
                    section.style.display = "block";
                } else {
                    // Különben elrejtjük
                    section.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>