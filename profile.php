<?php
	require_once('header.php');



if(isset($_POST['info'])) {
  $new_info = $_POST['info']; 
  $db_uname = $_SESSION['user_name'];
  $query = $db->query("UPDATE User SET uinfo='$new_info' WHERE uname = '$db_uname' ");
  // echo "<script type='text/javascript'>       
  //   window.location.href='users';
  //   </script>";  
  echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Well done!</strong> You successfully updated your profile. Want to go to  <a href="users.php" class="alert-link">home page</a> ?.
</div>';
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
  </head>

  <body>

    <div class="section-preview">

      <div class="container">


        <div class="col-lg-8">
          <div class="well bs-component">

            <form class="form-horizontal" role="form" action = "profile.php" method="POST" enctype="multipart/form-data">
              <fieldset>
                <legend>Please Enter Your Details</legend>

                <div class="form-group">
                  <label for="pro" class="col-lg-2 control-label">Profile</label>
                  <div class="col-lg-10">
                    <textarea class="form-control" id="input_pro" type="text" name="info" rows = "5" maxlength = 500></textarea>
                    <span class="help-block">Enter your new profile</span>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>

                  </div>
                </div>
              </fieldset>
            </form>

          </div>
        </div>



      </div>

    </div>

</body>
</html>