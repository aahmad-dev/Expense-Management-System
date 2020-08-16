<?php   //employee-analytics.php
        //Ammar Ahmad

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  $employeeID = "2";
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
            <nav class="col-md-2 d-none d-md-block sticky-top" style="height: 100vh; position: fixed;top: 70px;background-color: #bbe1fa;">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item" style="margin: 15px 0 7px 0;">
                            <a class="nav-link" href="./employee-home.php">
                                Manage Expenses
                            </a>
                        </li>
                        <br>
                        <li class="nav-item" style="margin: 15px 0 7px 0;border-radius: 10px;background-color: #3282b8">
                            <a class="nav-link active font-weight-bold" href="">
                                Analytics
                            </a>
                        </li>

                    </ul>
                </div>
                </nav>
            <!---------------------------------PAGE CONTENT--------------------------------->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-100" style="padding-top: 100px">
                    <hr>
                    <h4>Expense Analytics</h4>
                    <hr>
                    <?php
                        $totalBudgetQuery = "SELECT `budget` FROM `employees` WHERE `employeeID` = $employeeID";
                        $totalBudgetResult = $conn->query($totalBudgetQuery);
                        $totalBudgetResult->data_seek(1);
                        $totalBudget= $totalBudgetResult->fetch_array();

                        $totalExpenseQuery = "SELECT SUM(expenseCost) FROM `expenses` WHERE `employee_ID` = $employeeID";
                        $totalExpenseResult = $conn->query($totalExpenseQuery);
                        $totalExpenseResult->data_seek(1);
                        $totalExpenses= $totalExpenseResult->fetch_array();

                        $remainingBudget = $totalBudget[0] - $totalExpenses[0];
                        $percentRemainingBudget = number_format( ( $remainingBudget / $totalBudget[0]) * 100, 2 );
                        if ($percentRemainingBudget < 0){$percentRemainingBudget = 0;};
                        $percentUsedBudget = number_format( ( $totalExpenses[0] / $totalBudget[0]) * 100, 1 );
                        if ($percentUsedBudget > 100){$percentUsedBudget = 100;};
                        echo<<<_END

                            

                            <div class="container-fluid mx-auto">
                                <div class="row">
                                    <div class="card col-sm-2 my-auto text-center">
                                        <div class="card-body justify-content-center">
                                            <h4>$$totalBudget[0]</h4>
                                            <p>Total Budget</p>
                                        </div>
                                    </div>
                                    
                                    <div class="card col-sm-2 my-auto text-center">
                                        <div class="card-body justify-content-center">
                                            <h4>$$totalExpenses[0]</h4>
                                            <p>Total Expenses</p>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 justify-content-center text-center">
                                        <div class="card-body">
                                            <script>
                                                google.charts.load("current", {packages:["corechart"]});
                                                google.charts.setOnLoadCallback(drawChart);
                                                function drawChart() {
                                                    var data = google.visualization.arrayToDataTable([
                                                    
                                                    ['Category', 'Count'],
                                                    ['Expenses', $percentUsedBudget],
                                                    ['Budget', $percentRemainingBudget]
                                                    
                                                ]);
                                            
                                                    var options = {
                                                        pieHole: 0.7,
                                                        colors: ['#3282b8', '#d3d3d3'],
                                                        legend:'none',
                                                        pieSliceText: 'none',
                                                        'chartArea': {'width': '100%', 'height': '100%'},
                                                        
                                                    };
                                                
                                                    var chart = new google.visualization.PieChart(document.getElementById('budgetSpentChart'));
                                                    chart.draw(data, options);
                                                }
                                            </script>
                                            
                                            <div id="budgetSpentChart" align="center" style="position:relative;"></div>
                                            <div style="position:absolute;top: 37%;right: 0;bottom: 0;left: 0;text-align:center;">
                                                <h4>$percentUsedBudget%</h4>
                                                <p>% Budget Spent</p>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    
                                    <div class="card col-sm-2 my-auto text-center">
                                        <div class="card-body justify-content-center">
                                            <h4>$$remainingBudget</h4>
                                            <p>Remaining Budget</p>
                                        </div>
                                    </div>

                                    <div class="card col-sm-2 my-auto text-center">
                                        <div class="card-body justify-content-center">
                                            <h4>$percentRemainingBudget%</h4>
                                            <p>% Remaining</p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
_END;
                    ?>

                    <!--Display date time expense chart for employee-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card col-sm-8" style=" height: 25rem;">
                                <div class="card-body">
                                    <?php
                                        $dateChartQuery = "SELECT DATE_FORMAT(expenseOn,'%b') AS expMonth, year(expenseOn) AS expYear, SUM(expenseCost) AS totalMonthExpense FROM `expenses`
                                                            WHERE `employee_ID` = $employeeID
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
                                                    title: 'All Expenses',
                                                    animation: {
                                                       startup:true,
                                                       duration: 1000,
                                                       easing: 'out'
                                                    },
                                                    curveType: 'function',
                                                    colors: ['#3282b8'],
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
                                        $query = "SELECT expense_type.expenseDesc ,count(*) as cnt FROM `expenses` INNER JOIN expense_type ON expenses.expenseType = expense_type.expenseCode 
                                                    WHERE`employee_ID` = $employeeID GROUP BY expenses.expenseType";
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
                                                        colors: ['#1b262c', '#0f4c75', '#3282b8', '#0000FF'],
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
                </main>

            </div>
        </div>
    </body>

</html>