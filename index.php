<?php
$error = "";
session_start();
if(isset($_SESSION['email'])){
    header("Location:./employee.dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en" ng-App="hrm">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee management system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css"/>
    <script type="text/javascript" src="bootstrap/includes/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/src/popover.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel ="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    <script src="main.js"></script>
</head>
<body ng-controller="AppController" bgcolor="#45584">
<nav class="navbar navbar-inverse navbar-static-top navbar-dark bg-dark" id="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="./images/navlogo.jpg" alt="no image"></a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
        <li><a href="#sampledatabase" class="smoothScrollLink">About</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Employee <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!--<li><a href="./employee/register.php">Register</a></li>-->
            <li><a href="./employee/login.php">Login</a></li>
            <li><a href="#jobs" class="smoothScrollLink">View Recruitment Adverts</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" method="post">
        <div class="form-group">
          <input type="text" name="search" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="//dropdown">
          <a href="./admin.login.inc.php" class="//dropdown-toggle" data-toggle="//dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>   Admin <span class="//caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="./admin.login.inc.php">Supervisor</a></li>
            <li><a href="./admin.login.inc.php">Head Of Department</a></li>
            <li><a href="./admin.login.inc.php">Assistant Hr Manager</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="./admin.login.inc.php">Hr Manager</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">
    <div class="container">
        <div class="row">
                <div class="jumbotron text-center" id="jumbotro-header">
                <!-- <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="./images/mail.mp4"></iframe>
                </div> -->
                <h1>EMPLOYEE MANAGEMENT SYSTEM</h1>
                        <small>Keeping track of our employee data</small>
                </div>
        </div>

            <div class="row">
                <div class="col-md-12 text-center">
                  <div class="carousel slide" id="employee-carousel" data-ride="carousel" aria-hidden="true">
                  <ol class="carousel-indicators">
                        <li data-target="#employee-carousel" class="active" data-slide-to="0"></li>
                        <li data-target="#employee-carousel" data-slide-to="1"></li>
                        <li data-target="#employee-carousel" data-slide-to="2"></li>


</ol>
            <div class="carousel-inner">
                <div class="item active">
                  <img src="./images/banner1.jpg" alt="no image" style="width:100%"/>
                <div class="carousel-caption">
                  <p class="text-center carousel-text">Your number 1 employeee database management system</p>
                </div>
                </div>

                <div class="item">
                  <img src="./images/banner3.jpg" alt="no image" style="width:100%"/>
                <div class="carousel-caption">
                  <p class="text-center carousel-text">We care about our employees</p>
                </div>
                </div>

                <div class="item">
                  <img src="./images/hr.jpg" alt="no image" style="width:100%"/>
                  <div class="carousel-caption">
                    <p class="text-center carousel-text">We create a condciuve environment fo our employees</p>
                  </div>
                </div>
              </div><!--end the carousel inner class-->
                  </div><!--end the carousel div-->
                </div>
            
            </div><!--end the row div-->
            <hr>
            <div class="row" id="sampledatabase">
                <div class="col-md-8">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading">
                         Employee Database Sample
                        </div><!--end panel header-->
                <div class="panel-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ;?>" name="sample-form">
                        <table class="table" name="table-sample" cellpadding="5">
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Address</th>
                                    <th>Department</th>
                                </tr>
                            <tr>
                                <td>
                            DICKENS
                                </td>
                            <td>
                            ODERA
                        </td>
                    <td>190-50100 KAKAMEGA</td>
                    <td>COMPUTER SCIENCE</td>
                            </tr>
                    <tr>
                <td>MARY</td>
                <td>JELIMO</td>
                <td>100-40273</td>
                <td>PUBLIC HEALTH</td>
                    </tr>
                <tr>
                <td>MOSES</td>
                <td>KIMANI</td>
                <td>108-27727</td>
                <td>INFORMATION TECHNOLOGY</td>
                </tr>
            <tr>
                    <td>UHURU</td>
                    <td>KENYATTA</td>
                    <td>45-00100</td>
                    <td>STATE HOUSE</td>
            
            </tr>
                        </table>
                    </form>
                </div><!--end the panel body div-->
                    </div><!--end the panel div-->
                </div>
                <div class="col-md-4" id="info-div">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">About Us</div>
                    <div class="panel-body">
                        <p>
                This is a sample employee management system that aims at performing the following tasks
                <ol>
            <li>Easy Maintenance of Employee data</li>
            <li>Create a conducive environment for organization's management</li>
            <li>Offer a plartform for the admins to interruct with the employees online</li>
            <li>Offer a platform for hr managers to advertise recruitment opportunities</li>
                </ol>
                        </p>
                    </div>
                                    </div>
                <div>
        </div><!-- end the row div-->
        </div>
        <div class="row" id="jobs">
                <div class="container">
                        <div class="col-md-12">
                                <div class="panel panel-danger">
                                        <div class="panel-heading text-center">
                                        Job Adverts
                                        </div>
                                    <div class="panel-body">
                              <?php 
                              
                        require('./connect.inc.php');
                        try{
                            $stmt = $pdoConnection->prepare("SELECT * FROM jobs ORDER BY id DESC LIMIT 4");
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            if($count > 0){
                                echo "
                                <table class='table'>
                                    <tr>
                                        <th>Job Description</th>
                                        <th>Requirements</th>
                                        <th>Date Posted</th>
                                        <th>Application Deadline</th>
                                        <th>Slots Available</th>
                                        <th>Action</th>
                                    </tr>
                                ";
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    echo "
                                    <tr>
                                        <td>".$row['description']."</td>
                                        <td>".$row['requirements']."</td>
                                        <td>".$row['date_posted']."</td>
                                        <td>".$row['deadline']."</td>
                                        <td>".$row['slots']."</td>
                                        <td><button type='button' data-toggle='modal' data-target='#jobApplicationModal' class='btn btn-primary btn-sm'>APPLY</button></td>
                                    </tr>";
                                }
                                echo "</table>";
                            }
                        }catch(PDOException $exception){
                           echo $exception->getMessage();
                        }
                              
                              
                              ?>
                            
                                    </div><!--end the panel body div-->
                                </div><!--end the panel div-->
                        </div><!--end the col-md-12 div-->
                </div>
        </div><!--end the roe div-->
</div>
</div>
</div>
            <hr>
        <div class="container">
            <div class="row">
            <?php include('footer.inc.php');?>
            </div>
    <div><!--end the container div-->
</div><!--end the container-fluid-->
                        <!--=============================== JOB APPLICATION========================-->
                        <?php 
                    if($_SERVER['REQUEST_METHOD'] == "POST"){
                        if(isset($_POST['surname'])){
                            $surname = $_POST['surname'];
                        }
                        if(isset($_POST['middle'])){
                            $middle = $_POST['middle'];
                        }
                        if(isset($_POST['last'])){
                            $last = $_POST['last'];
                        }
                        if(isset($_POST['email'])){
                            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                                $email = $_POST['email'];
                            }else{
                                $error = "Invalid email address";
                            }
                        }
                        if(isset($_POST['phone'])){
                            $phone = $_POST['phone'];
                        }
                
                        if(isset($_POST['address'])){
                        $address = $_POST['address'];
                    }
                        if(isset($_POST['job'])){
                        $job = $_POST['job'];    
                    }
                    if(isset($_FILES['resumecv'])){
                        $file_path = "resume/";
                        $file_path = $file_path.basename($_FILES['resumecv']['name']);
                        $file_type = pathinfo($file_path, PATHINFO_EXTENSION);
                        if($file_type === "pdf"){
                            if(move_uploaded_file($_FILES['resumecv']['tmp_name'], $file_path)){
                                $error = "File uploaded successfully";
                            }
                        }else{
                            $error = "Invalid file type";
                        }
                        

                    }  
                    require('./connect.inc.php');
                    try{
                        $stmt = $pdoConnection->prepare("INSERT INTO applications(AppId,Surname, Middle_Name,Last_Name,Email,phone,address,resume,job) VALUES
                        (:app,:surname,:middleName,:last,:email,:phone,:address,:resume,:job)");
                        $stmt->execute(array(':app'=>'',':surname'=>$surname,':middleName'=>$middle,':last'=>$last,':email'=>$email,':phone'=>$phone,':address'=>$address,
                        ':resume'=>$file_path,':job'=>$job));
                        $count = $stmt->rowCount();
                        if($count > 0){
                            $error = "Thank you for applying for the job, we shall get back to you soon";
                        }else{
                            $error = "Could not perform your application";
                        }
                    }catch(PDOException $exception){
                        echo $exception->getMessage();
                    }
                }
                        
                        ?>

                    <div class="modal modal-fade" id="jobApplicationModal">
                    <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Job Application</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                     </button>
                </div>
            <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                            <?php  echo $error ;?>
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" name="surname" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="middle" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last" class="form-control"/>
                        </div>
                    <div class="form-group">
                        <label>Emaill Address</label>
                        <input type="email" name="email" class="form-control"/>
                    </div>
                    <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control"/>
                    </div>
                    <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control"/>
                    </div>
                    <div class="form-group">
                            <label>Job Description</label>
                            <input type="text" name="job" class="form-control" placeholder="Enter the job you are applying for here"/>
                    </div>
                    <div class="form-group">
                            <label>Upload Cv/Resume</label>
                            <input type="file" name="resumecv" class="form-control"/>
                    </div>
                    <div class="form-group">
                            <input type="submit" class="btn btn-success btn-lg pull-left" value="Send"/>
                            <button type="button" id="btnCancel" class="btn btn-danger btn-lg pull-right">Cancel</button>
                    </div>
                        </form>
            </div><!--end the modal body div-->
            <div class="modal-footer">
                            <!-- ==============MODAL FOOTER =====================-->
            </div>
                            </div><!--end the modal content div-->
                    </div><!--end the odal dialog div--> 
                    </div><!--end the job application modal-->
<!--==================================JQUERY PLUGIN=====================-->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--==============================END JQUERY==========================-->
<script>
    
    $(document).ready(function(){
        $('.smoothScrollLink').click(function(event){
            event.preventDefault();
            var href = $(this).attr('href');
            $('body, html').animate({
                scrollTop:$(href).offset().top
            }, 5000);
        });
    });
    document.getElementById('btnCancel').onclick = function(){
        location.href="index.php";
    }
    </script>
</body>
</html>