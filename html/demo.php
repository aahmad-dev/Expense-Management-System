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
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php"><img src="../pictures/logo.jpg" alt="COMPENNY"></a>
                </div>
                
                 <!-- Collapse button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicNav"
                    aria-controls="basicNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div class="collapse navbar-collapse" id="basicNav">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item active">
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
            <h2>Welcome to the</h2>
            <h1>Expense Management System Demo</h1>
        </div>
        
        <div class="container text-center">
            <h2>Please select one to test out the features:</h2>
            <br><br>
            <button type="button" class="btn btn-secondary" onclick="document.location='employee-home.php'">Employee View</button>
            <button type="button" class="btn btn-primary" onclick="document.location='manager-home.php'">Manager View</button>
 
        </div>


    </body>

    <footer>
        <!-- Copyright -->
        <div class="footer-copyright bg-secondary text-center py-3 fixed-bottom">© 2020 Copyright: COMPENNY Inc.
        </div>
    </footer>
      
</html>