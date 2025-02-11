<?php
session_start();

// Ellenőrizük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Ha nincs bejelentkezve, átirányítjuk a felhasználót a bejelentkezési oldalra
    header('Location: bejelentkezes.php');
    exit;
}

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
            $bookmarks = $user['bookmarks'];
            break; // Ha megtaláltuk a felhasználót, kilépünk a foreach ciklusból
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/profil.css">
    <link rel="stylesheet" href="../CSS/dropdown.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
    <title>Profil</title>
</head>

<body>
    <header>
        <h1>Profil</h1>
    </header>
    <main>
        <nav class="navbar">
            <ul>
                <li><a href="irattar.php">Irattár</a></li>
                <li><a href="muzeum.php">Múzeum</a></li>
                <li><a href="fogalomtar.php">Fogalomtár</a></li>
                <li><a onclick="toggleMenu()">Szekta</a></li>
            </ul>
            <div id="dropdown">
                <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <div class="user-info">
                            <img id="user-pic" src="<?php echo $user['profil-kep']; ?>" alt="profil kép">
                            <h3 id="username"><?php echo $username; ?></h3>
                        </div>
                        <hr>

                        <a href="forum.php" class="sub-menu-link">
                            <p class="link-items"><i class="fa-solid fa-message fa-xl"></i></p>
                            <p class="dp_text link-items">Fórum</p>
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

        <div id="profile-window">
            <div id="profile-data">
                <div id="data-container">
                    <div class="data">
                        <div id="head">
                            <h2><?php echo $username; ?></h2>
                            <hr>
                        </div>
                        <div id="data">
                            <div class="profile-data-items">
                                <p class="profile-data-name">Vezetéknév: </p>
                                <p class="profile-data-name">Keresztnév: </p>
                                <p class="profile-data-name">E-mail cím: </p>
                                <!-- A további adatokat itt megjelenítheted -->
                            </div>
                            <div class="profile-data-items">
                                <p id="user-sur-name" class="profile-data-value"><?php echo $vezeteknev; ?></p>
                                <p id="user-first-name" class="profile-data-value"><?php echo $keresztnev; ?></p>
                                <p id="user-email-cim" class="profile-data-value"><?php echo $email; ?></p>
                                <!-- A további adatokat itt megjelenítheted -->
                            </div>
                        </div>
                    </div>
                    <div id="profile-pic">
                        <img id="pfp" src="<?php echo $user['profil-kep']; ?>" alt="pfp">
                    </div>
                </div>
                <div id="edit-profile-link">
                    <a href="edit_profil.php">
                        <p id="profil-opt-icon" class="edit-profil-items"><i class="fa-solid fa-gear fa-xl"></i></p>
                        <p id="p-link-text" class="edit-profil-items">Profil szerkesztése</p>
                        <p id="p-link-caret" class="edit-profil-items">></p>
                    </a>
                    <a href="reset_bookmarks.php">
                        <p id="profil-opt-icon" class="edit-profil-items"><i class="fa-solid fa-bookmark fa-xl"></i></p>
                        <p id="p-link-text" class="edit-profil-items">Könyvjelzők törlése</p>
                        <p id="p-link-caret" class="edit-profil-items">></p>
                    </a>
                    <a href="delete_profil.php">
                        <p id="profil-opt-icon" class="edit-profil-items"><i class="fa-solid fa-trash fa-xl"></i></p>
                        <p id="p-link-text" class="edit-profil-items">Profil törlése</p>
                        <p id="p-link-caret" class="edit-profil-items">></p>
                    </a>
                </div>
            </div>
        </div>
        <div id="bookmark-window">
            <div id="bookmark-holder">
                <h2>Könyvjelzők:</h2>
                <hr>
                <ul id="bookmarks">
                    <?php foreach ($bookmarks as $bookmark) : ?>
                        <li class="bookmark-list-element">
                            <p class="bookmark-list-style"><i class="fa-solid fa-book"></i></p>
                            <a href="irattar.php#<?php echo $bookmark; ?>"><?php echo $bookmark; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <p><a href="../index.php">Főoldal</a> &gt; Profil</p>
    </footer>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>
</body>

</html>