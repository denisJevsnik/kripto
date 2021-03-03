<?php
    include_once "session.php";
    adminOnly();
    include_once "database.php";

   /* Lokalnim var priredimo vrednosti, ki so bile poslane po metodi POST znotraj  <form action="user_insert.php" method="post"> na strani register.php
       za definirane <input class="form-control" type="text" name="first_name" placeholder="Vnasite ime" required="required"/> */
       $id = $_POST['id'];
       
       $title = $_POST['title'];
       $description = $_POST['id']; // katero valuto ureja
       $current_price = floatval($_POST['current_price']);  // ce je float 0,2323(txt) -> ok; ce je false("shdlas") vrne 0
  
        $target_dir = "uploads/";

        $random = date('YmdHisu'); // 2021023170122

        // logo->kazalec na datoteko, name-> ime datoteke
        $target_file = $target_dir . $random . basename($_FILES["logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
        // preveria ali ima datoteka dejansko velikost
        $check = getimagesize($_FILES["logo"]["tmp_name"]);
        if($check !== false) {
          $uploadOk = 1;
        } else {
          $uploadOk = 0;
        }

        // Check file size max 5MB
        if ($_FILES["logo"]["size"] > 5000000) {
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
        }

        // ki so Notnull
       if (!empty($title))
       {

            if($uploadOk == 1) {
                //uporabnik je ob urejanju nalozil nov logo
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                    // zapise se vse v bazo
                    //Definiramo poizvedbo
                    $query = "UPDATE cryptocurrencies SET title = ?, description = ?, current_price = ?, logo = ? WHERE id = ?";
    
                    //Izvrsitvenemu stavku dolocimo da na DB pripravi poizvedbo
                    $stmt = $pdo->prepare($query);
                    //In jo izvrsi z vrednostmi prejetih z metodo _POST
                    $stmt->execute([$title,$description,$current_price,$target_file,$id]);
    
                    //Po registraciji nadalnjujemo na strani 
                    header("Location: cryptocurrency.php?id=".$id);
                    die();

                } else {
                    //Ce pravila vnosa niso izponjena po response ostanemo na strani register.php
                    header("Location: cryptocurrency_edit.php?id=$id");
                    die();
                }
            } else {
                //Uporabnik ni nalozil novega loga

                $query = "UPDATE cryptocurrencies SET title = ?, description = ?, current_price = ? WHERE id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$title,$description,$current_price,$id]);

                header("Location: cryptocurrency.php?id=".$id);
                die();
            }
   
       } else {
           //Ce pravila vnosa niso izponjena po response ostanemo na strani register.php
           header("Location: cryptocurrencies_add.php");
           die();
       }
?>