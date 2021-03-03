<?php
    session_start();

    // do katerih strani imajo neprijavljeni uporabniki dostop
    $allow = ['/crypto/login.php', '/crypto/register.php', '/crypto/index.php', '/crypto/login:check.php'];

    // preverim ali je uporabnik prijavljen, ce ni ga peljem na prijavo
    if(!isset($_SESSION['user_id']) && (!in_array($_SERVER['REQUEST_URI'], $allow))) {

        header('Location: login.php');
        die();
    }

    function getFullName($user_id) {

        require "database.php";

        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        return $user['first_name'].' '.$user['last_name'];
    }

    // vraca za trenutno prijavljenega
    function admin() {
        return $_SESSION['admin'];
    }

    // ce trenutno prijavljeni ni admin ga preusmeri na index
    function adminOnly() {
        //ce ni nastavljen admin ali ce admin ni enako 1, potem gre na index
        if(!iset($_SESSION['admin']) || ($_SESSION['admin'] != 1)) {
            header("Location: index.php");
            die();
        }
    }

?>