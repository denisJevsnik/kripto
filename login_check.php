<?php
    session_start();
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
            
            //Ustvrimo lokalnega $usera in mu dolocimo [vrednosti], ki jih vrne fatch() za poizvedbo
            $user = $stmt->fetch();   //$user['first_name'], $user['id'], $user['pass'],... vsi atributi zapisa
            
            // Ce se geslo po metodi _POST ujema z geslom poizvedbe
            if(password_verify($pass, $user['pass'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['admin'] = $user['admin'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['lastt_name'] = $user['last_name'];


                //nadaljujemo na strani index.php
                header("Location: index.php");
                die();
            }
        }
    }
    //drugace se vrnemo na login.php
    header("Location: login.php");
    die();
?>