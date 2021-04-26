<?php 
session_start();
$row = false;
$num_user = 0;
$result = false;
$Userdata = '';
$usernameExists = false;
$emailExists = false;
$dataupdated = false;
if(!isset($_SESSION['loggedin']) ||$_SESSION['loggedin']!= true ){
    header('location: login.php');
    exit;
}
else{
include 'partials/_dbconnect.php';
 $username = $_GET['user'];
 $sql = "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` = '$username')";
 $result = mysqli_query($conn,$sql);
 $num_user = mysqli_num_rows($result);
 $Userdata = mysqli_fetch_assoc($result);
 $userid = $Userdata['id'];
}
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    include 'partials/_dbconnect.php';
    $username = $_POST['username'];
    $email = $_POST['email'];

    if($usernameExists == false && $username != $Userdata['username']){
        $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            $usernameExists = 'username already taken please try another username';
        }
        }
    
        if($emailExists == false && $email != $Userdata['email']){
            $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0){
                $emailExists = 'email already taken please try another email';
            }
            }
        if($usernameExists == false && $emailExists == false){
            $userid = $Userdata['id'];
            $sql = "UPDATE `users` SET `username` = '$username',`email` = '$email' WHERE `id` = $userid ";
        $result = mysqli_query($conn, $sql);
       
        if($result){
            
            $dataupdated = true;
            header('location: edituserdetails.php?user='.$_GET['user']);
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
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" href="Css/personaldetails.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

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
<?php 
if ($usernameExists != false){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> Username already taken.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}

if ($emailExists != false){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> Email address already taken.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}


if ($dataupdated){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Data Updated!</strong> You should be able to goto next page now.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}

?>
    <form class="personaldetails my-5" action="" method="POST">
   
        <h3 class="text-center mb-3">User Details</h3>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <?php 
            echo '<input type="text" class="form-control" id="username" aria-describedby="username" name="username" placeholder="Username" value ="'.$_GET['user'].'" required>';
            ?>
        </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
            </div>
            <?php 
            echo '<input type="text" class="form-control" id="email" aria-describedby="email" name="email" placeholder="Email" value ="'.$Userdata['email'].'" required>';
            ?>
            </div>
        </div>
        <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>