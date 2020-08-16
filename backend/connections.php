<?php 
    $conn = new mysqli('localhost', 'ahmad12k_emsys', 'mypassword123', 'ahmad12k_emsys');
    if ($conn->connect_error) die('Sorry, there seems to be an issue on our end. Check back again later.'.mysqli_error());
?>