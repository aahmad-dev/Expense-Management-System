<?php   //manager functions.php
        //Ammar Ahmad

    require_once '../html/login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    
    extract($_POST);


//EDIT BUDGETS
    if (isset($_POST['totalBudget'])   &&
    isset($_POST['clientMeetingBudget'])    &&
    isset($_POST['travelBudget']) &&
    isset($_POST['suppliesBudget'])     &&
    isset($_POST['otherBudget']))
    {
    
        $stmt = $conn->prepare("UPDATE managers SET `totalBudget` = ?, `clientMeetingBudget` = ?, `travelBudget`= ?, `suppliesBudget` = ?, `otherBudget` = ? 
                                    WHERE `managerID` = '1'; ");
        $stmt->bind_param("sssss", $totalBudget, $clientMeetingBudget, $travelBudget, $suppliesBudget, $otherBudget); 
        $stmt->execute();
        $stmt->close();
        header("location:../html/finance-management.php");
    }


//INSERT EMPLOYEE
    if (isset($_POST['firstName'])   &&
    isset($_POST['lastName'])    &&
    isset($_POST['occupation']) &&
    isset($_POST['empBudget']))
    {

        $stmt = $conn->prepare("INSERT INTO `employees`(`firstName`, `lastName`, `occupation`, `budget`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $occupation, $empBudget); 
        $stmt->execute();
        $stmt->close();
    }

//GET EMPLOYEE DETAILS
    if(isset($_POST['employeeID'])){

        $query = "SELECT * FROM `employees` WHERE `employeeID`='$employeeID' ";
        $result = mysqli_query($conn, $query);

        while($row=mysqli_fetch_assoc($result))
        {
            $employeeData[] = "";
            $employeeData[0]=$row['employeeID'];
            $employeeData[1]=$row['firstName'];
            $employeeData[2]=$row['lastName'];
            $employeeData[3]=$row['occupation'];
            $employeeData[4]=$row['budget'];
            
        }
        echo json_encode($employeeData);
    }

//UPDATE EMPLOYEE
if (isset($_POST['updateEmployeeID'])   &&
isset($_POST['updateFirstName'])    &&
isset($_POST['updateLastName'])    &&
isset($_POST['updateOccupation']) &&
isset($_POST['updateEmpBudget']))
    {
        $updateStmt = $conn->prepare("UPDATE `employees` SET `firstName`= ?,`lastName`= ?,`occupation`= ?,`budget`= ? WHERE `employeeID` = ?;");
        $updateStmt->bind_param("sssss", $updateFirstName, $updateLastName, $updateOccupation, $updateEmpBudget, $updateEmployeeID); 
        $updateStmt->execute();
        $updateStmt->close();
    }

//DELETE EMPLOYEE
    if(isset($_POST['employee_ID'])){
        $deleteQuery = "DELETE FROM employees WHERE employeeID=$employee_ID";
        $result = mysqli_query($conn, $deleteQuery);

    }
?>