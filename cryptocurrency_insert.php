<?php
    include_once "session.php";
    include_once "database.php";

   /* Lokalnim var priredimo vrednosti, ki so bile poslane po metodi POST znotraj  <form action="user_insert.php" method="post"> na strani register.php
       za definirane <input class="form-control" type="text" name="first_name" placeholder="Vnasite ime" required="required"/> */
       $title = $_POST['title'];
       $description = $_POST['description'];
       $current_price = floatval($_POST['current_price']);  // ce je float 0,2323(txt) -> ok; ce je false("shdlas") vrne 0
       $logo = 'logotip';
   
        // ki so Notnull
       if (!empty($title) && !empty($logo))
       {
   
           //Definiramo poizvedbo
           $query = "INSERT INTO cryptocurrencies(title, description, current_price, logo) VALUES(?, ?, ?, ?)";
   
           //Izvrsitvenemu stavku dolocimo da na DB pripravi poizvedbo
           $stmt = $pdo->prepare($query);
           //In jo izvrsi z vrednostmi prejetih z metodo _POST
           $stmt->execute([$title,$description,$current_price,$logo]);
   
           //Po registraciji nadalnjujemo na strani 
           header("Location: cryptocurrencies.php");
           die();
   
       } else {
           //Ce pravila vnosa niso izponjena po response ostanemo na strani register.php
           header("Location: cryptocurrencies_add.php");
           die();
       }
 



?>