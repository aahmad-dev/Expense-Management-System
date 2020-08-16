<?php   //employee_functons.php
        
    require_once '../html/login.php';
    $conn = new mysqli($hn, $un, $pw, $db);

    //adding expense records
    
    extract($_POST);

//INSERT EXPENSE
    if (isset($_POST['employeeID'])   &&
    isset($_POST['expType'])    &&
    isset($_POST['expAmount']) &&
    isset($_POST['expOn'])     &&
    isset($_POST['merchant'])     &&
    isset($_POST['expDetails']))
    {
    
        $stmt = $conn->prepare("INSERT INTO expenses(expenseType, employee_ID, expenseCost, expenseOn, merchant, expenseDetails) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $expType, $employeeID, $expAmount, $expOn, $merchant, $expDetails); 
        $stmt->execute();
        $stmt->close();
    }

//GET EXPENSE DETAILS
    if(isset($_POST['expenseID'])){

        $query = "SELECT * FROM `expenses` WHERE `expense_ID`='$expenseID'";
        $result = mysqli_query($conn, $query);

        while($row=mysqli_fetch_assoc($result))
        {
            $expenseData[] = "";
            $expenseData[0]=$row['expense_ID'];
            $expenseData[1]=$row['expenseType'];
            $expenseData[2]=$row['expenseCost'];
            $expenseData[3]=$row['expenseOn'];
            $expenseData[4]=$row['merchant'];
            $expenseData[5]=$row['expenseDetails'];
            
        }
        echo json_encode($expenseData);
    }
    
//UPDATE EXPENSE
    if (isset($_POST['updateExpenseID'])   &&
    isset($_POST['updateExpenseType'])    &&
    isset($_POST['updateExpenseAmount']) &&
    isset($_POST['updateExpenseOn'])     &&
    isset($_POST['updateMerchant'])     &&
    isset($_POST['updateExpenseDetails']))
    {
        $updateStmt = $conn->prepare("UPDATE expenses SET `expenseType` = ?, `expenseCost` = ?, `expenseOn`= ?, `merchant` = ?, `expenseDetails` = ? WHERE expense_ID = ?;");
        $updateStmt->bind_param("ssssss", $updateExpenseType, $updateExpenseAmount, $updateExpenseOn, $updateMerchant, $updateExpenseDetails, $updateExpenseID); 
        $updateStmt->execute();
        $updateStmt->close();
    }

//DELETE EXPENSE
    if(isset($_POST['expense_ID'])){
        $deleteQuery = "DELETE FROM expenses WHERE expense_ID='$expense_ID';";
        $result = mysqli_query($conn, $deleteQuery);

    }

?>