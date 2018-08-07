<?php 
class DatabaseFunctions{
    private $surname, $firstName, $lastName, $email, $contact, $password, $id,
            $dob, $joinDate, $role;

    public function __construct(){
        
    }
    public function login($id){
        require('./includes/connect.inc.php');
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['']));
        }
        return $id;
    }
}

?>