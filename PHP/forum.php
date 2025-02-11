<?php
session_start();
$ellenorzes = 'User';
$bejelentkezes_kijelentkezes_felirat = '';
date_default_timezone_set('Europe/Budapest');

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $json_data = file_get_contents('felhasznalok.json');
    $users = json_decode($json_data, true);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $pfp = $user['profil-kep'];
            }
        }
    }


    $ellenorzes =  $_SESSION['username'];


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
        $message = $_POST['message']; // Üzenet megkapása a POST kéréstől
        if (!empty($message)) {
            $sender = $_SESSION['username'];
            $timestamp = date('Y-m-d H:i');
            $messages = json_decode(file_get_contents('messages.json'), true);
            if ($messages === null) {
                $messages = []; // Üres tömb inicializálása
            }


            $new_message = array(
                'sender' => $sender,
                'text' => $message,
                'timestamp' => $timestamp,
                'pfp' => $pfp
            );

            $messages[] = $new_message;

            file_put_contents('messages.json', json_encode($messages));
        }
    }
} else {
    header('Location: bejelentkezes.php');
}
?>


<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/forum.css">
    <link rel="stylesheet" href="../CSS/dropdown.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
    <title>Fórum</title>
</head>

<body>
    <header>
        <h1>Fórum</h1>
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
                        <div class="user-info">
                            <img id="user-pic" src=<?php echo $user['profil-kep']; ?> alt="felhasználó képe">
                            <h3 id="username"> <?php echo $ellenorzes; ?></h3>
                        </div>
                        <hr>
                        <a href="profil.php" class="sub-menu-link">
                            <p class="link-items"><i class="fa-regular fa-circle-user fa-xl"></i></p>
                            <p class="dp_text link-items">Profil</p>
                            <p class="caret link-items">></p>
                        </a>
                        <a href="kijelentkezes.php" class="sub-menu-link">
                            <p class="link-items"><i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i></p>
                            <p class="dp_text link-items">Kijelentkezés</p>
                            <p class="caret link-items">></p>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <a href="#"><img id="ugras" src="../IMG/logo.jpg" alt="oldal tetejére" title="oldal tetejére" width="92"></a>

        <div class="container">

            <p class="ismerteto">
                Ez a portál mindazon lelkes rajongóknak készült, akik imádják H.P. Lovecraft műveit és az általa
                teremtett világot. Itt lehetőség nyílik arra, hogy közösen felfedezzék és
                megbeszéljék az író irodalmának minden apró részletét, megosszák kedvenc idézeteinket, elmélkedjenek
                az általa alkotott kozmosz rejtelmeiről, és természetesen megvitassák, hogy melyik őrült istenség vagy
                elborzasztó entitás a legfélelmetesebb. Legyen szó Arkhamról, Innsmouth-ról vagy éppen a Miskatonic
                Egyetemről, itt minden Lovecraft-fanatikus megtalálhatja a számításait.
                <br>
                Jó
                szórakozást!
            </p>

            <div id="message-board">
                <div id="messages">
                    <?php
                    // Üzenetek megjelenítése
                    $messages = json_decode(file_get_contents('messages.json'), true);
                    foreach ($messages as $message) {
                        echo '<div class="message"><p class="sender">' . $message['sender'] . '</p><p>' . $message['text'] . '</p><p class="timestamp">' . $message['timestamp'] . '</p></div>';
                    }
                    ?>
                </div>
                <form action="forum.php" method="post">
                    <input type="text" name="message" id="message-input" placeholder="Írj egy üzenetet..." required>
                    <br>
                    <button type="submit">Küldés</button>
                </form>
            </div>

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