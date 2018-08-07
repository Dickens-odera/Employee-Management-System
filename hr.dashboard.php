<?php
//php code goes here
session_start();
$error = "";
$sent = 0;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_POST['username'])){
                    $name = $_POST['username'];
                }
                if(isset($_POST['email'])){
                    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                        $email = $_POST['email'];
                    }else{
                        $error = "Invalid email address";
                    }
                }
                if(isset($_POST['contact'])){
                    $contact = $_POST['contact'];
                }
                if(isset($_POST['address'])){
                    $address = $_POST['address'];
                }
                if(isset($_POST['dob'])){
                    $dob = $_POST['dob'];
                }
                if(isset($_POST['password'])){
                    $password = MD5($_POST['password']);
                }
                if(isset($_POST['department'])){
                    $department = $_POST['department'];
                }
                if(isset($_POST['joinDate'])){
                    $joinDate = $_POST['joinDate'];
                }
                if(isset($_POST['pos'])){
                    $pos = $_POST['pos'];
                }
                if(isset($_POST['salary'])){
                    $salary = $_POST['salary'];
                }

        if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['contact']) || empty($_POST['address'])||
        empty($_POST['dob']) || empty($_POST['department']) || empty($_POST['joinDate']) || empty($_POST['pos'])|| empty($_POST['salary'])){
            $error = "Please  check the missing field(s)";
        }

        else{
            require("./connect.inc.php");
            try{
                $stmt = $pdoConnection->prepare("INSERT INTO employee(EmpName, password, EmpContactNo, EmpEmail,
                EmpAddress,EmpDob,EmpDepartment,EmpDateOfJoin,EmpPosition,EmpSalary) VALUES(:name,:pass,:contact,:email,
                :address,:dob,:department,:joinDate,:pos,:salary)");

                $stmt->execute(array(':name'=>$name,':pass'=>$password,':contact'=>$contact,':email'=>$email,':address'=>$address,
            ':dob'=>$dob,':department'=>$department,':joinDate'=>$joinDate,':pos'=>$pos,':salary'=>$salary));

            $count = $stmt->rowCount();
            if($count > 0){
                //header("Location:hr.dashboard.php");
               require('../phpmailer/vendor/autoload.php');
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->SMTPDebug = 0; //0, 1, 2, 3
               $mail->SMTPAuth = true;
               $mail->SMTPSecure= "ssl"; //tls
               $mail->Host = "smtp.gmail.com";
               $mail->Port = 465 ; //or 467, 587, 80//465
               $mail->IsHTML(true);
               $mail->Username = "your email address";
               $mail->Password = "your password";
               $mail->SetFrom("dickenso2015@gmail.com","MMUST EMPLOYEE MANAGEMENT SYSTEM");
               $mail->Subject = "MMUST EMS";
               $mail->Body = "Dear   ".$_POST['username']."  You have been successfuly recruited as part of our team<br></br><a href='https://www.google.com'>Click here for your password</a>";
               //$mail->AddAttachment("Kindly use this password to login to our system ".$_POST['password']);
                $mail->AddAddress($_POST['email'],$_POST['username']);

                if($mail->Send()){
                   header("Location:hr.dashboard.php");
                }else{
                   $error = "Failed to send email";
                }
            }else{
                echo "Could not perform the task";
            }

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" />
    <script type="text/javascript" src="bootstrap/includes/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/src/bootstrap.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="navbar navbar-inverse navbar-static-top navbar-dark bg-dark">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collpse" data-target="#employee-login-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
        <a class="navbar-brand">Welcome <?php echo $_SESSION['username'] ;?></a>
        </div>
        <div class="collapse navbar-collapse" id="employee-login-collapse">
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="#">My Account <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>  View Profile</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-wrench"></span>  Update Profile</a></li>
            <li><a href="./employeeLogout.php"><span class="glyphicon glyphicon-off"></span> Log Off</a></li>
        </ul>
    </li>
    </div>
</div>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                    <div class="tabbable">
            <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Employees</a></li>
            <li><a href="#tab2" data-toggle="tab">Messages</a></li>
            <li><a href="#tab3" data-toggle="tab">Employee Payroll</a></li>
            <li><a href="#tab4" data-toggle="tab">Recruitment</a></li>
            <li><a href="#tab5" data-toggle="tab">Training</a></li>
            <li><a href="#tab6" data-toggle="tab">Promotions</a></li>
            <li><a href="#tab7" data-toggle="tab">Job Applications</a></li>
            <li><a href="#tab8" data-toggle="tab">View Employee Attendance</a></li>



            </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="panel panel-primary">
                    <div class="panel-heading text-center">List Of Employees</div>
                <div class="panel-body">
            <?php
            try{
                require('./connect.inc.php');
                $stmt = $pdoConnection->prepare("SELECT * FROM employee ORDER BY EmpId ASC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if($count > 0){
                    echo "
                    <table class='table responsive'>
                    <tr>
                        <th>EmpId</th>
                        <th>EmpName</th>
                        <th>password</th>
                        <th>EmpContactNo</th>
                        <th>EmpEmail</th>
                        <th>EmpAddress</th>
                        <th>EmpDob</th>
                        <th>EmpDepartment</th>
                        <th>EmpDateOfJoin</th>
                        <th>EmpPosition</th>
                        <th>EmpSalary</th>
                        <th>Action</th>
                    </tr>
                    ";

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo "
                    <td>".$row['EmpId']."</td>
                    <td>".$row['EmpName']."</td>
                    <td>".$row['password']."</td>
                    <td>".$row['EmpContactNo']."</td>
                    <td>".$row['EmpEmail']."</td>
                    <td>".$row['EmpAddress']."</td>
                    <td>".$row['EmpDob']."</td>
                    <td>".$row['EmpDepartment']."</td>
                    <td>".$row['EmpDateOfJoin']."</td>
                    <td>".$row['EmpPosition']."</td>
                    <td>".$row['EmpSalary']."</td>
                    <td><button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteEmployee'>Delete</button></td>

                </tr>";
                    }
                    echo "</table>";
                }else{
                    //do soemthing else
                }
            }catch(PDOException $exception){
                echo $exception->getMessage();
            }

            ?>
    <div class="form-group">
            <button type=" button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#addEmployee">ADD EMPLOYEE</button>
            <!-- Modal -->
<div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ;?>">
        <?php  echo $error ;?>
            <div class="table responsive">
                <tr>
                    <div class="form-group">
                                <label>Emp Name</label>
                                <input type="text" name="username" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Email</label>
                                <input type="email" name="email" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Contact</label>
                                <input type="text" name="contact" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Address</label>
                                <input type="text" name="address" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Date Of Birth</label>
                                <input type="date" name="dob" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Department</label>
                                <input type="text" name="department" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Join Date</label>
                                <input type="date" name="joinDate" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Position</label>
                                <input type="text" name="pos" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Salary</label>
                                <input type="text" name="salary" class="form-control">
                    </div>
                </tr>

                <tr>
                    <div class="form-group">
                                <label>Emp Password</label>
                                <input type="password" name="password" class="form-control">
                    </div>
                </tr>

                <tr>
                <input type="submit" class="btn btn-primary btn-lg" value="Save"/>
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>

                </tr>
            </div>
        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
        <?php
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    if(isset($_POST['id'])){
                        $id = $_POST['id'];
                    }
                    require('./connect.inc.php');
                    try{
                            $query = $pdoConnection->prepare("DELETE  FROM employee WHERE EmpId = :id");
                            //$query->bindParam(':id',$id);
                            $query->execute(array(':id'=>$id));
                            $count = $query->rowCount();
                            if($count > 0){
                                $error = "Employee data deleted successfully";
                                header("Location:hr.dashboard.php");
                            }else{
                                $error = "Failed to delete the specified employee";

                            }
                    }catch(PDOException $exception){
                        echo $exception->getMessage();
                    }
                }

        ?>
