    <?php
    include_once "session.php";
    adminOnly();
    include_once "database.php";

   /* Lokalnim var priredimo vrednosti, ki so bile poslane po metodi POST znotraj  <form action="user_insert.php" method="post"> na strani register.php
       za definirane <input class="form-control" type="text" name="first_name" placeholder="Vnasite ime" required="required"/> */
       $title = $_POST['title'];
       $id = (int) $_POST['id'];
  
        $target_dir = "images/";

        $random = date('YmdHisu'); // 2021023170122
        // url->kazalec na datoteko, name-> ime datoteke
        $target_file = $target_dir . $random . basename($_FILES["url"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
        // preveria ali ima datoteka dejansko velikost
        $check = getimagesize($_FILES["url"]["tmp_name"]);
        if($check !== false) {
          $uploadOk = 1;
        } else {
          $uploadOk = 0;
        }

        // Check file size max 5MB
        if ($_FILES["url"]["size"] > 5000000) {
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
        }

        // ali so podatki ustrezni
       if (($uploadOk == 1))
       {

            if (move_uploaded_file($_FILES["url"]["tmp_name"], $target_file)) {
                // zapise se vse v bazo
                //Definiramo poizvedbo
                $query = "INSERT INTO images(title, url, cryptocurrency_id, user_id) VALUES(?, ?, ?, ?)";
   
                //Izvrsitvenemu stavku dolocimo da na DB pripravi poizvedbo
                $stmt = $pdo->prepare($query);
                //In jo izvrsi z vrednostmi prejetih z metodo _POST
                $stmt->execute([$title, $target_file, $id, $_SESSION['user_id']]);
   
                 //Po registraciji nadalnjujemo na strani 
                 header("Location: cryptocurrency.php?id=$id");
                 die();

             } else {
                //Ce pravila vnosa niso izponjena po response ostanemo na strani register.php
                 header("Location: cryptocurrency.php?id=$id");
                die();
             }
   
       } else {
           //Ce pravila vnosa niso izponjena po response ostanemo na strani register.php
           header("Location: cryptocurrency.php?id=$id");
           die();
       }
?>