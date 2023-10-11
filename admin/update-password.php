<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>


        <?php
        if(isset($_GET['id']))
        {
            $id =$_GET['id'];
        }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>


            </table>


        </form>



    </div>
</div>

<?php

if(isset($_POST['submit'])){
    //echo clicked

    //1.get data from form
    $id=$_POST['id'];
    $current_password=md5($_POST['current_password']);
    $new_password=md5($_POST['new_password']);
    $confirm_password=md5($_POST['confirm_password']);

    // 2.check whether the user with current id and current password Exists or Not
    $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //Execute the query
    $res= mysqli_query($conn, $sql);

    if($res==true){
        //check wether data is available or not
        $count=mysqli_num_rows($res);
        if($count==1)
        {
            // User Exists and Password can be changed
            //echo "User Found";
            //check whether the new password and confirm match or not
            if($new_password==$confirm_password)
            {
                //Update the password

                $sql2 ="UPDATE tbl_admin SET
                password= '$new_password'
                WHERE id=$id
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //check whether the query executed or not
                if($res==true)
                {
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully. </div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
                else
                {
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to Changed Password. </div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }


            }
            else
            {
                $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match. </div>";
                header('location:'.SITEURL.'admin/manage-admin.php');

            }
        }
        else
        {
            //User Does not Exists set message and Redirect
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

    //3.Check whether the New password and confirm password Match or not

    //4. Change Password if all avobe in true


}


?> 

<?php include('partials/footer.php'); ?>