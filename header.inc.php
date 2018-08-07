<?php ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script>
    function toggleBtnSidebar(){
        document.getElementById('sidenav').classList.toggle('active');
    }
    </script>
    <style>
*{
    margin:0;
    padding:0;
    font-family:sans-serif;
}
    #sidenav{
        position:fixed;
        width:200px;
        height:100%;
        background:#455585;
        left:-200px;
    }
    #sidenav .active{
        left:0;
    }
    #sidenav ul li{
        list-style:none;
        padding:15px 10px;
        border-bottom:1px solid #fff;
        color:rgba(230,230,230,.9);

    }
    #sidenav .toggle-btn{
        position:absolute;
        left:230px;
        top:20px;
    }
    #sidenav .toggle-btn span{
        display:block;
        width:30px;
        height:5px;
        background:#333;
        margin:5px 0px;
      
    }
    #sidenav .active{

    }
    </style>
</head>
<body>
    <div id="sidenav">
    <div class="toggle-btn" onclick="toggleBtnSidebar()">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    </div>
            <ul>
            <li>Home</li>
            <li>Employee</li>
            <li>About</li>
            <li>Services</li>
            </ul>
    </div>
</body>
</html>