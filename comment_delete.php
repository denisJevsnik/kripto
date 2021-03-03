<?php
    include_once "session.php";
    include_once "database.php";

    $id = (int) $_GET['id'];            //komentar_id
    $user_id = $_SESSION['user_id'];    // trenutni uporabnik

    // z id od komentarja poiscemo cryptocurrency_id, da vemo kam se vrnemo v header()
    $query = "SELECT * FROM comments WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id,]);
    $crypto = $stmt->fetch();
    $crypto_id = $crypto['cryptocurrency_id'];

    // izbrise le ce je trenutno prijavljeni($_SESSION user_id) tudi lastnik
    $query = "DELETE FROM comments WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id, $user_id]);

    // header("Location: cryptocurrency.php?id=$crypto['cryptocurrency_id']#komentarji");
    header("Location: cryptocurrency.php?id=$crypto_id#komentarji");
    die();
?>
