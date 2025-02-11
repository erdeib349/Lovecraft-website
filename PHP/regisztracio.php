<?php
$vezNev = isset($_POST["vezNev"]) ? $_POST["vezNev"] : '';
$kerNev = isset($_POST["kerNev"]) ? $_POST["kerNev"] : '';
$email = isset($_POST["email"]) ? $_POST["email"] : '';
$username = isset($_POST["username"]) ? $_POST["username"] : '';
$jelszo = isset($_POST["jelszo"]) ? $_POST["jelszo"] : '';
$pfp = '../uploads/def.png';
$bookmarks = [];
$jelszo_error = '';
$username_error = '';
$email_error = '';
$success_message = '';
$succeful_reg = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["vezNev"]) && isset($_POST["kerNev"]) && isset($_POST["email"]) && isset($_POST["jelszo"]) && isset($_POST["jelszoMegint"]) && isset($_POST["username"])) {

        $felhasznalok = json_decode(file_get_contents('felhasznalok.json'), true);

        if ($felhasznalok === null) {
            $felhasznalok = [];
        }

        $letezo_felhaszNevek = array_column($felhasznalok, 'username');
        $letezo_emailcimek = array_column($felhasznalok, 'email');

        if (in_array($_POST["username"], $letezo_felhaszNevek)) {
            $username_error = "Ez a felhasználónév már foglalt!";
        }

        if (in_array($_POST["email"], $letezo_emailcimek)) {
            $email_error = "Ez az email cím már foglalt!";
        }

        if ($_POST["jelszo"] !== $_POST["jelszoMegint"]) {
            $jelszo_error = "A két jelszó nem egyezik meg!";
        }

        if (empty($jelszo_error) && empty($username_error) && empty($email_error)) {
            $felhasznalo_adatok = array(
                "kerNev" => $_POST['kerNev'],
                "vezNev" => $_POST['vezNev'],
                "email" => $_POST['email'],
                'jelszo' => password_hash($_POST['jelszo'], PASSWORD_DEFAULT),
                "username" => $_POST['username'],
                "profil-kep" => $pfp,
                "bookmarks" => $bookmarks
            );

            $felhasznalok[] = $felhasznalo_adatok;

            file_put_contents('felhasznalok.json', json_encode($felhasznalok));

            $succeful_reg = true;

            $success_message = "Sikeres regisztráció!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Csatlakozz a kultuszhoz, hogy le ne marardj a legújabb érdekességekről!">
    <link rel="icon" href="../IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/regisztráció.css">
    <title><?php echo empty($success_message) ? 'Regisztráció' : $success_message; ?></title>
    <style>
        .error-message {
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        h1 .success-message {
            color: rgb(1, 183, 1);
            text-align: center;
        }

        main {
            display: <?php echo $succeful_reg ? 'none' : 'block'; ?>;
        }
    </style>
    <script>
        function resetForm() {
            document.getElementById("vezNev").value = "";
            document.getElementById("kerNev").value = "";
            document.getElementById("username").value = "";
            document.getElementById("email").value = "";
            document.getElementById("jelszo").value = "";
            document.getElementById("jelszoMegint").value = "";
            document.querySelectorAll('.error-message').forEach(function(element) {
                element.innerHTML = '';
            });
        }
    </script>
</head>

<body>
    <header>
        <h1><?php echo empty($success_message) ? 'Regisztráció' : "<span style='color: rgb(1, 183, 1);'>$success_message</span>"; ?></h1>
    </header>
    <main>

        <form id="regisztracio-form" action="regisztracio.php" method="post">
            <fieldset>
                <legend>Adatok</legend>
                <label for="vezNev">Vezetéknév</label>
                <input type="text" name="vezNev" id="vezNev" value="<?php echo htmlspecialchars($vezNev); ?>" autofocus required>

                <br>

                <label for="kerNev">Keresztnév</label>
                <input type="text" name="kerNev" id="kerNev" value="<?php echo htmlspecialchars($kerNev); ?>" required>
                <br>

                <label for="username">Felhasználónév</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
                <span class="error-message"><?php echo $username_error; ?></span><br>

                <label for="email">Email-cím</label>
                <input type="email" name="email" id="email" placeholder="valaki@gmail.com" value="<?php echo htmlspecialchars($email); ?>" required>
                <span class="error-message"><?php echo $email_error; ?></span><br>

                <label for="jelszo">Jelszó</label>
                <input type="password" name="jelszo" id="jelszo" required value="<?php echo htmlspecialchars($jelszo); ?>">
                <br>

                <label for="jelszoMegint">Jelszó mégegyszer</label>
                <input type="password" name="jelszoMegint" id="jelszoMegint" required>
                <span class="error-message"><?php echo $jelszo_error; ?></span><br>
            </fieldset>

            <button type="submit" id="reg">Regisztrálok</button>
            <span class="figyelmeztetes">*A összes mező kitöltése kötelező*</span>
            <button type="button" id="reset" onclick="resetForm()">Töröl</button>

        </form>


        <p id="miert">
            <span>Miért éri meg regisztrálni?</span>
            <br>
            Ha regisztrálsz, felhasználói profilodba elmentheted könyvjelzőkkel azokat a köteteket és/vagy novellákat, melyeket szeretnél megtekinteni más alkalmakkor is, valamint hozzáférést kapsz a rajongói fórum oldalhoz. <br>
        </p>

    </main>
    <footer>
        <p><a href="../index.php">Főoldal</a> &gt; Regisztráció</p>
    </footer>
    <script>
        function resetForm() {
            document.getElementById("vezNev").value = "";
            document.getElementById("kerNev").value = "";
            document.getElementById("username").value = "";
            document.getElementById("email").value = "";
            document.getElementById("jelszo").value = "";
            document.getElementById("jelszoMegint").value = "";
            document.querySelectorAll('.error-message').forEach(function(element) {
                element.innerHTML = '';
            });
        }
    </script>

</body>

</html>