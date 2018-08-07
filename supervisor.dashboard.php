<?php
//php code goes here
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" />
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
            <li><a href="#"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>  Update Profile</a></li>
            <li><a href="./employeeLogout.php"><span class="glyphicon glyphicon-off"></span> Log Off</a></li>
        </ul>
    </li>
    </div>
</div>
        <?php 
        $error = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['date'])){
            $date = $_POST['date'];
        }
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }
        if(isset($_POST['timeA'])){
            $_start_time = $_POST['timeA'];
        }
        if(isset($_POST['timeB'])){
            $end_time = $_POST['timeB'];
        }
        if(empty($_POST['date']) || empty($_POST['id']) || empty($_POST['timeA'])|| empty($_POST['timeB'])){
            $error = "Please check the missing field(s)";
        }
        else{
            require("./connect.inc.php");
            try{
                $stmt = $pdoConnection->prepare("INSERT INTO Attendance(date,EmpId,Attendance_Time,Leaving_Time) VALUES(:date,:id,:time_entered,:time_left)");
                $stmt->execute(array(':date'=>$date,':id'=>$id,':time_entered'=>$_start_time,':time_left'=>$end_time));
                $count = $stmt->rowCount();
                if($count > 0){
                    $error = "Update successful";
                    header("Location:supervisor.dashboard.php");
                }else{
                    $error = "Unable to update details";
                    exit();
                }
            }catch(PDOException $exception){
                echo $exception->getMessage();
            }
        }
    }
        
        ?>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable">
                        <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1" data-toggle="tab">Employee Attendance</a></li>
                                <li><a href="#tab2" data-toggle="tab">Reports</a></li>
                                <li><a href="#tab4" data-toggle="tab">Departments</a></li>
                                <li><a href="#tab5" data-toggle="tab">Leave Management</a></li>

                        </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                    <form method="post" name="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ;?>">
                    <?php echo $error ;?>
                        <table class="table">
                                <tr>
                        <td>
                            <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control"/>
                            </div>
                        </td>
                                </tr>
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
                        <div class="form-group">
                            <label>Attendance Time</label>
                            <input type="time" name="timeA" class="form-control"/>
                        </div>
                </td>
                        </tr>
                        <tr>
                <td>
                        <div class="form-group">
                            <label>Leaving Time</label>
                            <input type="time" name="timeB" class="form-control"/>
                        </div>
                </td>
                        </tr>
                    <tr>
                    <td>
                            <input type="submit" class="btn btn-primary btn-lg" value="Save"/>
                            <button type="button" id="btnExit" class="btn btn-danger btn-lg pull-right">Cancel</button>
                        </td>
                    </tr>
                        </table>

                </form>
                    </div><!--end the a ctive tab pane-->
                            <div class="tab-pane" id="tab2">
                                    <div class="panel panel-primary">
                                            <div class="panel-heading text-center">Report About Employees
                                            </div>
                                            <div class="panel-body">
                                                <?php 
                                                require('./connect.inc.php');
                                                try{
                                                    $stmt = $pdoConnection->prepare("SELECT * FROM reports ORDER BY id ASC");
                                                    $stmt->execute();
                                                    $count = $stmt->rowCount();
                                                    if($count > 0){
                                                        echo "
                                                        <table class='table responsive'>
                                                        <tr>
                                                            <th>Report Id</th>
                                                            <th>Employee Id</th>
                                                            <th>Report Details</th>
                                                            <th>Date Filed</th>
                                                        </tr>
                                                        ";
                                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                            echo "
                                                            <tr>
                                                                <td>".$row['id']."</td>
                                                                <td>".$row['EmpId']."</td>
                                                                <td>".$row['details']."</td>
                                                                <td>".$row['fileDate']."</td>
                                                            </tr>
                                                            
                                                            ";
                                                        }
                                                        echo "</table>";
                                                    }else{
                                                        $error = "Could not retreive reports";
                                                    }
                                                }catch(PDOException $exception){
                                                    echo $exception->getMessage();
                                                }
                                                
                                                ?>
                                            </div>
                                            <div class="panel-footer">