<!-- Modal -->
<div class="modal fade" id="deleteEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Delete Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
        <?php echo $error ;?>
                <table class="table responsive">
                    <tr>
                    <td>
            <div class="form-group">
                <label>Employee Id</label>
                <input type="text" name="id" class="form-control"/>
            </div>
            </td>
                    </tr>
                <tr>
                <td>
                <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Close</button>
                <input  type="submit" class="btn btn-danger btn-lg" value="DELETE"/>
                </td>
                </tr>
                </table>
        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
    </div>
                </div><!--end the panel body div-->
            </div><!--end the panel div-->
        </div><!--end the active tab pane-->
        <div class="tab-pane" id="tab2">
                <div class="container-fluid">
                <div class="row">
                            <div class="col-md-3">
                    <div class="well text-center">
                <button type="button" class="btn btn-primary btn-lg">Inbox
            <div class="badge">4</div>
                </button>
                    </div>
                            </div>

                            <div class="col-md-3">
                            <div class="well text-center">
                <button type="button" class="btn btn-success btn-lg">Pending
            <div class="badge">2</div>
                </button>
                    </div>
                            </div>

                            <div class="col-md-3">
                            <div class="well text-center">
                <button type="button" class="btn btn-info btn-lg">Sent Mail
            <div class="badge"><?php echo $sent+=1 ;?></div>
                </button>
                    </div>
                            </div>
                <?php

                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            if(isset($_POST['email'])){
                                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                                    $email = $_POST['email'];
                                }
                            }
                            if(isset($_POST['name'])){
                                $name = $_POST['name'];
                            }
                            if(isset($_POST['subject'])){
                                $subject = $_POST['subject'];
                            }
                            if(isset($_POST['message'])){
                                $message = $_POST['message'];
                            }
                            if(empty($_POST['name']) || empty($_POST['message']) || empty($_POST['message'])){
                                $error = "Please check the missing field(s)";
                            }else{
                                require('./connect.inc.php');
                                try{
                                    $stmt = $pdoConnection->prepare("INSERT INTO messages(EmpEmail, EmpName, message) VALUES (:email,:name,:message)");
                                    $stmt->execute(array(':email'=>$email,':name'=>$name,':message'=>$message));
                                    $count = $stmt->rowCount();
                                    if($count > 0){
                                    require('../phpmailer/vendor/autoload.php');
                                    $mail = new PHPMailer();
                                    $mail->isSMTP();
                                    $mail->SMTPDebug = 0; //0, 1, 2, 3
                                    $mail->SMTPAuth = true;
                                    $mail->SMTPSecure= "ssl"; //tls
                                    $mail->Host = "smtp.gmail.com";
                                    $mail->Port = 465 ; //or 467, 587, 80//465
                                    $mail->IsHTML(true);
                                    $mail->Username = "your email address";
                                    $mail->Password = "the password to your email address";
                                    $mail->SetFrom("dickenso2015@gmail.com","Hr Manager MMUST");
                                    $mail->Subject = "Job Application";
                                    $mail->Body = "Dear   ".$name."  ".$message;
                                    $mail->AddAddress($email,$name);
                                    if($mail->Send()){
                                        $sent ++;

                                        header("Location:hr.dashboard.php");
                                    }else{
                                        $error = "Message not sent";
                                    }
                                    }else{
                                        $error = "Could not perform your operation";
                                    }
                                }catch(PDOException $exception){
                                    echo $exception->getMessage();
                                }
                            }
                        }

                ?>
                            <div class="col-md-3">
                            <div class="well text-center">
                <button type="button"  data-toggle="modal" data-target="#mailmodal" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-pencil pull-left"></span>  Compose</button>
                <div class="modal modal-fade" id="mailmodal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Compose Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="post" name="messageForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                        <?php echo $error ;?>
                        <div class="form-group">
                            <label>Recipient's Email</label>
                            <input type="email" name="email" class="form-control"/>
                        </div>
                    <div class="form-group">
                        <label>Recipient's Name</label>
                        <input type="text" name="name" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                            <input type="text" name="subject" class="form-control"/>
                    </div>
                    <div class="form-group">
                            <label>Message</label>
                            <textarea  name="message" class="form-control">
                            </textarea>
                    </div>
                    <div class="form-group">
                            <input type="submit" class="btn btn-success btn-lg" value="Send"/>
                            <button type="button" class="btn btn-danger btn-lg" id="btnCancel">
                                Cancel
                            </button>

                    </div>
                </form>
      </div>
      <div class="modal-footer">

      </div><!--end the modal footer-->
                        </div>
                    </div>
                </div><!--end the modal div-->
                    </div>
                            </div>
