<?php

include_once "database.php";

$email = $_POST['email'];
$pass = $_POST['pass'];

if(!empty($email) && !empty($pass)) {

    $query = "SELECT * FROM users WHERE email = ? ";
    $stmt  = $pdo->prepare($query);
    $stmt->execute([$email]);

    if($stmt->rowCount() == 1) {
        $user = $stmt->fatch();   //$user['first_name'], $user['id'], $user['pass'],... vsi atributi zapisa
        
        if(password_verify($pass,$user['pass'])) {

            header("Location: index.php");
            die();
        }
    }
}
header("Location: login.php");
die();
?>