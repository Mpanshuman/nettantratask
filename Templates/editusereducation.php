<?php
session_start();
$datainserted = false;
$dataupdated = false;
$Userdata = '';

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
     $sql = "SELECT * FROM `educationdetails` WHERE `id` = $userid";
     $result = mysqli_query($conn,$sql);
     $Userdetails = mysqli_fetch_assoc($result);
     $num = mysqli_num_rows($result);
     
    }

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    include 'partials/_dbconnect.php';
    $schoolname = $_POST['schoolname'];
    $tenthmarkcat = $_POST['tenthmarkcat'];
    $tenthmark = '';
    $twthmark = '';
    if ($tenthmarkcat == 'CGPA'){
        $tenthmark = $_POST['tenthmarkc'];
    }
    else{
        $tenthmark = $_POST['tenthmarkp']; 
    }
    // $tenthmark = $_POST['tenthmark'];
    $twthmarkcat = $_POST['twthmarkcat'];
    if ($twthmarkcat  == 'CGPA'){
        $twthmark  = $_POST['twmarkc'];
    }
    else{
        $twthmark = $_POST['twmarkp']; 
    }
    $clgname = $_POST['clgname'];
    $uniname = $_POST['uniname'];
    $unimark = $_POST['unimark'];

    if($num > 0){
        $userid = $Userdata['id'];
        $sql = "UPDATE `educationdetails` SET `schoolname` = '$schoolname',`tenthmarkcategory` = '$tenthmarkcat',`tenthmark` = '$tenthmark',`collegename` ='$clgname',`twthmarkcategory`='$twthmarkcat',`twthmark`='$twthmark',`universityname`='$uniname',`unicgoa`='$unimark'  WHERE `id` = $userid ";
        $result = mysqli_query($conn, $sql);
   
    if($result){
        
        $dataupdated = true;
        header('location: testdashboard.php');
        
    }
}

else{
    $userid =(int)$Userdata['id'] ;
$sql = "INSERT INTO `educationdetails` (`id`,`schoolname`,`tenthmarkcategory`,`tenthmark`,`collegename`,`twthmarkcategory`,`twthmark`,`universityname`,`unicgoa`) VALUES 
($userid,'$schoolname','$tenthmarkcat','$tenthmark','$clgname','$twthmarkcat','$twthmark','$uniname','$unimark')";
$result = mysqli_query($conn, $sql);
if($result){
    $datainserted = true;
    header('location: testdashboard.php');
   
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
    <form class="personaldetails my-5" action="" method="POST">
        <h3 class="text-center mb-3">Education Details</h3>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-school"></i></span>
            </div>
            <?php 
            if($num > 0){
            echo '<input type="text" class="form-control" id="schoolname" aria-describedby="schoolname" name="schoolname" placeholder="School Name" value ="'.$Userdetails['schoolname'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="schoolname" aria-describedby="schoolname" name="schoolname" placeholder="School Name" required>';    
            }
            ?>
            </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <select class="form-control" id="tenthmarkdropdown" name="tenthmarkcat">
                <option value="" selected disabled hidden>Mark in 10th</option>
                <option value="CGPA" <?php if ($Userdetails['tenthmarkcategory'] == 'CGPA') echo 'selected="selected"';?>>CGPA</option>
                <option value="Perc" <?php if ($Userdetails['tenthmarkcategory'] == 'Perc') echo 'selected="selected"';?>>Perc</option>
            </select>
        </div>


        <div class="input-group form-group" id="otherFieldGroupDivcten">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <?php 
            if($num > 0){
            echo '<input type="text" class="form-control" id="tenthmark" aria-describedby="tenthmark" name="tenthmarkc" placeholder="CGPA" value ="'.$Userdetails['tenthmark'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="tenthmark" aria-describedby="tenthmark" name="tenthmarkc" placeholder="CGPA" required>';  
            }?>
            </div>

        <div class="input-group form-group" id="otherFieldGroupDivpten">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <?php 
            if($num > 0){
            echo '<input type="text" class="form-control" id="tenthmark" aria-describedby="tenthmark" name="tenthmarkp" placeholder="Perc(%)" value ="'.$Userdetails['tenthmark'].'" required>';
            }else{
                echo '<input type="text" class="form-control" id="tenthmark" aria-describedby="tenthmark" name="tenthmarkp" placeholder="Perc(%)" required>';
            }?>
        </div>

        <div class="input-group form-group" >
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-school"></i></span>
            </div>
            <?php 
            if($num > 0){

            echo '<input type="text" class="form-control" id="clgname" aria-describedby="clgname" name="clgname" placeholder="College Name" value ="'.$Userdetails['collegename'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="clgname" aria-describedby="clgname" name="clgname" placeholder="College Name" required>';    
            }
           ?>
        </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <select class="form-control" id="twmarkdropdown" name="twthmarkcat">
                <option value="" selected disabled hidden>Mark in 12th</option>
                <option value="CGPA" <?php if ($Userdetails['twthmarkcategory'] == 'CGPA') echo 'selected="selected"';?>>CGPA</option>
                <option value="Perc" <?php if ($Userdetails['twthmarkcategory'] == 'Perc') echo 'selected="selected"';?>>Perc</option>
            </select>
        </div>


        <div class="input-group form-group" id="twmarkcgpa">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <?php 
            if($num > 0){

            echo '<input type="text" class="form-control" id="twmark" aria-describedby="twmark" name="twmarkc" placeholder="CGPA" value ="'.$Userdetails['twthmark'].'" required>';
            }else{
                echo '<input type="text" class="form-control" id="twmark" aria-describedby="twmark" name="twmarkc" placeholder="CGPA" required>';
            }?>
        </div>

        <div class="input-group form-group" id="twmarkperc">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <?php 
            if($num > 0){
            echo '<input type="text" class="form-control" id="twmark" aria-describedby="twmark" name="twmarkp" placeholder="Perc" value ="'.$Userdetails['twthmark'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="twmark" aria-describedby="twmark" name="twmarkp" placeholder="Perc" required>';
            }?>
        </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
            </div>
            <?php 
            if($num > 0){
            echo '<input type="text" class="form-control" id="uniname" aria-describedby="uniname" name="uniname" placeholder="University Name" value ="'.$Userdetails['universityname'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="uniname" aria-describedby="uniname" name="uniname" placeholder="University Name" required>';  
            }
            ?></div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <?php 
            if($num > 0){
            echo '<input type="text" class="form-control" id="unimark" aria-describedby="unimark" name="unimark" placeholder="University CGPA" value ="'.$Userdetails['unicgoa'].'" required>';
            }
            else{
                echo '<input type="text" class="form-control" id="unimark" aria-describedby="unimark" name="unimark" placeholder="University CGPA" required>';
            }?>
        </div>

        
        <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="JS/educationdetails.js"></script>
</body>

</html>