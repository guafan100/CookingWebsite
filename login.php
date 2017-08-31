<?php
  require_once('dbconnection.php');
  
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    session_unset(); 
  }
  if(!isset($_GET['err']) && !isset($_GET['reg']) ) {
    $wrongPasswordMessage = '<h4>&nbsp</h4>';
  } else {
      if($_GET['err'] == 1) {
        $wrongPasswordMessage = '<h4 style="color: red">Wrong password</h4>';
      }else if($_GET['reg'] == 1){
        $wrongPasswordMessage = '<h4 style="color: red">Register successfully</h4>';
      }
  }

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CZ Login</title>
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
            
            <h1>CZ Login</h1>
                                            <p>
                <strong>Login to CookZilla</strong>
              </p>
                        <label for="loginname">Loginname</label>
            <input type="text" autocomplete="off" name="user" id="netid" autofocus required value="">

            <label for="password">Password</label>
            <input type="password" name="pass" id="password" required value="">
            <!--
            <input type="submit" value="Login" class="uppercase rounded" name="_eventId_proceed" >
            -->
            <button type="submit" style="margin:0; padding:0; display:block; width:100%; max-width:500px; height:40px; background-color:#dd1b4d; text-align:center; font:bold 18px/40px helvetica, arial, sans-serif; color:#FFF; border:0; -webkit-appearance: none; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; cursor:pointer;" name="_eventId_proceed" 
            onClick="this.childNodes[0].nodeValue='Logging in ... '">
            Login</button>

            <?php echo $wrongPasswordMessage; ?>
            
            
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
        <li class="left"><a href="register.php" class="nav-help">New User?</a></li>
      </ul>
    </nav>
  </footer>


</body>
</html>

<?php
  if(isset($_POST['user'])){ 
    $query = $db->query("SELECT * FROM User where loginname = '$_POST[user]' AND password = '$_POST[pass]'");
    $row = $query->fetch_array(MYSQLI_ASSOC); 
    if(count($row['loginname']) == 1){ 
      $_SESSION['loginname'] = $_POST['user'];
      $_SESSION['loggedin'] = true;
      echo "<script type='text/javascript'>
      window.location.href='users.php';
      </script>";   
     } 
    else{ 
      echo "<script type='text/javascript'>
      window.location.href='login.php?err=1';
      </script>"; 

    }   
  }


?>