<?php 
 if(isset($_POST['id'])){
    if(!empty($_POST['id'])){
        $id = $_POST['id'];
    }
    else{
        $error = "Please enter the employee id";
    }
}
require("./connect.inc.php");
try{
    $query = $pdoConnection->prepare("SELECT EmpId FROM employee WHERE EmpId = :id");
    $query->bindValue(':id', $id);
    $query->execute();
    $count = $query->rowCount();
    if($count == 1){
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $delVal = $row['EmpId'];
            $delete = $pdoConnection->prepare("DELETE * FROM employee WHERE EmpId = :delId");
            $delete->bindParam(':delId',$delVal);
            $count = $delete->rowCount();
            if($count > 0){
                echo "<script type='text/javascript'>
                    The emloyee has been successfully deleted
                </script>";
                exit();
            }else{
                $error = "Could not perform the query";
            }
        }
    
}
else{
    $error = "An employee with that id does not exist";

}
}catch(PDOException $exception){
    echo $exception->getMessage();
}

?>