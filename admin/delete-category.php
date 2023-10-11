<?php 

include('../config/constants.php');

if(isset($_GET['id']) AND isset($_GET['image_name']))
{
   //echo "Get value and delete"; 
   $id = $_GET['id'];
   $image_name = $_GET['image_name'];

   //remove the physical image file is available

   if($image_name != ""){

    //image is available . so remove it
    $path = "../images/category/".$image_name;

    //remove the image
    $remove = unlink($path);
    //

    if($remove==false)
    {
        $_SESSION['remove'] = "<div class='error'>failed to remove category image.</div>";
        //redirect to manage category page

        header('location:'.SITEURL.'admin/manage-category.php');
        //stop the process
        die();
    }
   }

   //delete data from database

   $sql = "DELETE FROM tbl_category WHERE id=$id";
   $res = mysqli_query($conn, $sql);

   if($res==true){
    $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
    header('location:'.SITEURL.'admin/manage-category.php');
   }
   else
   {
    $_SESSION['delete'] = "<div class='error'>Failed to delete category.</div>";
    header('location:'.SITEURL.'admin/manage-category.php');

   }

   //redirect to manage category page with message
}
else
{
   header('location:'.SITEURL.'admin/manage-category.php');
}

?>