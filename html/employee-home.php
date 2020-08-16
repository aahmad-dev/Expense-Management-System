<?php   //employee-home.php
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
                        <li class="nav-item" style="margin: 15px 0 7px 0;border-radius: 10px;background-color: #3282b8">
                            <a class="nav-link active font-weight-bold" href="">
                                Manage Expenses
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
                    <?php
                    $stmt = $conn->prepare("SELECT firstName,lastName FROM `employees` WHERE `employeeID` = ?");
                    $stmt->bind_param('s', $employeeID);
                    $stmt->execute();
                    $stmt->bind_result($fname, $lname);
                    $stmt->fetch();
                    $stmt->close();

                    echo<<<_END
                        <br>
                        <h2 class="text-center text-primary">Welcome $fname $lname</h2>
_END;
?>                  <hr>
                    <h4>Manage Expenses</h4>
                    <hr>
                        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="card mt-3">
                                    <div class="card-title ml-5 my-2 mr-5">
                                        <!--Add Expense Button-->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addExpense">Add New Expense</button>
<!--
                                        <label style="float:right">Filter: <select class="selectpicker">
                                            <option selected value>None</option>
                                            <option value="1">Travel</option>
                                            <option value="2">Client Meetings</option>
                                            <option value="3">Office Supplies</option>
                                            <option value="4">Other</option>
                                        </select>
                                        </label>
-->
                                    </div>
                                    <!--Display expenses-->
                                    <div class="card-body" id="expenseTable">
                                        <!------------------------------------------DISPLAY TABLE----------------------------------------->
                                        <div>
                                            <?php
                                                $query = "SELECT expenseOn, expense_type.expenseDesc, expenseDetails, expenseCost, merchant, expense_ID, employee_ID FROM expenses 
                                                            INNER JOIN expense_type ON expenses.expenseType = expense_type.expenseCode WHERE employee_ID = '$employeeID'  
                                                            ORDER BY expenses.expenseOn DESC";
                                                $result = $conn->query($query);
                                                if (!$result) die ("Database access failed: " . $conn->error);
                                                $rows = $result->num_rows;
                                                ?>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Category</th>
                                                        <th>Details</th>
                                                        <th>Cost</th>
                                                        <th>Merchant</th>
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
                                                        
                                                        echo <<<_END
                                                        <tr>
                                                            <td>$row[0]</td>
                                                            <td>$row[1]</td>
                                                            <td>$row[2]</td>
                                                            <td>$$row[3]</td>
                                                            <td>$row[4]</td>
                                                            <td>
                                                                <button type="button" class="btn btn-light" id="btn_edit" data-id=$row[5]>Edit</button>
                                                            </td>
                                                            <td>
                                                                <button type="button" id="deleteBtn" data-id=$row[5] class="btn btn-danger">Delete</button>
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
                    <div class="modal fade" id="addExpense">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-primary">Add New Expense</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="">
                                    <?php
                                        echo "<input type='hidden' id='employeeID' name='EmployeeID' value='".$employeeID."'/>";
                                    ?>
                                        <label>Expense Type: <select id="expenseType">
                                            <option disabled selected value>-- Select Category --</option>
                                            <option value="1">Travel</option>
                                            <option value="2">Client Meetings</option>
                                            <option value="3">Office Supplies</option>
                                            <option value="4">Other</option>
                                        </select>
                                        </label>
                                        <br>
                                        <label>Amount: <input type="number" class="form-control my-2" step="0.01" min=0 id="expenseAmount"></label>
                                        <br>
                                        <label>Expense Date: <input type="date" class="form-control my-2" id="expenseOn"></label>
                                        <br>
                                        <label>Merchant: <input type="text" class="form-control my-2" id="merchant"></label>
                                        <br>
                                        <label>Details: <input type="text" class="form-control my-2" size="150" id="expenseDetails"></label>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" onclick="insertRecord();">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!----------------------------------------------------Edit Expense Modal------------------------------------------------------------->
                    <div class="modal fade" id="editExpense">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-primary">Edit Expense</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="">
                                        <input type='hidden' id='editExpenseID' name='editExpenseID' value = ""/>
                                        
                                        <label>Expense Type: <select id="editExpenseType">
                                            <option disabled selected value>-- Select Category --</option>
                                            <option value="1">Travel</option>
                                            <option value="2">Client Meetings</option>
                                            <option value="3">Office Supplies</option>
                                            <option value="4">Other</option>
                                        </select>
                                        </label>
                                        <br>
                                        <label>Amount: <input type="number" class="form-control my-2" step="0.01" min=0 id="editExpenseAmount"></label>
                                        <br>
                                        <label>Expense Date: <input type="date" class="form-control my-2" id="editExpenseOn"></label>
                                        <br>
                                        <label>Merchant: <input type="text" class="form-control my-2" id="editMerchant"></label>
                                        <br>
                                        <label>Details: <input type="text" class="form-control my-2" size="150" id="editExpenseDetails"></label>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" onclick="editRecord();">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--################################################################################################################################-->

                </main>

            </div>
        </div>
    </body>

</html>