<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>update category</h1>

        <br><br>

        <?php 
        //check whethr the id is set or not

        if(isset($_GET['id'])){
            //get the Id and all other details
            //echo "Getting the data";

            $id = $_GET['id'];
            // create sql query to get all other details

            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            // count the rows to cheque whether the id is value or not
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                //get the all data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                //redirect to manage category with session message
                $_SESSION['no-category-found'] = "<div class='error'>Ctegory not Found</div>";
                header('location:' .SITEURL. 'admin/manage=category.php');
            }


        }
        else{
            //redirect the manage category
            header('location:' .SITEURL. 'admin/manage-category.php');
        }
        
        ?>

        <form action="" Method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php 
                    if($current_image != "")
                    {
                        //display the image
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                        <?php
                    }
                    else
                    {
                        //display message
                        echo "<div class='error'>image not Added</div>";
                    }
                    
                    
                    ?>
                </td>
            </tr>

            <tr>
                <td>New image: </td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes

                    <input <?php if($featured=="no"){echo "checked";} ?> type="radio" name="featured" value="No">no
                </td>
            </tr>

            <tr>
                <td>Avtive: </td>
                <td>
                    <input <?php if($active=="yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="no"){echo "checked";} ?> type="radio" name="active" value="No">no
                </td>
            </tr>

            <tr>

                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <?php 

        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //1.get all the values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2.Updating new image if selected

            //Check whether the image is selected or not
            if(isset($_FILES['image']['name']))
            {
                //get the image details
                $image_name = $_FILES['image']['name'];

                //check whether the image is available or not
                if($image_name != "")
                {
                    //image availble
                    //A.upload the new image
                    //Auto rename our image
                //get the extention of our image (jpg, png, gif, etc) e.g. "food1.jpg"
                $ext = end(explode('.',$image_name));

                //rename the image
                $image_name = "food_Category_".rand(000, 999).'.'.$ext;
                

                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../images/category/".$image_name;

                //finally upload the image

                $upload = move_uploaded_file($source_path, $destination_path);

                //check whether the image is uploaded or not
                //And if the image is not upload these we will stop the process and redirect with error message
                if($upload==false){
                    //set image
                    $_SESSION['upload'] = "<div class='error'>Failedto upload image.</div>";
                    //redirect to add category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                    //stop the process
                    die();
                }


                    //B.remove the current image if availabe
                    if($current_image !="")
                    {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);
    
                        //check whether the image is removedor not
    
                        //if failed to remove the display message and stop the process
    
                        if($remove==false)
                        {
                            //failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();//stop the process
                        }
                    }
                   


                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            //3.update the database
            $sql2 = "UPDATE tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id
            ";

            //execute the query
            $res2 = mysqli_query($conn, $sql2);

            //4.rederect to manage category
            //check whether executed or not
            if($res2==true)
            {
                //category updated
                $_SESSION['update'] = "<div class='success'>Category updated Successfully.</div>";
                header('location:' .SITEURL. 'admin/manage-category.php');
            }
            else
            {
                //failed to update category
                $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
                header('location:' .SITEURL. 'admin/manage-category.php');
            }

            
        }

        ?>



    </div>
</div>

<?php include('partials/footer.php'); ?>