<?php
	require_once('header.php');

  if(isset($_GET['mtid'])){
    $mtid = $_GET['mtid'];
    $un = $_SESSION['user_name'];
   // echo "The meeting ID you joined is: ".$mtid."<br>";
   // echo "Your user name is: ".$un."<br>";
    $query = "INSERT INTO RSVP VALUES('$mtid', '$un')";
    $response = @mysqli_query($db, $query);  
    echo "<script type='text/javascript'>       
    alert('Update saved, redirecting to client center!');
    window.location.href='meetings?mtid=$mtid';
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