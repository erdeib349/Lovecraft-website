<?php
// Session kezdése vagy folytatása
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Ha nincs bejelentkezve, átirányítjuk a felhasználót a bejelentkezési oldalra
    header('Location: /PHP/bejelentkezes.php');
    exit;
}

// Betöltjük a felhasználók adatait tartalmazó JSON fájlt
$json_file = 'felhasznalok.json';
$users = json_decode(file_get_contents($json_file), true);

// Keresés a felhasználó email címe alapján
$index = null;
foreach ($users as $key => $user) {
    if ($user['username'] === $_SESSION['username']) {
        $index = $key;
        break;
    }
}

// Ha megtaláltuk a felhasználót, töröljük a JSON tömbből
if ($index !== null) {
    unset($users[$index]);
    array_values($users); //újra indexelés
    file_put_contents($json_file, json_encode(array_values($users)));
}

// Az összes session változó törlése
session_unset();

// Session lezárása
session_destroy();

// Felhasználó átirányítása az index.php oldalra
header("Location: ../index.php");
exit(); // Fontos: azonnal le kell állítani a script futását az átirányítás után
