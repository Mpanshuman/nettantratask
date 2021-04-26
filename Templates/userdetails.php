<?php 
session_start();
$row = false;
$num = 0;
$result = false;
$Userdata = '';
$Userdetails = '';
$userPhone = false;
$dataupdated = false;
$datainserted = false;

if(!isset($_SESSION['loggedin']) ||$_SESSION['loggedin']!= true ){
    header('location: login.php');
    exit;
}
else{
include 'partials/_dbconnect.php';
 $username = $_SESSION['username'];
 $sql = "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` = '$username')";
 $result = mysqli_query($conn,$sql);
 $num_user = mysqli_num_rows($result);
 $Userdata = mysqli_fetch_assoc($result);
 $userid = $Userdata['id'];
 $sql = "SELECT * FROM `userdetails` WHERE `id` = $userid";
 $result = mysqli_query($conn,$sql);
 $Userdetails = mysqli_fetch_assoc($result);
 $num = mysqli_num_rows($result);
 
}
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    include 'partials/_dbconnect.php';
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    if($userPhone == false && $phone != $Userdetails['phone']){

        $sql = "SELECT * FROM `userdetails` WHERE `phone` = '$phone'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            $usernameExists = 'Phone already taken please try another username';
        }
        }
    
        if($userPhone == false){
            if($num > 0){
            $userid = $Userdata['id'];
            $sql = "UPDATE `userdetails` SET `firstname` = '$firstname',`middlename` = '$middlename',`lastname` = '$lastname',`phone` ='$phone',`dob`='$dob',`gender`='$gender'  WHERE `id` = $userid ";
            $result = mysqli_query($conn, $sql);
       
        if($result){
            
            $dataupdated = true;
            header('location: userprofile.php');
            
        }
    }
        else{
            $userid =(int)$Userdata['id'] ;
        $sql = "INSERT INTO `userdetails` (`id`,`firstname`,`middlename`,`lastname`,`phone`,`dob`,`gender`) VALUES 
        ($userid,'$firstname','$middlename','$lastname','$phone','$dob','$gender')";
        $result = mysqli_query($conn, $sql);
        if($result){
            $datainserted = true;
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
              <a class="nav-link" href="userprofile.php">Profile</a>
            </li>
            <li class="nav-item float-right">
              <a class="nav-link" href="logout.php">Log out</a>
            </li>
          </ul>
         
        </div>
      </nav>
<?php 
if ($userPhone != false){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> Phone number already taken.
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
if ($datainserted){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Data Inserted!</strong> You should be able to login now.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}
?>
    <form class="personaldetails my-5" action="" method="POST">
    
        <h3 class="text-center mb-3">Personal Details</h3>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <?php
            if($num > 0){
                
            echo '<input type="text" class="form-control" id="firstname" aria-describedby="firstname" name="firstname" placeholder="Firstname" value ="'.$Userdetails['firstname'].'" required>';
        }else{
            
            echo '<input type="text" class="form-control" id="firstname" aria-describedby="firstname" name="firstname" placeholder="Firstename" required>';
        }
            ?>
            </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div><?php
            if($num > 0){
            echo '<input type="text" class="form-control" id="middlename" aria-describedby="middlename" name="middlename" placeholder="Middlename" value ="'.$Userdetails['middlename'].'">';
        }else{
            echo '<input type="text" class="form-control" id="middlename" aria-describedby="middlename" name="middlename" placeholder="Middlename" >';
        }
            ?></div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div><?php
            if($num > 0){
            echo '<input type="text" class="form-control" id="lastname" aria-describedby="lastname" name="lastname" placeholder="Lastname" value ="'.$Userdetails['lastname'].'" required>';
        }else{
            echo '<input type="text" class="form-control" id="lastname" aria-describedby="lastname" name="lastname" placeholder="Lastname" required>';
        }
            ?></div>


        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-phone"></i></span>
            </div><?php
            if($num > 0){
            echo '<input type="tel" class="form-control" id="phone" aria-describedby="phone" name="phone" placeholder="Phone" pattern="[0-9]{10}" value ="'.$Userdetails['phone'].'" required>';
        }else{
            echo '<input type="tel" class="form-control" id="phone" aria-describedby="phone" name="phone" placeholder="Phone" pattern="[0-9]{10}" required>';
        }
            ?></div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div><?php
            if($num > 0){
            echo '<input type="date" class="form-control" id="dob" aria-describedby="dob" name="dob" placeholder="Date of birth" value ="'.$Userdetails['dob'].'" required>';
        }else{
            echo '<input type="date" class="form-control" id="dob" aria-describedby="dob" name="dob" placeholder="Date of birth" required>';
        }
            ?></div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
            </div>
            <select class="form-control" id="sel1" name='gender'>
                <option value="" selected disabled hidden>Choose here</option>
                <option value="Male" <?php if ($Userdetails['gender'] == 'Male') echo 'selected="selected"';?>>Male</option>
                <option value="Female" <?php if ($Userdetails['gender'] == 'Female') echo 'selected="selected"';?>>Female</option>
                <option value="Others" <?php if ($Userdetails['gender'] == 'Others') echo 'selected="selected"';?>>Others</option>
            </select>
        </div>
        <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>