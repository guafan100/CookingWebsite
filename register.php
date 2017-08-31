<?php
  require_once('dbconnection.php'); 
  session_start();


  if(!isset($_GET['err'])) {
    $errorMessage = '<h4>&nbsp</h4>';
  } else {
    if($_GET['err'] == 1) {
      $errorMessage = '<h4 style="color: red">Loginname exists</h4>';
    }else if($_GET['err'] == 2) {
      $errorMessage = '<h4 style="color: red">Username exists</h4>';
    }    
  }

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CZ Register</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/login-page.css">


    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
  </head>

<body>
  <header>
  </header>

  <div class="content wrap shadow rounded">
    <div class="login-content">

      <section class="col col2">
        <div class="login">
          <form action="" method="post" name="login" id="login">

            <h1>CZ Register</h1>
                                            <p>
                <strong>Register to CookZilla</strong>
              </p>

            <label for="loginname">Loginname</label>
            <input type="text" name="loginname" id="lname" required value="" maxlength="16" minlength="5">
            <label for="username">Username</label>
            <input type="text" autocomplete="off" name="uname" id="uname" autofocus required value="" maxlength="16" minlength="5">

            <label for="password">Password</label>
            <input type="password" name="pass" id="password" required value="" maxlength="16" minlength="5">
            <!--
            <input type="submit" value="Login" class="uppercase rounded" name="_eventId_proceed" >
            -->
            <button type="submit" style="margin:0; padding:0; display:block; width:100%; max-width:500px; height:40px; background-color:#dd1b4d; text-align:center; font:bold 18px/40px helvetica, arial, sans-serif; color:#FFF; border:0; -webkit-appearance: none; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; cursor:pointer;" name="next" >
            Register</button>
            
            <?php echo $errorMessage; ?>
            
          </form>
        </div>
      </section>
        <!--/leftcol-->
        <!--rightcol-->
        <div class="col col2 terms">
          <p>
            By your use of these resources, you agree to abide by the
            <a href="#">
            Policy on Responsible Use of Cookzilla Data.</a>
          </p>
          <div><hr/></div>
                    <p>If you have any suggestion or question, please contact : <b>luo2372@gmail.com</b></p>
        </div>
      
    </div>
  </div>

  <footer class="wrap">
    <nav>
      <ul class="clearfix">
        <li class="left"><a href="login.php" class="nav-help">login</a></li>
      </ul>
    </nav>
  </footer>


</body>
</html>

<?php

if(isset($_POST['next'])){ 
    $query = $db->query("SELECT * FROM User where loginname = '$_POST[loginname]' ");
    $row = $query->fetch_array(MYSQLI_ASSOC);

    $query1= $db->query("SELECT * FROM User where uname = '$_POST[uname]' ");
    $row1 = $query1->fetch_array(MYSQLI_ASSOC);

    if(count($row['loginname']) != 0 ){   
      echo "<script type='text/javascript'>
      window.location.href='register.php?err=1';
      </script>"; 
     } 
    else if(count($row1['uname']) != 0){
            echo "<script type='text/javascript'>
      window.location.href='register.php?err=2';
      </script>"; 
    }
    else{
      $query2 = $db->query("INSERT INTO User (uname, loginname, password) VALUES ('$_POST[uname]', '$_POST[loginname]', '$_POST[pass] ') ");

      echo "<script type='text/javascript'>
        window.location.href='login.php?reg=1'
        </script>";
    }
  }
?>