<button type="button" data-toggle="modal" data-target="#reportModal" class="btn btn-info btn-lg">Add New Report</button>
<button type="button" data-toggle="modal" data-target="#reportModal3" class="btn btn-danger pull-right btn-lg">Delete Report</button>
                                            </div>
                                    </div>
                    </div><!--end the second tab pane-->

                    <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                }
                if(isset($_POST['reportDetails'])){
                    $report = $_POST['reportDetails'];
                }
                if(isset($_POST['date'])){
                    $date = $_POST['date'];
                }
                if(empty($_POST['id']) || empty($_POST['date']) || empty($_POST['reportDetails'])){
                    $error = "Checke the missing field(s)";
                }else{
                require('./connect.inc.php');
                try{
                    $stmt = $pdoConnection->prepare("INSERT INTO reports(EmpId, details, fileDate) VALUES (:id,:details,:file)");
                    $stmt->execute(array(':id'=>$id,':details'=>$report,':file'=>$date));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        header("Location:supervisor.dashboard.php");
                    }else{
                        $error = "Could not add new report";
                    }
                }catch(PDOException $exception){
                    echo $exception->getMessage();
                }

            }
        }
    
    
    ?>
                     <!-- ===================== ADDITION OF NEW REPORTS  -->
                     <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="exampleModalLabel">Add Employee</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method = "post" action = "<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
            <div class="form-group">
    <label>Employee Id</label>
    <input type="text" name="id" class="form-control"/>
            </div>
            <div class="form-group">
    <label>Details</label>
    <input type="text" name="reportDetails" class="form-control"/>
            </div>
            <div class="form-group">
    <label>Date</label>
    <input type="date" name="date" class="form-control"/>
            </div>
<div class="form-group">
    <input type="submit" value="ADD" class="btn btn-success btn-lg"/>
    <button type="button" id="btnCancel" class="btn btn-danger btn-lg">Cancel</button>


