<?php
include './database/config.php';

$did = $_GET['cause_id'];

  $query = "DELETE FROM causes WHERE cause_id='$did'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {   

    echo "<script> 
    alert('Donner has been Deleted.');
    window.location.href='donner_cause.php';
    </script>";
    

  }else{
    echo "<script>alert('Cannot Delete Donner');
      window.location.href='donner_cause.php';
      </script>";
  }
?>