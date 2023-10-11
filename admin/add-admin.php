<?php include('partials/menu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
                if(isset($_SESSION['add']))//Checking  whether the Session is set or not
                {
                    echo $_SESSION['add']; //Displaying Session Message
                    unset ($_SESSION['add']); //Removing Session Message
                }
            
            ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter Your Name">
                </td>
            </tr>

            <tr>
                <td>Username: </td>
                <td>
                    <input type="text" name="username" placeholder="Your Username">
                </td>
            </tr>

            <tr>
                <td>Password: </td>
                <td>
                    <input type="password" name="password" placeholder="Your Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>
        </table>



        </form>
    </div>
</div>


<?php include('partials/footer.php'); ?>

<?php 
     //Process the value from Form and Save it in Database

     //Check whether the submit button is clicked or not

     if(isset($_POST['submit'])){
        // Button Clicked
        //echo "Button clicked";`                                           

        //1. the data from Form
        //$full_name = $_POST['full_name'];//old
        //$username = $_POST['username'];//old

        // $password = md5($_POST['password']); // old//Password Encryption with MDS



        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password= md5($_POST['password']);
        $password= mysqli_real_escape_string($conn, $raw_password);


        //2. sql Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
                full_name='$full_name',
                username='$username',
                password='$password'
                ";
        
        //3. Executing query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE){
            // Data Inserted
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "Admin Added Successfully";
            //Redirect Page To manage admin page
            header("location:".SITEURL.'admin/manage-admin.php');
            
        }
        else{
            // Failed to Insert Data
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "Failed to Add Admin";
            //Redirect Page To Add admin page
            header("location:".SITEURL.'admin/manage-admin.php');
            
        }
     }
     
?>