</div>
                                                        </form>
                                                </div>
                                                </div>
                                    </div><!-- end the modal dialog div-->

                     </div><!-- end the modal div-->

                    <!-- ============================= -->
                    <div class="tab-pane" id="tab3">

                    </div><!--end the second tab pane-->
             
                <?php 
            
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_POST['DepId'])){
                    $dep = $_POST['DepId'];
                }
                if(isset($_POST['role'])){
                    $role = $_POST['role'];
                }
                if(empty($_POST['role']) || empty($_POST['DepId'])){
                    $error ="Check the missing field(s) please";
                }else{
                    require('./connect.inc.php');
                    try{
                        $stmt = $pdoConnection->prepare("UPDATE department SET Roles = :role WHERE DepNo = :id  ");
                        $stmt->execute(array(':role'=>$role,':id'=>$dep));
                        $count = $stmt->rowCount();
                        if($count > 0){
                            header("Location:supervisor.dashboard.php");
                        }else{
                            $error = "Failed to add role";
                        }
                        }catch(PDOException $exception){
                        echo $exception->getMessage();
                    }
                }
            }
            
            
            ?> 
                    <div class="tab-pane" id="tab4">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-center">Company Departments</div>
                        <div class="panel-body">
                            <?php 
                                require('./connect.inc.php');
                                try{
                                    $stmt = $pdoConnection->prepare("SELECT * FROM department");
                                    $stmt->execute();
                                    $count = $stmt->rowCount();
                                    if($count > 0){
                                        echo "
                                            <table class='table responsive'>
                                            <tr>
                                                <th>Department Id</th>
                                                <th>Department Number</th>
                                                <th>Department Name</th>
                                                <th>Roles</th>
                                                <th>Action</th>
                                            </tr>
                                        
                                        ";
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                            echo "
                                                <tr>
                                                    <td>".$row['id']."</td>
                                                    <td>".$row['DepNo']."</td>
                                                    <td>".$row['DepName']."</td>
                                                    <td>".$row['Roles']."</td>
                                                    <td><button type = 'button' data-toggle='modal' data-target='#rolesModal' class='btn btn-success btn-sm'>Assign roles</button></td>

                                                </tr>
                                            ";
                                        }
                                        echo "</table>";
                                    }else{
                                        $error = "Could not retreive data";
                                    }
                                }catch(PDOException $exception){
                                    echo $exception->getMessage();
                                }
                        ?>
                        </div>

                        <div class="panel-footer">
                                <?php  echo $error ;?>
                        </div>
                        </div>
                    </div><!--end the second tab pane-->
                            
                            <div class = "modal modal-fade" id="rolesModal">
                                    <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                            <h5 class="modal-title text-center" id="exampleModalLabel">Assign roles to a department</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                </div>
                                    <div class="modal-body">
                                            <form method="post" name="roles" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ;?>">
                                    <?php echo $error ;?>
                                    <div class="form-group">
                                        <label>
                                    Drpartment Id
                                        </label>
                                        <input type="text" name="DepId" class="form-control"/>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                        Roles
                                        </label>
                                        <input type="text" name="role" class="form-control"/>

                                    </div>
                                    <div class="form-group">
                                       <input type="submit" value="Assign" class="btn btn-success btn-lg"/>
                                       <button type="button" class="btn btn-danger btn-lg">Cancel</button>

                                    </div>
                                            </form>
                                    </div>
                                            </div>

                                    </div>

                            </div>

                    <div class="tab-pane" id="tab5">
                            <div class="panel panel-primary">
                                    <div class="panel-heading text-center">Employee Leave Requests</div>
                                    <div class="panel-body">
                                            <?php 
                                         require('./connect.inc.php');
                                         try{
                                            $stmt = $pdoConnection->prepare("SELECT * FROM LeaveRequests ORDER BY TimeApplied DESC");
                                            $stmt->execute();
                                            $count = $stmt->rowCount();
                                            if($count > 0){
                                                echo "<table class='table responsive'>
                                                    <tr>
                                                        <th>Leave Id</th>
                                                        <th>Employee Email</th>
                                                        <th>Time Applied</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Leave Type</th>
                                                        <th>Reason For Request</th>
                                                        <th>Leave Status</th>
                                                        <th>Action</th>
                                                        <th>Counter Action</th>
                                                    </tr>
                                                ";

                                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                    echo "
                                                        <tr>
                                                            <td>".$row['id']."</td>
                                                            <td>".$row['EmpEmail']."</td>
                                                            <td>".$row['TimeApplied']."</td>
                                                            <td>".$row['StartDate']."</td>
                                                            <td>".$row['EndDate']."</td>
                                                            <td>".$row['LeaveType']."</td>
                                                            <td>".$row['Reason']."</td>
                                                            <td>".$row['status']."</td>
                                                            <td><button type='button' class='btn btn-success btn-sm'>Approve</button></td>
                                                            <td><button type='button' class='btn btn-danger btn-sm'>Deny</button></td>


                                                        </tr>
                                                    ";
                                                }
                                                echo "</table>";
                                            }else{
                                                $error = "Could not retreive data";
                                            }
                                         }catch(PDOException $exception){
                                             echo $exception->getMessage();
                                         }   
                                            
                                            ?>
                                    </div>
                                    <div class="panel-footer"><?php  echo $error;?></div>
                            </div>
                    </div>
                </div><!--end the tab content div-->
                </div><!--end the tabbable div-->
            </div><!--end the col-md-12 div-->
        </div>
</div>
    <div class="container">
<?php include('footer.inc.php') ;?>
    </div>
    <script type="text/javascript">
        document.getElementById('btnExit').onclick = function(){
            location.href= "supervisor.dashboard.php";
        }
    
    </script>
    <script>
document.getElementById('btnCancel').onclick = function(){
            location.href= "supervisor.dashboard.php";
        }
    </script>
</body>
</html>