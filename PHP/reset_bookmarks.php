<?php
session_start();

$json_data = file_get_contents("felhasznalok.json");
$users = json_decode($json_data, true);

foreach ($users as &$user) {
    if ($user['username'] === $_SESSION['username']) {
        $user['bookmarks'] = [];
        break;
    }
}

file_put_contents('felhasznalok.json', json_encode($users));

header("Location: profil.php");
exit();
