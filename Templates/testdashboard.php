<?php
session_start();
$row = false;
$num = 0;
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header('location: login.php');
  exit;
} else {
  include 'partials/_dbconnect.php';
  $sql = "SELECT * FROM `users`";
  $result = mysqli_query($conn, $sql);
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
  <!--Custom styles-->
  <link rel="stylesheet" type="text/css" href="Css/dashboard.css">
  <title>Document</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="testdashboard.php">Nettantra</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item float-right">
          <?php echo '<a class="nav-link" >Welcome ' . $_SESSION['username'] . '</a>'; ?>
        </li>
        <li class="nav-item float-right">
          <a class="nav-link" href="logout.php">Log out</a>
        </li>

      </ul>

    </div>
  </nav>

  <div class="container-fluid" id="main">
    <div class="row row-offcanvas row-offcanvas-left">
      <div class="col-md-3 col-lg-2 sidebar-offcanvas bg-light pl-0" id="sidebar" role="navigation">
        <ul class="nav flex-column sticky-top pl-0 pt-2 mt-3">
          <li class="nav-item"><a class="nav-link" href="testdashboard.php"><span class="mr-2"><i class="fas fa-tachometer-alt"></i></span>Overview</a></li>
          <li class="nav-item"><a class="nav-link" href="userprofile.php"><span class="mr-2"><i class="fas fa-user"></i></span>Profile</a></li>
          
        </ul>
      </div>

      <div class="container mt-3">
        <!-- Table of users registered -->
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Username</th>
              <th scope="col">Email</th>
              <th scope="col">View</th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>

            <?php
            if ($num > 0) {
              $no = 1;
              while ($row = mysqli_fetch_assoc($result)) {

                echo '<tr>';
                echo "<th scope='row'>" . $no . "</th>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . "<a href='viewprofile.php?user=" . $row['username'] . "' class='btn btn-primary'>View</a>" . "</td>";
                echo "<td>" . "<a href='edituser.php?user=" . $row['username'] . "' class='btn btn-primary'><i class='fas fa-edit'></i>" . "</td>";
                echo "<td>" . "<a href='deleteuser.php?id=" . $row['id'] . "' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></a>" . "</td>";
                echo '</tr>';
                $no = $no + 1;
              }
            } else {
              echo 'No user registered';
            }
            ?>
          </tbody>
        </table>
      </div>


      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>