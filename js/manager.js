//manager.js
//Ammar Ahmad

$(document).ready(function(){
    
  insertEmployee();
  getEmployeeDetails();
  editEmployee();
  deleteEmployee();
  
});

function insertEmployee(){

  var firstName = $('#firstName').val();
  var lastName = $('#lastName').val();
  var occupation = $('#occupation').val();
  var empBudget = $('#empBudget').val();

  if(firstName === "" || lastName === "" || occupation === "" || empBudget === ""){
      $('#fEmptyMessage').html('Please fill in the blanks');
  }

  else{
      $.ajax({
          url: '../backend/manager_functions.php',
          method: 'POST',
          data:{
            firstName:firstName,
            lastName:lastName,
            occupation:occupation,
            empBudget:empBudget
          },
          success: function(data, status){
              $('form').trigger('reset');
              $('#addEmployee'). modal('hide');
              window.location.reload();
          }
      })
  }

}

function getEmployeeDetails(){

  $(document).on('click','#editBtn',function(){
      var ID = $(this).attr('data-id');
      
      $.ajax(
      {
          url: '../backend/manager_functions.php',
          method: 'POST',
          data:{employeeID:ID},
          dataType: 'JSON',
          success: function(data)
          {
              $('#editEmployeeID').val(data[0])
              $('#editFirstName').val(data[1]);
              $('#editLastName').val(data[2]);
              $('#editOccupation').val(data[3]);
              $('#editEmpBudget').val(data[4]);

              $('#editEmployee'). modal('show');
              
          }
          
      })
  })
}

function editEmployee(){
  var updateEmployeeID = document.getElementById("editEmployeeID").value;
  var updateFirstName = $('#editFirstName').val();
  var updateLastName = $('#editLastName').val();
  var updateOccupation = $('#editOccupation').val();
  var updateEmpBudget = $('#editEmpBudget').val();

  if(updateFirstName === "" || updateLastName === "" || updateOccupation === "" || updateEmpBudget === ""){
      $('#fEmptyMessage').html('Please fill in the blanks');
  }

  else{
      $.ajax({
          url: '../backend/manager_functions.php',
          method: 'POST',
          data:{
            updateEmployeeID:updateEmployeeID,
            updateFirstName:updateFirstName,
            updateLastName:updateLastName,
            updateOccupation:updateOccupation,
            updateEmpBudget:updateEmpBudget
          },
          success: function(data, status){
              $('form').trigger('reset');
              $('#editEmployee'). modal('hide');
              window.location.reload();
          }
      })
  }
}

function deleteEmployee(){
  
  $(document).on('click','#deleteEmpBtn',function(){
      if(confirm("Are you sure you want to delete this employee?")){
          
          var employee_ID = $(this).attr('data-id');
            console.log(employee_ID);
          $.ajax({
              url: '../backend/manager_functions.php',
              method: 'POST',
              data:{
                  employee_ID:employee_ID,
              },
              success: function(data, status){
                  window.location.reload();
              }
          })
  
      }
      else{
          //do nothing
      }
  })
}
