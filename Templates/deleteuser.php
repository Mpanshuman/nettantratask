<?php 
session_start();
$result = false;
if(!isset($_SESSION['loggedin']) ||$_SESSION['loggedin']!= true ){
    header('location: login.php');
    exit;
}

else{
    include 'partials/_dbconnect.php';
    $userid= $_GET['id'];
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` = '$username')";
    $result = mysqli_query($conn,$sql);
    $Userdata = mysqli_fetch_assoc($result);
    if($userid != $Userdata['id']){
    $sql = "DELETE FROM `users` WHERE `id` = $userid ";
    $result = mysqli_query($conn,$sql);
    $sql = "DELETE FROM `userdetails` WHERE `id` = $userid ";
    $result = mysqli_query($conn,$sql);
    $sql = "DELETE FROM `addressdetails` WHERE `id` = $userid ";
    $result = mysqli_query($conn,$sql);
    $sql = "DELETE FROM `profilepic` WHERE `id` = $userid ";
    $result = mysqli_query($conn,$sql);

    if($result){
        header('location:testdashboard.php');
    }
    else{
        echo 'error';
    }
}
else{
    header('location:testdashboard.php');
}

}


?>