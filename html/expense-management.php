<?php   //expense-management.php.php
        //Ammar Ahmad

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  $employeeID = "1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="../pictures/favicon.png">
    <link rel="stylesheet" href="../css/custom-bootstrap.css">
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/employee-js.js"></script>
</head>

<body>
    <!---------------------------------Navigation bar--------------------------------->
        <nav class="navbar navbar-dark bg-primary fixed-top">
            <div class="container-fluid">
                <div class="nav navbar-nav navbar-header">
                    <a class="navbar-brand" href="index.php"><img src="../pictures/logo.jpg" alt="COMPENNY"></a>
                </div>
                <div class="nav navbar-nav navbar-right" >
                    <a href="logout.php" class="navbar-brand">Logout</a>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sticky-top" style="height: 100vh; position: fixed;top: 70px;">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item" style="margin: 15px 0 7px 0;">
                            <a class="nav-link" href="./employee-home.php">
                                Dashboard
                            </a>
                        </li>
                        <br>
                        <li class="nav-item bg-secondary" style="margin: 15px 0 7px 0;border-radius: 10px;">
                            <a class="nav-link active font-weight-bold" href="">
                                Expense Managememt
                            </a>
                        </li>
                        <br>
                        <li class="nav-item" style="margin: 15px 0 7px 0;">
                            <a class="nav-link" href="./employee-analytics.php">
                                Analytics
                            </a>
                        </li>
                    </ul>
                </div>
                </nav>
            <!---------------------------------PAGE CONTENT--------------------------------->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-100" style="padding-top: 100px">

                </main>

            </div>
        </div>
    </body>

</html>