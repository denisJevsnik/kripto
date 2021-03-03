<?php
     // dolocimo paramtre povezave
     $host = 'localhost';
     $db   = 'crypto';
     $user = 'crypto';
     $pass = 'Nigesla321#';
     $charset = 'utf8mb4';

     $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
     $options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES   => false,
     ];
     try {
          // ustvarimo objekt povezave
          $pdo = new PDO($dsn, $user, $pass, $options);
     } catch (\PDOException $e) {
          // ce povezava ne uspe za objekt vrnemo sporocilo in kodo pripadajocega $options
          throw new \PDOException($e->getMessage(), (int)$e->getCode());
     }
?>