</div>
                </div>
        </div><!--end the second tab pane-->
    <div class="tab-pane" id="tab3">

    </div><!--end the third tab pane-->
            <?php
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['description'])){
                $description = $_POST['description'];
            }
            if(isset($_POST['requirements'])){
                $requirements = $_POST['requirements'];
            }
            if(isset($_POST['datePosted'])){
                $datePosted = $_POST['datePosted'];
            }
            if(isset($_POST['deadline'])){
                $deadline = $_POST['deadline'];
            }
            if(isset($_POST['slots'])){
                $slots = $_POST['slots'];
            }
            if(empty($_POST['description']) || empty($_POST['requirements']) || empty($_POST['datePosted']) || empty($_POST['deadline']) || empty($_POST['slots'])){
                $error = "Please check the missing field(s)";
            }else{
                require("./connect.inc.php");
                try{
                    $stmt = $pdoConnection->prepare("INSERT INTO jobs(description, requirements, datePosted,deadline, slots) VALUES(:description,:requirements,:post,:deadline,:slots)");
                    $stmt->execute(array(':description'=>$description,':requirements'=>$requirements,':post'=>$datePosted,':deadline'=>$deadline,':slots'=>$slots));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        $error = "Job added successfully";
                        header("Location:hr.dashboard.php");
                    }else{
                        $error = "Failed to add job";
                        exit();
                    }
                }catch(PDOException $exception){
                    echo $exception->getMessage();
                }
            }
        }
            ?>
    <div class="tab-pane" id="tab4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-center">Add new job opportunity</div>
                        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ;?>">
                                <table class="table">
                                        <tr>
                                        <th>Description </th>
                                        <th>Requirements </th>
                                        <th>Date Posted</th>
                                        <th>Application Deadline</th>
                                        <th>Number of slots</th>
                                        </tr>
                                <tr>
                        <td>
                <div class="form-group">
