<?php
session_start();
$error = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Betöltjük a felhasználók adatait tartalmazó JSON fájlt
    $usersData = file_get_contents("felhasznalok.json");
    $users = json_decode($usersData, true);

    // Ellenőrizzük, hogy a felhasználónév és jelszó megfelelő-e
    $username = $_POST['login-user']; // Felhasználónév
    $password = $_POST['login-psw']; // Jelszó

    // Ellenőrzés, hogy a felhasználó létezik-e és a megfelelő jelszót adta-e meg
    $valid_login = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['jelszo'])) {
            // Sikeres bejelentkezés, beállítjuk a session változókat
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $valid_login = true;
            header('Location: ../index.php');
            exit;
        }
    }

    if (!$valid_login) {
        // Ha egyetlen felhasználó sem felelt meg, beállítjuk a hibaüzenetet
        $error = '<br>Rossz felhasználónév vagy jelszó!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/titlePhoto.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/bejelentkezes.css">
    <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
    <title>Bejelentkezés</title>
    <style>
        .error-message {
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <form action="bejelentkezes.php" method="post">
        <div id="container">
            <h2>Bejelentkezés</h2>
            <hr>
            <div class="input">
                <label for="login-user">Felhsználónév:</label>
                <p><input type="text" name="login-user" id="login-user" autofocus required></p>

                <span class="error-message"><?php echo $error; ?></span><br>
            </div>
            <div class="input">
                <label for="login-psw">Jelszó:</label>
                <p><input type="password" name="login-psw" id="login-psw" required> </p>
            </div>
            <button type="submit">Belépés</button>
            <p id="nincs-profil">Nincsen még fiókod? <a href="regisztracio.php"><i class="fa-regular fa-hand-point-right"></i> Regisztrálj itt!</a></p>
        </div>
    </form>
    <footer>
        <p><a href="../index.php">Főoldal</a> &gt; Bejelentkezés</p>
    </footer>
</body>

</html>