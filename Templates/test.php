<?php
session_start();
$row = false;
$num = 0;
if(!isset($_SESSION['loggedin']) ||$_SESSION['loggedin']!= true ){
    header('location: login.php');
    exit;
}
else{
include 'partials/_dbconnect.php';
 $sql = "SELECT * FROM `users`";
 $result = mysqli_query($conn,$sql);
 $num = mysqli_num_rows($result);
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
<?php
    echo '<h3>You have logged in!!!</h3>'.$_SESSION['username'];
    
    ?>
    <a href="logout.php">logout</a> <br>
    

    <!-- Table of users registered -->
    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">View</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <!-- <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr> -->
    <?php 
    if($num > 0){
        
        while($row = mysqli_fetch_assoc($result)){
         echo '<tr>';
         echo "<th scope='row'>".$row['id']."</th>";
         echo "<td>".$row['username']."</td>";
         echo "<td>".$row['email']."</td>";
         echo "<td>".$row['password']."</td>";
         echo "<td>"."<a href='viewprofile.php?user=".$row['username']."' class='btn btn-primary'>View</a>"."</td>";
         echo "<td>"."<a href='edituser.php?user=".$row['username']."' class='btn btn-primary'><i class='fas fa-edit'></i>"."</td>";
         echo "<td>"."<a href='deleteprofile.php?user=".$row['username']."' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>";
         echo '</tr>';
        }
    }
    else{
        echo 'No user registered';
    }
    ?>
  </tbody>
</table>


   
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>