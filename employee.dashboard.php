<?php
session_start();
$request = 0;
$error = "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>employee management system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
<div class="navbar navbar-inverse navbar-static-top navbar-dark bg-dark">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#employee-login-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
        <a class="navbar-brand">Welcome <?php echo $_SESSION['email'] ;?></a>
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
<!-- <div class="container">
    <div class="jumbotron text-center">
        <h4>Welcome  <?php //echo $_SESSION['email'];?><h4>
    <div>
<div> -->
<?php
    require('./connect.inc.php');
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['email'])){
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $email = $_POST['email'];
            }else{
                $error = "Invalid email address";
            }
        }
        if(isset($_POST['leaveType'])){
            $leaveType = $_POST['leaveType'];
        }
        if(isset($_POST['start'])){
            $start_date = $_POST['start'];
        }
        if(isset($_POST['end'])){
            $end_date = $_POST['end'];
        }
        if(isset($_POST['details'])){
            $reason = $_POST['details'];
        }
        if(empty($_POST['details']) || empty($_POST['start']) || empty($_POST['end']) || empty($_POST['leaveType']) || empty($_POST['email'])){
            $error = "Please check the missing field(s)";
        }else{
            try{
            $stmt = $pdoConnection->prepare("INSERT INTO LeaveRequests(EmpEmail,StartDate, EndDate,LeaveType,Reason) VALUES(:email,:start,:end,:type,:reason)");
            $stmt->execute(array(':email'=>$email,':start'=>$start_date,':end'=>$end_date,':type'=>$leaveType,':reason'=>$reason));
            $count = $stmt->rowCount();
            if($count == 1){
                $error = "Leave application successfull";
                $request += $count;

            }else{
                $error = "Could not place your leave request";
            }
        }catch(PDOException $exception){
            echo $exception->getMessage();
        }
    }
    }

?>
    <div class="container">
        <div class="col-md-12">
        <div class="tabbable">
	<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Personal Information</a></li>
<li><a href="#tab2" data-toggle="tab">Leave</a></li>
<!-- <li><a href="#tab3" data-toggle="tab">Partron</a></li> -->
	</ul><!--end ul nav tabs-->
<div class="tab-content">
<div class="tab-pane active" id="tab1">
    <div class="panel panel-primary">
    <div class="panel-heading">Your Data</div>
<div class="panel-body">
    <?php 
    try{
        require('./connect.inc.php');
        $stmt = $pdoConnection->prepare("SELECT * FROM employee WHERE EmpEmail = :email");
        $stmt->execute(array(':email'=>$_SESSION['email']));
        $count = $stmt->rowCount();
        if($count == 1){
            echo "
                <table name='data-table' class='table'>
                <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>CONTACT</th>
                        <th>EMAIL</th>
                        <th>ADDRESS</th>
                        <th>BIRTH DATE</th>
                        <th>DEPARTMENT</th>
                        <th>DATE JOINED</th>
                        <th>SALARY</th>
                        <th>POSITION</th>
                        
                </tr>
            ";
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo "
                    <td>".$row['EmpId']."</td>
                    <td>".$row['EmpName']."</td>
                    <td>".$row['EmpContactNo']."</td>
                    <td>".$row['EmpEmail']."</td>
                    <td>".$row['EmpAddress']."</td>
                    <td>".$row['EmpDob']."</td>
                    <td>".$row['EmpDepartment']."</td>
                    <td>".$row['EmpDateOfJoin']."</td>
                    <td>".$row['EmpSalary']."</td>
                    <td>".$row['EmpPosition']."</td>
                    
                </tr>";
            }
            echo "</table>";
        }
    }catch(PDOException $exception){
       echo  $exception->getMessage();
    } 
    ;?>
</div>
    </div>
</div><!--end active tab pane-->

<div class="tab-pane" id="tab2">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="well well-primary text-center">
                Approvals
<div class="badge">4</div><br><br>
    <button type="button" class="btn btn-success btn-sm">
        View
    </button>
                </div>
            </div>
            <div class="col-md-4">
                    <div class="well well-success text-center">Pending
                <div class="badge badge-primary">2</div><br><br>
            <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
        </div>
    <div class="col-md-4">
            <div class="well">
                New Requests
            <div class="badge"><?php echo $request ;?></div><br></br>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#leaveRequestDiv">Make Request</button>
    <div class="modal modal-fade" data-toggle="modal" id="leaveRequestDiv" tab-index="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center">Employee Leave Request</h4>
            </div>
        <div class="modal-body">
        
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Apply For Leave here</div>
            <div class="panel-body">
<form name="leaveform" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
        <?php echo $error ;?>
        <div class="form-group"><label>Email Address</label><input type="email" class="form-control" name="email"/></div>
        <div class="form-group">
        <label>Leave Type</label>
        <select name="leaveType" class="form-control">
                <option value="MaternityLeave">MaternityLeave</option>
                <option value="SickLeave">SickLeave</option>
                <option value="AnnualLeave">AnnualLeave</option>
        </select>
        </div>
    <div class="form-group">
    <label>Start Date</label>
<input type="date" name="start" class="form-control"/>
</div>

<div class="form-group">
<label>End Date</label>
<input type="date" name="end" class="form-control"/>
        </div>
    <div class="Form-group">
    <label>Reason for leave</label>
    <textarea value ="" name="details" class="form-control">
    
    </textarea>
    </div><br>
    <div class="form-group">
<input type="submit" class="btn btn-success btn-lg" value="SAVE"/>
<input type="button" class="btn btn-danger btn-lg pull-right" id="btnCancel"value="CANCEL"/>

    </div>
</form>
            </div><!--end the panel body div-->
        </div>
    </div>
</div>
        </div>
    </div>
            </div>
        </div>
    </div>
            </div>
    </div>
      
    </div>
</div>
<div class="tab-pane" id="tab4">

</div><!--end the tab 4 dv-->
</div><!--close tab content-->
</div><!--end tabbable div class-->
        </div>
    </div>
</div>
<div class="container">
<?php  include('./footer.inc.php');?>
<div>
<script>
document.getElementById('btnCancel').onclick = function(){
    location.href = "./";
}

</script>
</body>
</html>
