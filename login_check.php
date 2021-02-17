<?php

    include_once "database.php";

    /* Lokalnim var priredimo vrednosti, ki so bile poslane po metodi POST znotraj  <form action="login_check.php" method="post">
       na strani login.php za definirane <input class="form-control" type="email" name="email" placeholder="Vnasite e-pošto" required="required" /> */
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if(!empty($email) && !empty($pass)) {

        //Definiramo poizvedbo
        $query = "SELECT * FROM users WHERE email = ? ";

        //Izvrsitvenemu stavku dolocimo da na DB pripravi poizvedbo
        $stmt  = $pdo->prepare($query);
        //In jo izvrsi z vrednostmi prejetih z metodo _POST
        $stmt->execute([$email]);

        //Ce ima nosilec poizvedbe en Datensatz
        if($stmt->rowCount() == 1) {
            
            //echo "tukaj";
            //Ustvrimo lokalnega $usera in mu dolocimo [vrednosti], ki jih vrne fatch() za poizvedbo
            $user = $stmt->fetch();   //$user['first_name'], $user['id'], $user['pass'],... vsi atributi zapisa
            
            echo "tukaj 1";
            // Ce se geslo po metodi _POST ujema z geslom poizvedbe
            if(password_verify($pass, $user['pass'])) {
                echo "tukaj 2";

                //nadaljujemo na strani index.php
                //echo "geslo je pravilno";
                //header("Location: index.php");
                header("Location: login.php");
                die();
            }
        }
    }
    //drugace se vrnemo na login.php
    //header("Location: login.php");
    echo "tukaj";
    die();

    //$stmt->close();
?>