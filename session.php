<?php
    session_start();

    // do katerih strani imajo neprijavljeni uporabniki dostop
    $allow = ['/crypto/login.php', '/crypto/register.php', '/crypto/index.php', '/crypto/login:check.php'];

    // preverim ali je uporabnik prijavljen, ce ni ga peljem na prijavo
    if(!isset($_SESSION['user_id']) && (!in_array($_SERVER['REQUEST_URI'], $allow))) {

        header('Location: login.php');
        die();
    }


?>