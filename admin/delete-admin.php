<?php 
 
  //include constants.php file here

  include('../config/constants.php');

   
  // 1, get the ID of Admin to be deleted

  $id =  $_GET['id'];


  //2. Create SQL Query to Delete Admin

  $sql = "DELETE FROM tbl_admin WHERE ID=$id";

  //Executed the query
  $res = mysqli_query($conn, $sql);

  // Check whether the query executed successfully or not
  if($res==true){
    //Query Executed Successfully and Admin Deleted
    //echo "Admin Deleted";
    // Create SEssion variable to Display Message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
    //Redirect to Manage Admin Page
    header('location:'.SITEURL.'admin/manage-admin.php');
  }
  else{
    // Failed to delete admin
    //echo "Failed to delete";
    $_SESSION['delete'] = "<div class='error'>Failed to  Delete Admin. Try Again Later.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
  }

  //3.Redirect to Manage Admin page with message(success/error)

?>