<?php
session_start();
$msg = "";
$css_class = "";
$Userdata = '';
$num_user = 0;
if(!isset($_SESSION['loggedin']) ||$_SESSION['loggedin']!= true ){
    header('location: login.php');
    exit;
}

if (isset($_POST['updatepic'])) {
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` = '$username')";
    $result = mysqli_query($conn,$sql);
    $num_user = mysqli_num_rows($result);
    $Userdata = mysqli_fetch_assoc($result);
    $userid = $Userdata['id'];
    $sql = "SELECT * FROM `profilepic` WHERE `id` = $userid";
    $result = mysqli_query($conn,$sql);
    $Userdata = mysqli_fetch_assoc($result);
    $num = mysqli_num_rows($result);

    // Profile pic checking
    
    $profilepic = time() . '_' . $_FILES['profileImage']['name'];
    $target = 'images/' . $profilepic;
    if ($num == 0){
    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)) {
        $sql = "INSERT INTO `profilepic` (`id`,`profilepic`) VALUES 
        ($userid,'$profilepic')";
        if(mysqli_query($conn,$sql)){
        $msg = 'Profile pic updated in db';
        $css_class = "alert-success";
        header('location: userprofile.php');
        }
        else{
            $msg = 'Failed to Update Profile pic in db';
            $css_class = "alert-danger";
        }

    } else {
        $msg = 'Failed to Update Profile pic';
        $css_class = "alert-danger";
    }
    
}
else{
 if(move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)){
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` = '$username')";
    $result = mysqli_query($conn,$sql);
    $num_user = mysqli_num_rows($result);
    $Userdata = mysqli_fetch_assoc($result);
    $userid = $Userdata['id'];
    $sql = "UPDATE `profilepic` SET `profilepic`=  '$profilepic'";
    if(mysqli_query($conn,$sql)){
        header('location: userprofile.php');
    }
 }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-2">
        <a class="navbar-brand" href="testdashboard.php">Nettantra</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
           
            <li class="nav-item float-right">
              <a class="nav-link" href="logout.php">Log out</a>
            </li>
          </ul>
         
        </div>
      </nav>
    <div class="container">
        <div class="row">
            <div class="col-4 offset-md-4 form-div">
                <form action="profilepic.php" method="post" enctype="multipart/form-data">
                    <?php if(!empty($msg))?> 
                    <div class="alert <?php echo $css_class?>">
                    <?php echo $msg?>
                    </div>
                    <div class="form-group">
                        <label for="profileImage">Profile Image</label>
                        <input type="file" name="profileImage" id="profileImage" class="form-control">
                    </div>
                    <div class="form-group">
                    <small>Only JPEG format</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="updatepic" class="btn btn-primary btn-block">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>