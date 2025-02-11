<?php
session_start();
$ellenorzes = 'User';

// Ellenőrizd, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Ha nincs bejelentkezve, átirányítjuk a felhasználót a bejelentkezési oldalra
    header('Location: /PHP/bejelentkezes.php');
    exit;
}

// Az aktuális felhasználónév beállítása
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //error_log('POST kérés érkezett');

    // Get the existing users
    $users = json_decode(file_get_contents('felhasznalok.json'), true);


    foreach ($users as &$user) {
        if ($user['username'] === $username) {
            // A felhasználói adatok frissítése
            if (!empty($_POST['veznev'])) {
                $user['vezNev'] = $_POST['veznev'];
            }
            if (!empty($_POST['kernev'])) {
                $user['kerNev'] = $_POST['kernev'];
            }
            if (!empty($_POST['new-username'])) {
                $user['username'] = $_POST['new-username'];
                $_SESSION['username'] = $user['username'];
            }
            if (!empty($_POST['new-mail'])) {
                $user['email'] = $_POST['new-mail'];
            }
            if (!empty($_POST['new-psw'])) {
                // A jelszó hashelése a tárolás előtt
                $user['jelszo'] = password_hash($_POST['new-psw'], PASSWORD_DEFAULT);
            }
            if (isset($_FILES['profil-kep'])) {
                $file_name = $_FILES['profil-kep']['name'];
                $file_tmp = $_FILES['profil-kep']['tmp_name'];
                $file_type = $_FILES['profil-kep']['type'];
                $file_error = $_FILES['profil-kep']['error'];

                if ($file_error === 0) {
                    $upload_dir = '../uploads/';
                    $upload_path = $upload_dir . $file_name;
                    move_uploaded_file($file_tmp, $upload_path);

                    // Felhasználói adatok frissítése a profilkép elérési útvonalával
                    $user['profil-kep'] = $upload_path;
                }
            }
            break;
        }
    }
    file_put_contents('felhasznalok.json', json_encode($users));
    header('Location: profil.php');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/edit_profil.css">
    <link rel="stylesheet" href="../CSS/dropdown.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
    <title>Edit Profil</title>
</head>

<body>
    <header>
        <h1>Profil szerkesztése</h1>
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
            <form action="edit_profil.php" method="post" enctype="multipart/form-data">
                <div id="profile-data">
                    <div id="data">
                        <div class="data">
                            <fieldset>
                                <Legend>Adatok</Legend>
                                <Label for="veznev">Vezetéknév módosítása: </Label>
                                <input type="text" name="veznev" id="veznev">
                                <Label for="kernev">Keresztnév módosítása: </Label>
                                <input type="text" name="kernev" id="kernev">
                                <Label for="new-username">Felhasználónév módosítása: </Label>
                                <input type="text" name="new-username" id="new-username">
                                <Label for="new-mail">E-Mail cím módosítása: </Label>
                                <input type="email" name="new-mail" id="new-mail">
                                <Label for="new-psw">Jelszó módosítása: </Label>
                                <input type="password" name="new-psw" id="new-psw">
                                <Label for="new-psw-ag">Jelszó megerősítése: </Label>
                                <input type="password" name="new-psw-ag" id="new-psw-ag">
                            </fieldset>
                        </div>
                        <div id="profil-kep-container">
                            <img id="profil-kep" src="<?php echo $user['profil-kep']; ?>" alt="pfp">
                            <Label>Profilkép feltöltése: <input type="file" name="profil-kep" id="profil-kep-upldoad"></Label>
                        </div>
                    </div>
                    <button type="submit"> Változtatások mentése</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p><a href="../index.php">Főoldal</a> &gt; <a href="profil.php">Profil</a> &gt; Profil szerkesztése</p>
    </footer>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>
</body>

</html>