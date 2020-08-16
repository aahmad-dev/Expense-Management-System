<?php   //employee-management.php 
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
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/manager.js"></script>
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
                        <li class="nav-item" style="margin: 15px 0 7px 0;">
                            <a class="nav-link" href="./finance-management.php">
                                Budget Managememt
                            </a>
                        </li>
                        <br>
                        <li class="nav-item bg-secondary" style="margin: 15px 0 7px 0;border-radius: 10px;">
                            <a class="nav-link active font-weight-bold" href="">
                                Employee Management
                            </a>
                        </li>
                    </ul>
                </div>
                </nav>
            <!---------------------------------PAGE CONTENT--------------------------------->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="padding-top: 100px">
                    <hr>
                    <h4>Employee Managememt</h4>
                    <hr>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="card mt-3">
                                    <div class="card-title ml-5 my-2 mr-5">
                                        <!--Add Employee Button-->
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addEmployee">Add New Employee</button>
                                    </div>
                                    <!--Display expenses-->
                                    <div class="card-body" id="employeeTable">
                                        <!------------------------------------------DISPLAY TABLE----------------------------------------->
                                        <div>
                                            <?php
                                                $query = "SELECT * FROM `employees`";
                                                $result = $conn->query($query);
                                                if (!$result) die ("Database access failed: " . $conn->error);
                                                $rows = $result->num_rows;
                                                ?>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Occupation</th>
                                                        <th>Budget</th>
                                                        <th>Budget Status</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    for ($j = 0 ; $j < $rows ; ++$j)
                                                    {
                                                        $result->data_seek($j);
                                                        $row = $result->fetch_array(MYSQLI_NUM);

                                                        $employeeBudgetQuery = "SELECT `budget` FROM `employees` WHERE `employeeID` = $row[0]";
                                                        $employeeBudgetResult = $conn->query($employeeBudgetQuery);
                                                        $employeeBudgetResult->data_seek(1);
                                                        $employeeBudget= $employeeBudgetResult->fetch_array();
                                
                                                        $employeeExpenseQuery = "SELECT SUM(expenseCost) FROM `expenses` WHERE `employee_ID` = $row[0]";
                                                        $employeeExpenseResult = $conn->query($employeeExpenseQuery);
                                                        $employeeExpenseResult->data_seek(1);
                                                        $employeeExpenses= $employeeExpenseResult->fetch_array();

                                                        if($employeeExpenses > $employeeBudget){
                                                            $budgetStatus = '<td class="text-danger">Over Budget</td>';
                                                        }
                                                        else{
                                                            $budgetStatus = '<td class="text-success">Under Budget</td>';
                                                        }
                                                        
                                                        echo <<<_END
                                                        <tr>
                                                            <th>$row[0]</th>
                                                            <td>$row[1] $row[2]</td>
                                                            <td>$row[3]</td>
                                                            <td>$row[4]</td>
                                                            $budgetStatus
                                                            <td>
                                                                <button type="button" class="btn btn-light" id="editBtn" data-id=$row[0]>Edit</button>
                                                            </td>
                                                            <td>
                                                                <button type="button" id="deleteEmpBtn" data-id=$row[0] class="btn btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
_END;
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <!--Add Expense modal-->
                    <div class="modal fade" id="addEmployee">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-primary">Add New Employee</h3>
                                </div>
                                <div class="modal-body">
                                    <form >
                                        <label>First Name: <input type="text" class="form-control my-2" id="firstName"></label>
                                        <br>
                                        <label>Last Name: <input type="text" class="form-control my-2" id="lastName"></label>
                                        <br>
                                        <label>Occupation: <input type="text" class="form-control my-2" id="occupation"></label>
                                        <br>
                                        <label>Budget: <input type="number" class="form-control my-2" min=0 id="empBudget"></label>
                                    </form>
                                    <p class="text-danger" id="fEmptyMessage">Please fill in all blanks</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" onclick="insertEmployee();">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!----------------------------------------------------Edit Expense Modal------------------------------------------------------------->
                    <div class="modal fade" id="editEmployee">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-primary">Edit Employee Information</h3>
                                </div>
                                <div class="modal-body">
                                <div class="modal-body">
                                    <form>
                                        <input type='hidden' id='editEmployeeID' name='editEmployeeID' value = ""/>
                                        <label>First Name: <input type="text" class="form-control my-2" id="editFirstName"></label>
                                        <br>
                                        <label>Last Name: <input type="text" class="form-control my-2" id="editLastName"></label>
                                        <br>
                                        <label>Occupation: <input type="text" class="form-control my-2" id="editOccupation"></label>
                                        <br>
                                        <label>Budget: <input type="number" class="form-control my-2" min=0 id="editEmpBudget"></label>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" onclick="editEmployee()" onclick="">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </main>
            </div>
        </div>
    </body>

</html>