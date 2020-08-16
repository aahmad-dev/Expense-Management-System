<!DOCTYPE html>
<html lang="en">
    <head>
        <title>COMPENNY Expense Management System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="icon" type="image/png" sizes="32x32" href="../pictures/favicon.png">
        <link rel="stylesheet" href="../css/custom-bootstrap.css">
        <script src="../js/bootstrap.js"></script>
        <script src="../js/jquery-3.5.1.js"></script>
        <style>
        div.shadowed {
          filter: drop-shadow: 4px 0 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href=""><img src="../pictures/logo.jpg" alt="COMPENNY"></a>
                </div>
                
                 <!-- Collapse button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicNav"
                    aria-controls="basicNav" aria-expanded="false" aria-label="Toggle-navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div class="collapse navbar-collapse" id="basicNav">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="demo.php">Demo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                    </ul>
                </div>
            
            </div>
        </nav>
        <div class="jumbotron text-center">
            <h3>Expense Tracking...but Better</h3>
            <br>
            <h1>COMPENNY Automates your Expense Management</h1>
            <br>
            <h5>We offer a modern way to manage your expenses. Its simple: COMPENNY is as good for your team as it is for your business.</h5>
            <br><br>
            <button type="button" class="btn btn-primary" onclick="document.location='demo.php'">Explore the Demo</button>

        </div>
        
                
        <div class="container-fluid mx-auto d-block" style="text-align: center;">
            <div class="shadowed">
                <img src="../pictures/manager dashboard.jpg" alt="Picture of manager dashboard" style="width: 75%;height: auto;">
            </div>
            <hr>
            <br><br>
            <h5>Manage employee expenses, budgets, and view spending trends all in one place.</h5>
            <br>
            <button type="button" class="btn btn-primary" onclick="document.location='demo.php'">EXPLORE DEMO</button>
            <br>
            <hr>
            <br><br>
        </div>

                
        <div class="container-fluid mx-auto d-block" style="text-align: center;">
            <div class="shadowed">
                <img src="../pictures/employee expense management.jpg" alt="Picture of employee expense management" style="width: 75%;height: auto;">
            </div>
            <hr>
            <br><br>
            <h5> Our web-based application allows employees to manage their own expenses. Giving you more time to focus on more important business activites.</h5>
            <br>
            <button type="button" class="btn btn-primary" onclick="document.location='demo.php'">EXPLORE DEMO</button>
            <br>
            <hr>
            <br><br>
        </div>

    </body>
    <footer>
        <!-- Copyright -->
        <div class="footer-copyright bg-secondary text-center py-3">© 2020 Copyright: COMPENNY Inc.
        </div>
    </footer>
      
</html>