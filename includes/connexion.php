<?php

    require('config.php');

    function connect_bd()
    {
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        try{
            $conn = new PDO($dsn,USER,PASSWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){
            printf("Échec de la connexion : %s\n", $e->getMessage());
            exit();
        }
    }


?>