<?php
    //Ustvarimo povezavo na mySQL DB
    include_once "database.php";

    /* Lokalnim var priredimo vrednosti, ki so bile poslane po metodi POST znotraj  <form action="user_insert.php" method="post"> na strani register.php
       za definirane <input class="form-control" type="text" name="first_name" placeholder="Vnasite ime" required="required"/> */
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($pass) && ($pass == $pass2))
    {
        //Geslo registracije zakodiramo po metodi PASSWORD_DEFAULT
        $pass = password_hash($pass,PASSWORD_DEFAULT);

        //Definiramo poizvedbo
        $query = "INSERT INTO users(first_name, last_name, email, pass) VALUES(?, ?, ?, ?)";

        //Izvrsitvenemu stavku dolocimo da na DB pripravi poizvedbo
        $stmt = $pdo->prepare($query);
        //In jo izvrsi z vrednostmi prejetih z metodo _POST
        $stmt->execute([$first_name,$last_name,$email,$pass]);

        //Po registraciji nadalnjujemo na strani lohin.php
        header("Location: login.php");
        die();

    } else {
        //Ce pravila vnosa niso izponjena po response ostanemo na strani register.php
        header("Location: register.php");
        die();
    }
?>