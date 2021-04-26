
<?php
session_start();
$row = false;
$num_user = 0;
$num_userdetails = 0;
$num_useraddress = 0;
$num_userpic = 0;
$result = false;
$Userdata = '';
$Userpic = '';
$Userdetails = '';
$Useraddress = '';
$Educationdetails = '';
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

 // userdetails
 $userdetail = "SELECT * FROM `userdetails` WHERE `id` = $userid";
 $userdetailresult = mysqli_query($conn,$userdetail);
 $num_userdetails = mysqli_num_rows($userdetailresult);

 if($num_userdetails > 0 ){
  $Userdetails = mysqli_fetch_assoc($userdetailresult);
}

 // address details
 $addressdetail = "SELECT * FROM `addressdetails` WHERE `id` = $userid";
 $addressdetailresult = mysqli_query($conn,$addressdetail);
 $num_useraddress = mysqli_num_rows($addressdetailresult);

 if($num_useraddress > 0 ){
  $Useraddress = mysqli_fetch_assoc($addressdetailresult);
}
// education details
$educationdetail = "SELECT * FROM `educationdetails` WHERE `id` = $userid";
$educationdetailresult = mysqli_query($conn,$educationdetail);
$num_education = mysqli_num_rows($educationdetailresult);

 if($num_education > 0 ){
  $Educationdetails = mysqli_fetch_assoc($educationdetailresult);
}
 // user pic
 $profilepic = "SELECT * FROM `profilepic` WHERE `id` = $userid";
 $profilepicresult = mysqli_query($conn,$profilepic);
 $num_userpic = mysqli_num_rows($profilepicresult);

 if($num_userpic > 0 ){

  $Userpicdata= mysqli_fetch_assoc($profilepicresult);
  $Userpic = $Userpicdata['profilepic'];
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
	<link rel="stylesheet" href="Css/userprofile.css">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <title>User Profile</title>
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
          <!-- /Breadcrumb -->
          <div class="container">
    <div class="main-body">
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                  <?php
                  if ($Userpic == ''){
                    echo "<img src='https://bootdey.com/img/Content/avatar/avatar7.png' alt='Admin' class='rounded-circle' width='150'>";
                    
                  }else{
                    echo "<img src=images/$Userpic alt='Admin' class='rounded-circle' width='150'>";
                    
                  }

                     if($num_userdetails > 0){
                    echo "<div class='mt-3'>";
                    echo "<h4>".$Userdetails['firstname']."</h4>";
                     }
                     else{
                      echo "<div class='mt-3'>";
                      echo "<h4>Update Profile</h4>";
                       }
                     
                     ?>
                      <?php
                      
                      echo "<p class='text-secondary mb-1'>@".$Userdata['username']."</p>";
                      echo "<p class='text-muted font-size-sm'>".$Userdata['email']."</p>";
                      
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <?php 
                    if($num_userdetails > 0){
                    echo '<div class="col-sm-9 text-secondary">';
                    echo  $Userdetails['firstname'].' '.$Userdetails['middlename'].' '.$Userdetails['lastname'];
                    echo '</div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      '.$Userdata['email'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Userdetails['phone'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Date of Birth</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Userdetails['dob'].'
                    </div>
                  </div>
                  <hr>
                  ';}
                  else{
                    echo '<div class="col-sm-9 text-secondary">';
                    echo  'Update Profile';
                    echo '</div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Date of Birth</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  ';

                  }
                  if ($num_useraddress > 0){
                  echo '<div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      '.$Useraddress['permanentaddress'].'';
                  }
                  else{
                    echo '<div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile';
                  }
                    
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3 text">Address Details</h6> 
                      <?php
                      if($num_useraddress > 0){
                      echo '
                      <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">FN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      '.$Useraddress['fathername'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">MN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Useraddress['mothername'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">FP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Useraddress['fatherphone'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">MP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Useraddress['motherphone'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">PA</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Useraddress['presentaddress'].'
                    </div>
                  </div>
                  <hr>
                    </div>
                  </div>
                </div>';}
                else{
                  echo '
                      <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">FN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">MN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">FP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">MP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">PA</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                    </div>
                  </div>
                </div>';
                }
                
                ?>
                 <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                    <h6 class="d-flex align-items-center mb-3 text">Education Details</h6> 
                      <?php
                      if($num_education > 0){
                      echo '
                      <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">School</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      '.$Educationdetails['schoolname'].'
                    </div>
                  </div>
              
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Tenth Marks</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Educationdetails['tenthmark'].' '.$Educationdetails['tenthmarkcategory'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">College</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Educationdetails['collegename'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">12th mark</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Educationdetails['twthmark'].' '.$Educationdetails['twthmarkcategory'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">University</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Educationdetails['universityname'].'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">University mark</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    '.$Educationdetails['unicgoa'].'CGPA
                    </div>
                  </div>
                  <hr>
                    </div>
                  </div>
                </div>';}
                else{
                  echo '
                      <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">FN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">MN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">FP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">MP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">PA</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    Update Profile
                    </div>
                  </div>
                  <hr>
                    </div>
                  </div>
                </div>';
                }
                
                ?>
              </div>
            </div>
          </div>
        </div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>