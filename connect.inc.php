<?php
try{
    $pdoConnection = new PDO("mysql:host=localhost;dbname=sci_project","root","");
    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
}catch(PDOException $exception){
    echo $exception->getMessage();
}

?>