<?php   //finance-management.php 
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
        <div class="container-fluid">
            <div class="row">
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
            </div>
        </div>
                
        
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sticky-top" style="height: 100vh; position: fixed;top: 70px;">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item" style="margin: 15px 0 7px 0;">
                            <a class="nav-link" href="./manager-home.php">
                                Dashboard
                            </a>
                        </li>
                        <br>
                        <li class="nav-item bg-secondary" style="margin: 15px 0 7px 0;border-radius: 10px;">
                            <a class="nav-link active font-weight-bold" href="">
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
                    <hr>
                    <h4>Budget Managememt</h4>
                    <hr>
                    <!--MANAGE BUDGET BUTTON-->
                    <div class="container-fluid">
                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#manageBudgetModal">Manage Budgets</button>
                        </div>
                    </div>

                    <div class="modal" id="manageBudgetModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-primary">Manage Budgets for Current Year</h3>
                                </div>
                                <form action="../backend/manager_functions.php" method="POST">
                                    <div class="modal-body">
                                        <?php
                                            $query = "SELECT `totalBudget`,`clientMeetingBudget`,`travelBudget`,`suppliesBudget`,`otherBudget` FROM `managers` WHERE `managerID` = '1'";
                                            $result = $conn->query($query);
                                            if (!$result) die ("Database access failed: " . $conn->error);
                                            $budgetRow= mysqli_fetch_assoc($result);
                                        ?>
    
                                            </label>
                                            <br>
                                            <label>Total Budget: <input type="number" class="form-control my-2" step="0.01" min=0 name="totalBudget" value=<?php echo $budgetRow['totalBudget']; ?>></label>
                                            <br>
                                            <label>Client Meeting Budget: <input type="number" class="form-control my-2" min=0 name="clientMeetingBudget" value=<?php echo $budgetRow['clientMeetingBudget']; ?>></label>
                                            <br>
                                            <label>Travel Budget: <input type="number" class="form-control my-2" min=0 name="travelBudget" value=<?php echo $budgetRow['travelBudget']; ?>></label>
                                            <br>
                                            <label>Supplies Budget: <input type="number" class="form-control my-2" min=0 name="suppliesBudget" value=<?php echo $budgetRow['suppliesBudget']; ?>></label>
                                            <br>
                                            <label>Other Budget: <input type="number" class="form-control my-2" min=0 name="otherBudget" value=<?php echo $budgetRow['otherBudget']; ?>></label>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" onclick="">Save Budget</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php
                        $totalBudgetQuery = "SELECT `totalBudget` FROM `managers` WHERE `managerID` = '1' ";
                        $totalBudgetResult = $conn->query($totalBudgetQuery);
                        $totalBudgetResult->data_seek(1);
                        $totalBudget= $totalBudgetResult->fetch_array();

                        $totalExpenseQuery = "SELECT SUM(expenseCost) FROM `expenses` WHERE 1 ";
                        $totalExpenseResult = $conn->query($totalExpenseQuery);
                        $totalExpenseResult->data_seek(1);
                        $totalExpenses= $totalExpenseResult->fetch_array();

                        $remainingBudget = $totalBudget[0] - $totalExpenses[0];
                        echo<<<_END
                            <div class="container-fluid mx-auto">
                                <div class="row">
                                    <div class="card col-sm-4">
                                        <div class="card-body">
                                            <h5>Total Budget: $$totalBudget[0]</h5>
                                        </div>
                                    </div>
                                    
                                    <div class="card col-sm-4 mx-auto">
                                        <div class="card-body">
                                            <h5>Total Expenses: $$totalExpenses[0]</h5>
                                        </div>
                                    </div>
                                    
                                    <div class="card col-sm-4 mx-auto">
                                        <div class="card-body">
                                            <h5>Remaining Budget: $$remainingBudget</h5>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
_END;
                    ?>

<!------------------------------------------------------ACTUAL VS BUDGET CATEGORY GRAPH------------------------------------------------------------>
                    
                    <br>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card col-sm-10 mx-auto" style=" height: 30rem;">
                                <div class="card-body">
                                    <?php
                                        $budgetedQuery = "SELECT `travelBudget`,`clientMeetingBudget`,`suppliesBudget`,`otherBudget` FROM `managers` WHERE `managerID` = '1'";
                                        $budgetedResult = $conn->query($budgetedQuery);
                                        $budgetedResult->data_seek(1);
                                        $budgetRow= $budgetedResult->fetch_array();
                                    
                                        $query = "SELECT expense_type.expenseDesc AS category, SUM(expenseCost) AS totalYearExpense FROM `expenses`
                                                    INNER JOIN expense_type ON expenses.expenseType = expense_type.expenseCode
                                                    WHERE year(expenses.expenseOn) = YEAR(CURRENT_TIMESTAMP)
                                                    GROUP BY expenseType";
                                        
                                        $result = $conn->query($query);
                                        if(!$result) die($conn->error);
                                        $rows = $result->num_rows;
                                        
                                        echo "<!--".$budgetRow."-->";
                                        echo <<<_END
                                                
                                                <script type="text/javascript">
                                                google.charts.load("current", {packages:["corechart"]});
                                                google.charts.setOnLoadCallback(drawChart);
                                                function drawChart() {
                                                    var data = google.visualization.arrayToDataTable([
                                                    
                                                    ['Category', 'Budgeted Expense', 'Actual Expense'],
_END;
                                                    
                                                    for($i = 0; $i < $rows; ++$i){
                                                        $result->data_seek($i);
                                                        $row = $result->fetch_array();
                                                        
                                                        echo "['".$row["category"]."', ".intval($budgetRow[$i]).", ".intval($row["totalYearExpense"])."],";
                                                    }
                                                    
                                        echo <<<_END
                                                ]);
                                        
                                                    var options = {
                                                        title: 'Actual Vs. Budgeted Expenses by Category',
                                                        colors: ['#2B7A78', '#76A7FA'],
                                                        legend:{position:'bottom'},
                                                        titleTextStyle: {color: '#02353C', fontSize: 18},
                                                        hAxis: {title: "Expense Category"},
                                                        vAxis: {title: "Expenses ($)"},
                                                        animation: {
                                                            startup:true,
                                                            duration: 1000,
                                                            easing: 'out'
                                                        }
                                                    };
                                                
                                                    var chart = new google.visualization.ColumnChart(document.getElementById('budget-actualChart'));
                                                    chart.draw(data, options);
                                                }
                                        </script>

_END;

                                        ?>
                                    
                                    <div id="budget-actualChart" style="width: 100%; height:100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    
                </main>
            </div>
        </div>
    </body>

</html>