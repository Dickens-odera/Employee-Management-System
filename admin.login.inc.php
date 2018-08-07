<?php
$msg = "";
$col = 0;
$email = $password = $role = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['email'])){
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $msg = "Invalid email address";
            }else{
                $email = $_POST['email'];
            }
        }
        if(isset($_POST['password'])){
            $password = SHA1($_POST['password']);
        }
        else{
            $msg = "Password must be supplied";
        }
        if(isset($_POST['role'])){
            $role = $_POST['role'];
        }
        if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])){
            $msg = "PLease check the missing field(s)";
        }
        else{
            require('./connect.inc.php');
            try{
                $stmt = $pdoConnection->prepare("SELECT email, password, role FROM admin WHERE email = :email AND password = :password AND role = :role");
                $stmt->execute(array(':email'=>$email, ':password'=>$password, ':role'=>$role));
                $count = $stmt->rowCount();
                if($count > 0){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        session_start();
                        $_SESSION['username'] = $row['email'];
                        setcookie('admin',$_SESSION['username'], time()+ 60*60);
                        $rowCount = $stmt->rowCount();
                        $col +=$rowCount;
                        //echo $row['email'];
                        //header("Location:../includes/employee/get.php");
                        switch($row['role']){
                            case 'hr':
                                header("Location:./hr.dashboard.php");
                            break;

                            case 'hod':
                                header("Location:./hod.dashboard.php");
                            break;

                            case 'assHr':
                                header("Location:./assHr.dashboard.php");
                            break;

                            case 'supervisor':
                                header("Location:./supervisor.dashboard.php");
                            break;

                            default :

                            header("Location:./index.php");
                            break;
                        }
                    }
                }else{
                    $msg = "Could not log you in";
                }
            }catch(PDOException $exception){
                echo $exception->getMessage();
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee management system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="bootstrap/includes/js/jquery-1.8.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css"/>
    <script src="main.js"></script>
</head>
<body>
    <div class="container" id="admin-login">
            <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                    <h4 class="text-center" id="login-header">Admin Login</h4>
                <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                <?php echo $msg ;?>
                    <div class="form-group">
                   <!--<label>Email Address<label>-->
                    <input type="email" name="email" class="form-control" placeholder="Enter email address"/>
                    </div>
    <div class="form-group">
<!--<label>Password</label>-->
<input type="password" name="password" class="form-control" placeholder="Enter Password"/>
    </div>
    <div class="form-group">
    <div class="form-group">
    <select name="role" class="form-control">
<option value="">Select your role</option>
<option value="supervisor">Supervisor</option>
<option value="hod">Department Head</option>
<option value="assHr">Assistant Hr Mng</option>
<option value="hr">Hr Mng</option>
</select>
    </div>
    <div class="form-group">
        <input type="checkbox" name="remember" id="rem"/>  <label for="rem">Remember me</label>
    </div>
<input type="submit" class="btn btn-success btn-lg" value="LOGIN"/>
<input type="button" id = "reload-btn" class="btn btn-danger btn-lg pull-right" value="EXIT"/>

    </div>
                </form>
                    </div>
                    <div class="col-md-4"></div>
            </div>
    </div>
    <div class="container">
    <?php include('./footer.inc.php');?>
    <div>
    <script>
    var btn = document.getElementById('reload-btn').onclick = function(event){
            location.href= "./index.php";
    }
    </script>
</body>
</html>