<input type="text" name="description" class="form-control">
                </div>
                        </td>
                        <td>
                <div class="form-group">
<input type="text" name="requirements" class="form-control">
                </div>
                        </td>
                        <td>
                <div class="form-group">
<input type="date" name="datePosted" class="form-control">
                </div>
                        </td>
                        <td>
                <div class="form-group">
<input type="date" name="deadline" class="form-control">
                </div>
                        </td>
                        <td>
                <div class="form-group">
<input type="number" name="slots" class="form-control">
                </div>
                        </td>
                                </tr>
                        <tr>
                        <td>
            <input type="submit" class="btn btn-success btn-lg" value="POST"/>
            <button type="button" class="btn btn-danger btn-lg pull-right" id="btnCancel">CANCEL</button>
            </td>
                        </tr>
                                </table><!--end the table div-->
                        </form>
                <?php echo $error ;?>
                    </div><!--end the panel-->
                </div><!--end the col-md-8-div-->
                <div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading text-center">Recent posts</div>
            <div class="panel-body">
                <?php
               require("./connect.inc.php");
               try{
                    $stmt = $pdoConnection->prepare("SELECT description, deadline, datePosted FROM jobs ORDER BY datePosted DESC LIMIT 4");
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if($count > 0){
                        echo "<table class='table responsive'>
                            <tr>
                            <th>Job</th>
                            <th>Date Posted</th>
                            <th>Deadline</th>
                        </tr>";

                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            echo "
                            <tr>
                            <td>".$row['description']."</td>
                            <td>".$row['datePosted']."</td>
                            <td>".$row['deadline']."</td>

                            </tr>
                            ";
                        }
                        echo "</table>";
                    }else{
                        echo "Could not retreive the data";
                    }
               }catch(PDOException $exception){
                   echo $exception->getMessage();
               }


                ?>
            </div>
            </div>
                </div><!--end the col-md-4-div-->
            </div><!--end the row div-->
        </div><!--end the container fluid-->
    </div><!--end the fourth tab pane-->
    <div class="tab-pane" id="tab5">

    </div><!--end the fifth tab pane-->
    <div class="tab-pane" id="tab6">

    </div><!--end the sixth tab pane-->
    <div class="tab-pane" id="tab7">

               <div class="panel panel-primary">
                    <div class="panel-heading text-center">Job Applications</div>
                    <div class="panel-body">
                            <?php
                        require('./connect.inc.php');
                        try{
                            $stmt = $pdoConnection->prepare("SELECT * FROM Applications ORDER BY AppId DESC ");
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            if($count > 0){
                                echo "<table name='table' class='table responsive'>
                                    <tr>
                                <th>AppId</th>
                                <th>Surname</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Resume</th>
                                <th>Job</th>
                                <th>Action</th>
                                <th>Counter Action</th>
                                    </tr>
                                ";

                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    echo "
                                            <tr>
                                          <td>".$row['AppId']."</td>
                                          <td>".$row['Surname']."</td>
                                          <td>".$row['Middle_Name']."</td>
                                          <td>".$row['Last_Name']."</td>
                                          <td>".$row['Email']."</td>
                                          <td>".$row['phone']."</td>
                                          <td>".$row['address']."</td>
                                          <td>".$row['resume']."</td>
                                          <td>".$row['job']."</td>
                                        <td><button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#approveApplication'>Approve</button></td>
                                        <td><button type='button' class='btn btn-danger btn-sm' data-toggle='modal' id='btnCancel' data-target='#DenyApplication'>Deny</button></td>

                                        </tr>
                                    ";
                                }
                                echo "</table>";
                            }else{
                                $error = "Could not retrieve the data";
                            }
                        }catch(PDOException $exception){
                            echo $exception->getMessage();
                        }

                            ?>
                    </div>
                    </div>
                    </div>
                    <div class="panel-footer"></div>
               <div>
    </div><!--end the seventh tab pane-->
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['email'])){
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $mail = $_POST['email'];
            }
        }
        if(isset($_POST['name'])){
            $name = $_POST['name'];
        }
        if(isset($_POST['sub'])){
            $sub = $_POST['sub'];
        }
        if(isset($_POST['message'])){
            $message = $_POST['message'];
        }
        if(empty($_POST['email']) || empty($_POST['sub']) || empty($_POST['message'])){
            $error = "Please check the missing field(s)";
        }else{
            require("../phpmailer/vendor/autoload.php");
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = 0; //0, 1, 2, 3
            $mail->SMTPAuth = true;
            $mail->SMTPSecure= "ssl"; //tls
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465 ; //or 467, 587, 80//465
            $mail->IsHTML(true);
            $mail->Username = "your email address";
            $mail->Password = "the password to your email address";
            $mail->SetFrom("dickenso2015@gmail.com","MMUST EMS");
            $mail->Subject =$sub;
            $mail->Body = "Dear   ".$name.  "  $message";
            //$mail->AddAttachment("Kindly use this password to login to our system ".$_POST['password']);
             $mail->AddAddress($email,$name);
             if($mail->Send()){
                 echo "<script type='text/javascript'>
                        alert('Feedback has been sent succesfully');
                 </script>'";
                 //header("Location:hr.dashboard.php");

             }else{
                 $error = "Feedback not sent";
             }
        }
    }

    ?>
    <!-- =============== JOB ACCEPTANCE ==================================-->
    <div class="modal modal-fade" id="approveApplication">
        <div class="modal-dialog">
                        <div class="modal-content">
                    <div class="modal-header">
                                <div class="modal-title">
                                <h5 class="modal-title" id="exampleModalLabel">Send Feedback</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading text-center">
                                        Application feedback Form
                                        </div>
                                        <div class="panel-body">
                                            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ;?>">
                                            <?php echo $error ;?>
                                            <div class="form-group">
                                                <label>Name of Recipient</label>
                                                <input type="text" name="name" class="form-control"/>
                                            </div>

                                                    <div class="form-group">
                                            <label>Recepient's Email Address</label>
                                            <input type="email" name="email" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                            <label>Subject</label>
                                                            <input type="text" name="sub" class="form-control"/>
                                                    </div>

                                            <div class="form-group">
                                                <label>Message</label>
                                                <input type="text" name="message" class="form-control"/>
                                            </div>
                                        <div class="form-group">
                                                <input type="submit" class="btn btn-success btn-sm" value="SEND"/>
                                                <button type="button" class="btn btn-danger btn-sm pull-right">Cancel</button>

                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                    </div>
                        </div>
        </div>
    </div>
    <!--====================== END JOB ACCEPTANCE===========================-->
    <div class="tab-pane" id="tab8">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">Employee Attendance</div>
                <div class="panel-body">
                    <?php
                  require("./connect.inc.php");
                  try{
                        $stmt = $pdoConnection->prepare("SELECT Attendance.date,Attendance.Attendance_Time,Attendance.Leaving_Time,
                        employee.EmpName,employee.EmpEmail FROM Attendance INNER JOIN employee ON Attendance.EmpId = employee.EmpId");
                        $stmt->execute();
                        $count = $stmt->rowCount();
                        if($count > 0){
                            echo "<table class='table'>
                                    <tr>
                                            <th>NAME</th>
                                            <th>EMAIL</th>
                                            <th>DATE</th>
                                            <th>REPORTING TIME</th>
                                            <th>LEAVING TIME</th>
                                    </tr>
                            ";
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "
                                    <tr>
                                        <td>".$row['EmpName']."</td>
                                        <td>".$row['EmpEmail']."</td>
                                        <td>".$row['date']."</td>
                                        <td>".$row['Attendance_Time']."</td>
                                        <td>".$row['Leaving_Time']."</td>
                                    </tr>

                                ";
                            }
                            echo "</table>";
                        }else{
                            $error = "Could not retreive the requested data";
                        }
                  }catch(PDOException $exception){
                      echo $exception->getMessage();
                  }

                    ?>
                </div>
        </div>
    </div><!--end the seventh tab pane-->
    <div><!--end the tab content div-->
                    </div><!--end the tabbale div-->
            </div><!--end the col-md-12 div-->
        </div>
</div>
</div>
    <div class="container-fluid">
<?php include('footer.inc.php') ;?>
    </div>
    <script type="text/javascript">
    document.getElementById('btnCancel').onclick = function(){
        window.location = "hr.dashboard.php";
    }

    </script>
</body>
</html>
