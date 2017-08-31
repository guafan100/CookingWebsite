<?php
  require_once('header.php');
  
  if(isset($_GET['gid'])){
    $gid = $_GET['gid'];
    $un = $_SESSION['user_name'];
   // echo "The group ID you joined is: ".$gid."<br>";
  //  echo "Your user name is: ".$un."<br>";
    $query = "INSERT INTO joins VALUES('$gid', '$un')";
    $response = @mysqli_query($db, $query);  
      echo "<script type='text/javascript'>       
    window.location.href='groups?gid=$gid';
    </script>";   
  }
  else{
      echo "<script type='text/javascript'>       
    alert('which group you want to join?');
    window.location.href='clientHome.php';
    </script>";
  }

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Groups</title>
  </head>

  <body>

    <div class="section-preview">

      <div class="container">






      </div>

    </div>

</body>
</html>