$(document).ready(function(){
    
    insertRecord();
    getExpenseDetails();
    editRecord();
    deleteExpense();


});

function insertRecord(){
    var employeeID = document.getElementById("employeeID").value;
    var expenseType = $('#expenseType').val();
    var expenseAmount = $('#expenseAmount').val();
    var expenseOn = $('#expenseOn').val();
    var merchant = $('#merchant').val();
    var expenseDetails = $('#expenseDetails').val();

    if(expenseType === "" || expenseAmount === "" || expenseOn === "" || merchant === "" || expenseDetails === ""){
        $('#fEmptyMessage').html('Please fill in the blanks');
    }

    else{
        $.ajax({
            url: '../backend/employee_functions.php',
            method: 'POST',
            data:{
                employeeID:employeeID,
                expType:expenseType, 
                expAmount:expenseAmount, 
                expOn:expenseOn, 
                merchant:merchant, 
                expDetails:expenseDetails
            },
            success: function(data, status){
                //updateDiv();
                $('form').trigger('reset');
                $('#addExpense'). modal('hide');
                window.location.reload();
            }
        })
    }

}

function getExpenseDetails(){

    $(document).on('click','#btn_edit',function(){
        var ID = $(this).attr('data-id');
        console.log(ID);
        $.ajax(
        {
            url: '../backend/employee_functions.php',
            method: 'post',
            data:{expenseID:ID},
            dataType: 'JSON',
            success: function(data)
            {
                $('#editExpenseID').val(data[0]);
                $('#editExpenseType').val(data[1]);
                $('#editExpenseAmount').val(data[2]);
                $('#editExpenseOn').val(data[3]);
                $('#editMerchant').val(data[4]);
                $('#editExpenseDetails').val(data[5]);

                $('#editExpense'). modal('show');
                
            }
            
        })
    })
}

function editRecord(){
    var updateExpenseID = document.getElementById("editExpenseID").value;
    var updateExpenseType = $('#editExpenseType').val();
    var updateExpenseAmount = $('#editExpenseAmount').val();
    var updateExpenseOn = $('#editExpenseOn').val();
    var updateMerchant = $('#editMerchant').val();
    var updateExpenseDetails = $('#editExpenseDetails').val();

    if(updateExpenseType == "" || updateExpenseAmount == "" || updateExpenseOn == "" || updateMerchant == "" || updateExpenseDetails== ""){
        $('#fEmptyMessage').html('Please fill in the blanks');
    }

    else{
        $.ajax({
            url: '../backend/employee_functions.php',
            method: 'POST',
            data:{
                updateExpenseID:updateExpenseID,
                updateExpenseType:updateExpenseType, 
                updateExpenseAmount:updateExpenseAmount, 
                updateExpenseOn:updateExpenseOn, 
                updateMerchant:updateMerchant, 
                updateExpenseDetails:updateExpenseDetails,
            },
            success: function(data, status){
                
                $('form').trigger('reset');
                $('#editExpense'). modal('hide');
                window.location.reload();

            }
        })
    }
}

function deleteExpense(){
    
    $(document).on('click','#deleteBtn',function(){
        if(confirm("Are you sure you want to delete this expense?")){
            
            var expense_ID = $(this).attr('data-id');
        
            $.ajax({
                url: '../backend/employee_functions.php',
                method: 'POST',
                data:{
                    expense_ID:expense_ID,
                },
                success: function(data, status){
                    console.log(data);
                    window.location.reload();
                }
            })
    
        }
        else{
            //do nothing
        }
    })
}