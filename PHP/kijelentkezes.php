<?php
// Session kezdése vagy folytatása
session_start();

// Az összes session változó törlése
session_unset();

// Session lezárása
session_destroy();

header("Location: ../index.php");

// Felhasználó átirányítása a bejelentkezési oldalra vagy más céloldalra
exit(); // Fontos: azonnal le kell állítani a script futását az átirányítás után
