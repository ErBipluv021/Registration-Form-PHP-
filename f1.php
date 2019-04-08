<?php
session_start();
$_SESSION['message'] = '';
$mysqli = new mysqli('localhost','root','','accounts');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['password'] == $_POST['confirmpassword'])
    {
        
        
        $username = $mysqli->real_escape_string($_POST['username']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = md5($_POST['password']);
        $avatar_path = $mysqli->real_escape_string('images/'.$_FILES['avatar']['name']);
        
        //make sure file type is image
        if(preg_match("!image!",$_FILES['avatar']['type'])) {
            //copy image to images/folder
            if(copy($_FILES['avatar']['tmp_name'],$avatar_path)){
                $_SESSION['username'] = $username;
                $_SESSION['avatar'] = $avatar_path;
                
                $sql = "INSERT INTO user (username, email, password, avatar)" 
                    ."VALUES ('$username','$email','$password','$avatar_path')";
                
                if($mysqli->query($sql) == true) {
                    $_SESSION['message'] = "Registration successful! Added $username to the database";
                    header("location: welcome.php");
                }
                else
                {
                    $_SESSION['message'] = "User couldnt be added";
                    
                }
            }
            else
            {
                $_SESSION['message'] = "File upload failed!";
            }
            
        }else
        {
            $_SESSION['message'] = 'Please only upload gif,jepg';
        }
    }else{
        $_SESSION['message'] = "Two Password do not match";
    }
}
?>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="form.css" type="text/css">
<div class="body-content">
 <div class = "module">
    <h1>Freelancer Registration</h1>
    <form class="form" action="f1.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message']?></div>
        Name: <input type="text"  name="username" required />
       Email:<input type="email"  name="email" required />
         Password:<input type="password" name="password" autocomplete="new-password" required />
      Re-enter:<input type="password" name="confirmpassword" autocomplete="new-password" required />
         Date of Birth: <input type="date"  name="dob" required /><br/>
        Contact No.:<input type="text"  name="contact" required />
        Position:<input type="text" name="post" required />
        
        Citizenship No.:<input type = "text" name="citizenship" maxlength="15"  required/>

        <div class = "avatar"><label>Citizenship Upload:</label><input type = "file" name = "avatar" required /></div>
   
       <label>Register As:</label> <select name = "register">
        <option value = "NULL">--Select One of Them</option>    
        <option value = "Client">Client</option>
        <option value = "Freelancer">Freelancer</option>
        <option value = "Reviewer">Reviewer</option>
        <option value = "Traniee">Trainee</option>
        <option value = "Trainer">Trainer</option>
        </select>
        Esewa Account: <input type = "text" name="esewa" maxlength="12" required />   
     
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
        </div>
</div>