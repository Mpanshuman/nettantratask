<?php 
session_start();
$row = false;
$num = 0;
$result = false;
$Userdata = '';
$Userdetails = '';
$fatherPhone = false;
$motherPhone = false; 
$dataupdated = false;
$datainserted = false;

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
 $sql = "SELECT * FROM `addressdetails` WHERE `id` = $userid";
 $result = mysqli_query($conn,$sql);
 $Userdetails = mysqli_fetch_assoc($result);
 $num = mysqli_num_rows($result);
 
}
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    include 'partials/_dbconnect.php';
    $fathername = $_POST['fathername'];
    $mothername = $_POST['mothername'];
    $fatherphone = $_POST['fatherphone'];
    $motherphone = $_POST['motherphone'];
    $presentaddress = $_POST['presentaddress'];
    $permanentaddress = $_POST['permanentaddress'];
    if($fatherPhone == false && $fatherphone != $Userdetails['fatherphone']){

        $sql = "SELECT * FROM `addressdetails` WHERE `fatherphone` = '$fatherphone'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            $fatherPhone = 'Fathers Phone number already taken please try another phone number';
        }
        }

        if($motherPhone == false && $motherphone != $Userdetails['motherphone']){

            $sql = "SELECT * FROM `addressdetails` WHERE `motherphone` = '$motherphone'";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0){
                $motherPhone = 'Mothers Phone number already taken please try another phone number';
            }
            }
    
        if($motherPhone == false && $fatherPhone == false){
            if($num > 0){
            $userid = $Userdata['id'];
            $sql = "UPDATE `addressdetails` SET `fathername` = '$fathername',`mothername` = '$mothername',`fatherphone` = '$fatherphone',`motherphone` ='$motherphone',`presentaddress`='$presentaddress',`permanentaddress`='$permanentaddress'  WHERE `id` = $userid ";
            $result = mysqli_query($conn, $sql);
       
        if($result){
            
            $dataupdated = true;
            header('location: editusereducation.php?user='.$_GET['user']);
            
        }
       
    }
        else{
            $userid =(int)$Userdata['id'] ;
        $sql = "INSERT INTO `addressdetails` (`id`,`fathername`,`mothername`,`fatherphone`,`motherphone`,`presentaddress`,`permanentaddress`) VALUES 
        ($userid,'$fathername','$mothername','$fatherphone','$motherphone','$presentaddress','$permanentaddress')";
        $result = mysqli_query($conn, $sql);
        if($result){
            $datainserted = true;
            header('location: editusereducation.php?user='.$_GET['user']);
           
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" href="Css/personaldetails.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

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

      <form class="personaldetails my-5" id="personaldetail" action="" method="POST">
    <?php
    if ($fatherPhone != false){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> Fathers phone number already taken.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}

if ($motherPhone != false){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> Mothers phone number already taken.
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
        <h3 class="text-center mb-3">Personal Details</h3>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <?php
            if($num > 0) {
                
            echo '<input type="text" class="form-control" id="fathername" aria-describedby="fathername" name="fathername" placeholder="Fathers name" value ='.$Userdetails['fathername'].' required>';
        }
        else{
            echo '<input type="text" class="form-control" id="fathername" aria-describedby="fathername" name="fathername" placeholder="Fathers name" required>';
        }
        ?>
            </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <?php
            if ($num > 0){
            echo '<input type="text" class="form-control" id="mothername" aria-describedby="mothername" name="mothername" placeholder="Mothers name" value ="'.$Userdetails['mothername'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="mothername" aria-describedby="mothername" name="mothername" placeholder="Mothers name" required>'; 
            }
            ?>
            </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <?php
            if ($num > 0){
            echo '<input type="text" class="form-control" id="fatherphone" aria-describedby="fatherphone" name="fatherphone" placeholder="Fathers Phone" pattern="[0-9]{10}" value ="'.$Userdetails['fatherphone'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="fatherphone" aria-describedby="fatherphone" name="fatherphone" placeholder="Fathers Phone" pattern="[0-9]{10}" required>';
            }
            ?>
            </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <?php
            if ($num > 0){
            echo '<input type="text" class="form-control" id="motherphone" aria-describedby="phone" name="motherphone" placeholder="Mothers Phone" pattern="[0-9]{10}" value ="'.$Userdetails['motherphone'].'" required>';
            } 
            else{
                echo '<input type="text" class="form-control" id="motherphone" aria-describedby="phone" name="motherphone" placeholder="Mothers Phone" pattern="[0-9]{10}" required>';
            }
            ?>
        </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
            </div>
            <?php
            if ($num > 0){
            echo '<textarea form="personaldetail" name="presentaddress" id="preid" cols="100"  placeholder="Present Address" required>'.$Userdetails['presentaddress'].'</textarea>';
            }
            else{
                echo '<textarea form="personaldetail" name="presentaddress" id="preid" cols="100"  placeholder="Present Address" required></textarea>';
            }
            ?>
        </div>


        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
            </div>
            <?php
            if ($num > 0){
            echo '<textarea form="personaldetail" name="permanentaddress" id="perid" cols="100" placeholder="Permanent Address" required>'.$Userdetails['permanentaddress'].'</textarea>';
            }
            else{
                echo '<textarea form="personaldetail" name="permanentaddress" id="perid" cols="100" placeholder="Permanent Address" required></textarea>';
            }
            ?>
        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>