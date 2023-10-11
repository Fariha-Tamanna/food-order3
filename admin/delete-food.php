<?php
//include constants page
include('../config/constants.php');

if(isset($_GET['id']) && isset($_GET['image_name']))// Either use '&& or "AND'
{
    //precess to delete
    // echo "Precess to detele";

    //1.get Id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2.Remove the image if availabe
    if($image_name != "")
    {
        // it has image and need to remove from folder
        //get the image path
        $path = "../images/food/".$image_name;
        //remove image file from folder

        $remove = unlink($path);

        //check whether image is delete or not
        if($remove==false)
        {
            //failed to remove image
            $_SESSION['upload'] = "<div class='error'>Failed to remove image</div>";
            header('location:'.SITEURL. 'admin/manage-food.php');

            //stop the precess
            die();

        }
    }

    //3.delete food from database

    $sql = "DELETE FROM tbl_food WHERE id=$id";
    //Execute the query
    $res = mysqli_query($conn, $sql);

    //check whther the query executed or not and set the session message respectivly
    if($res==true)
    {
        //food deleted
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL. 'admin/manage-food.php');



    }
    else
    {
        //failed to delte food
        $_SESSION['delete'] = "<div class='error'>Failed to Delte Food.</div>";
        header('location:'.SITEURL. 'admin/manage-food.php');
    }

    //4.redirect to manage food with session message
}
else
{
    //Redirect to manage food page
    $_SESSION['unathorize'] = "<div class='error'>Unauthorized Access</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}


?>