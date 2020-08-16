<?php   //manager-home.php
        //Ammar Ahmad

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  $managerID = "1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="../pictures/favicon.png">
    <link rel="stylesheet" href="../css/custom-bootstrap.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/bootstrap.js"></script>
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
                        <li class="nav-item bg-secondary" style="margin: 15px 0 7px 0;border-radius: 10px;">
                            <a class="nav-link active font-weight-bold" href="">
                                Dashboard
                            </a>
                        </li>
                        <br>
                        <li class="nav-item" style="margin: 15px 0 7px 0;">
                            <a class="nav-link" href="./finance-management.php">
                                Budget Managememt
                            </a>
                        </li>
                        <br>
                        <li class="nav-item" style="margin: 15px 0 7px 0;">
                            <a class="nav-link" href="./employee-management.php">
                                Employee Management
                            </a>
                        </li>
                    </ul>
                </div>
                </nav>
            <!---------------------------------PAGE CONTENT--------------------------------->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="padding-top: 100px">
                    <?php
                    $stmt = $conn->prepare("SELECT firstName,lastName FROM `managers` WHERE `managerID` = ?");
                    $stmt->bind_param('s', $managerID);
                    $stmt->execute();
                    $stmt->bind_result($fname, $lname);
                    $stmt->fetch();
                    $stmt->close();

                    echo<<<_END
                        <br>
                        <h2 class="text-center text-primary">Welcome $fname $lname</h2>
                        <br>
_END;
                    ?>
                    
                    <hr>
                    <h4>Dashboard</h4>
                    <hr>
                    
                    <!--Display date time expense chart-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card col-sm-8" style=" height: 25rem;">
                                <div class="card-body">
                                    <?php
                                        $dateChartQuery = "SELECT DATE_FORMAT(expenseOn,'%b') AS expMonth, year(expenseOn) AS expYear, SUM(expenseCost) AS totalMonthExpense FROM `expenses` 
                                                            GROUP BY MONTH(expenseOn), YEAR(expenseOn) ORDER BY  YEAR(expenseOn), MONTH(expenseOn) ASC";
                                        $result = $conn->query($dateChartQuery);
                                        if(!$result) die($conn->error);
                                        
                                        $rows = $result->num_rows;
                                        echo <<<_END
                                                <script type="text/javascript">
                                                    google.charts.load('current', {'packages':['corechart']});
                                                    google.charts.setOnLoadCallback(drawChart);
                                                    function drawChart() {
                                                    var data = google.visualization.arrayToDataTable([
                                                    ['Date', 'Expenses'],
_END;
                                                    
                                                    for($i = 0; $i < $rows; ++$i){
                                                        $result->data_seek($i);
                                                        $row = $result->fetch_array();
                                                        
                                                        echo "['".$row["expMonth"]." ".$row["expYear"]."', ".$row["totalMonthExpense"]."],";
                                                        
                                                    }
                                                    
                                        echo <<<_END
                                                ]);
                                        
                                                  var options = {
                                                    title: 'Team Expenses',
                                                    animation: {
                                                       startup:true,
                                                       duration: 1000,
                                                       easing: 'out'
                                                    },
                                                    curveType: 'function',
                                                    colors: ['#2EAF7D'],
                                                    legend: { position: 'bottom' },
                                                    hAxis: {title: "Date"},
                                                    vAxis: {title: "Expenses ($)"},
                                                    titleTextStyle: {color: '#02353C', fontSize: 18}
                                                  };
                                            
                                                  var chart = new google.visualization.AreaChart(document.getElementById('managerExpenseChart'));
                                            
                                                  chart.draw(data, options);
                                             }
                                        </script>
_END;
                                        ?>
                                    
                                    <div id="managerExpenseChart" style="width: 100%; height:100%"></div>
                                </div>
                            </div>
                            
                            <!----------------------------EXPENSE BY CATEGORY PIE CHART------------------------------------->
                            
                            <div class="card col-sm" style=" height: 25rem;">
                                <div class="card-body">
                                    <?php
                                        $query = "SELECT expense_type.expenseDesc ,count(*) as cnt FROM `expenses` INNER JOIN expense_type ON expenses.expenseType = expense_type.expenseCode GROUP BY expenses.expenseType";
                                        $result = $conn->query($query);
                                        if(!$result) die($conn->error);
                                        
                                        $rows = $result->num_rows;
                                        echo <<<_END
                                                <script type="text/javascript">
                                                google.charts.load("current", {packages:["corechart"]});
                                                google.charts.setOnLoadCallback(drawChart);
                                                function drawChart() {
                                                    var data = google.visualization.arrayToDataTable([
                                                    
                                                    ['Category', 'Count'],
_END;
                                                    
                                                    for($i = 0; $i < $rows; ++$i){
                                                        $result->data_seek($i);
                                                        $row = $result->fetch_array();
                                                        
                                                        echo "['".$row["expenseDesc"]."', ".$row["cnt"]."],";
                                                        
                                                    }
                                                    
                                        echo <<<_END
                                                ]);
                                        
                                                    var options = {
                                                        title: 'Expenses by Category',
                                                        pieHole: 0.4,
                                                        colors: ['#2EAF7D', '#02353C', '#449342', '#3FD0C9'],
                                                        legend:'right',
                                                        titleTextStyle: {color: '#02353C', fontSize: 18}
                                                    };
                                                
                                                    var chart = new google.visualization.PieChart(document.getElementById('expenseByCategoryChart'));
                                                    chart.draw(data, options);
                                                }
                                        </script>

_END;

                                        ?>
                                    <div id="expenseByCategoryChart" style="width: 100%; height:100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
<!--######################################################## RECENT EXPENSES TABLE####################################################################-->
                    <div class="card mt-3">
                        <div class="card-title ml-5">
                            <br>
                            <h5 style=" font-weight: bold">Recent Expenses</h5>
                        </div>
                        <!--Display recent employee expenses-->
                        <div class="card-body">
                            <!------------------------------------------DISPLAY TOP 10 EXPENSE TABLE----------------------------------------->
                            <div>
                                <?php
                                    $query = "SELECT expenseOn, expense_type.expenseDesc, expenseDetails, expenseCost, merchant, employees.firstName, employees.lastName FROM expenses 
                                                INNER JOIN expense_type ON expenses.expenseType = expense_type.expenseCode
                                                INNER JOIN employees ON expenses.employee_ID = employees.employeeID
                                                ORDER BY expenses.expenseOn DESC LIMIT 10";
                                    $result = $conn->query($query);
                                    if (!$result) die ("Database access failed: " . $conn->error);
                                    $rows = $result->num_rows;
                                    ?>
                                <table class="table table-bordered table striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Employee Name</th>
                                            <th>Category</th>
                                            <th>Details</th>
                                            <th>Cost</th>
                                            <th>Merchant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        for ($j = 0 ; $j < $rows ; ++$j)
                                        {
                                            $result->data_seek($j);
                                            $row = $result->fetch_array(MYSQLI_NUM);
                                            
                                            echo <<<_END
                                            <tr>
                                                <td>$row[0]</td>
                                                <td>$row[5] $row[6]</td>
                                                <td>$row[1]</td>
                                                <td>$row[2]</td>
                                                <td>$$row[3]</td>
                                                <td>$row[4]</td>
                                            </tr>
_END;
                                        }

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </main>
            </div>
        </div>
    </body>

</html>